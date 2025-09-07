<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    /**
     * Display seller sessions
     */
    public function index(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        
        // Get sessions with filtering
        $query = SellerSession::where('seller_id', $seller->id);
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->inactive();
            }
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('login_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('login_at', '<=', $request->date_to . ' 23:59:59');
        }
        
        $sessions = $query->orderBy('login_at', 'desc')->paginate(20);
        
        // Get statistics
        $stats = [
            'total_sessions' => SellerSession::where('seller_id', $seller->id)->count(),
            'active_sessions' => SellerSession::where('seller_id', $seller->id)->active()->count(),
            'sessions_today' => SellerSession::where('seller_id', $seller->id)
                ->whereDate('login_at', today())->count(),
            'unique_devices' => SellerSession::where('seller_id', $seller->id)
                ->distinct('device_type')->count('device_type'),
        ];
        
        return view('seller.sessions.index', compact('sessions', 'stats'));
    }

    /**
     * Terminate a specific session
     */
    public function destroy(Request $request, $sessionId)
    {
        $seller = Auth::guard('seller')->user();
        
        $session = SellerSession::where('seller_id', $seller->id)
            ->where('session_id', $sessionId)
            ->first();
        
        if (!$session) {
            return back()->withErrors(['error' => 'Session not found.']);
        }
        
        // Don't allow terminating current session
        if ($session->isCurrentSession()) {
            return back()->withErrors(['error' => 'Cannot terminate your current session. Please use logout instead.']);
        }
        
        // Mark session as terminated
        $session->markAsLoggedOut();
        
        // TODO: Invalidate the actual session if it's still active
        // This would require storing session data in database or Redis
        
        return back()->with('success', 'Session terminated successfully.');
    }

    /**
     * Terminate all other sessions
     */
    public function terminateAll(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        $currentSessionId = $request->session()->getId();
        
        // Mark all other sessions as inactive
        $terminatedCount = SellerSession::where('seller_id', $seller->id)
            ->where('session_id', '!=', $currentSessionId)
            ->active()
            ->update([
                'logout_at' => now(),
                'is_active' => false,
            ]);
        
        return back()->with('success', "Terminated {$terminatedCount} other sessions successfully.");
    }

    /**
     * Show session activity details
     */
    public function activity(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        
        // Get recent login activities
        $activities = SellerSession::where('seller_id', $seller->id)
            ->orderBy('login_at', 'desc')
            ->take(50)
            ->get();
        
        // Group activities by date
        $groupedActivities = $activities->groupBy(function($activity) {
            return $activity->login_at->format('Y-m-d');
        });
        
        // Get security insights
        $insights = [
            'unique_ips' => SellerSession::where('seller_id', $seller->id)
                ->distinct('ip_address')->count('ip_address'),
            'most_used_device' => SellerSession::where('seller_id', $seller->id)
                ->select('device_type', DB::raw('count(*) as count'))
                ->groupBy('device_type')
                ->orderBy('count', 'desc')
                ->first(),
            'most_used_browser' => SellerSession::where('seller_id', $seller->id)
                ->select('browser', DB::raw('count(*) as count'))
                ->groupBy('browser')
                ->orderBy('count', 'desc')
                ->first(),
            'suspicious_activities' => $this->detectSuspiciousActivities($seller->id),
        ];
        
        return view('seller.sessions.activity', compact('groupedActivities', 'insights'));
    }

    /**
     * Detect suspicious activities
     */
    private function detectSuspiciousActivities($sellerId): array
    {
        $suspicious = [];
        
        // Check for multiple IPs in short time
        $recentSessions = SellerSession::where('seller_id', $sellerId)
            ->where('login_at', '>=', now()->subHours(24))
            ->get();
        
        $uniqueIPs = $recentSessions->pluck('ip_address')->unique();
        if ($uniqueIPs->count() > 3) {
            $suspicious[] = [
                'type' => 'multiple_ips',
                'message' => 'Multiple IP addresses used in the last 24 hours',
                'count' => $uniqueIPs->count(),
                'severity' => 'medium'
            ];
        }
        
        // Check for unusual login times
        $nightLogins = $recentSessions->filter(function($session) {
            $hour = $session->login_at->hour;
            return $hour >= 23 || $hour <= 5;
        });
        
        if ($nightLogins->count() > 2) {
            $suspicious[] = [
                'type' => 'unusual_hours',
                'message' => 'Multiple logins during unusual hours (11 PM - 5 AM)',
                'count' => $nightLogins->count(),
                'severity' => 'low'
            ];
        }
        
        // Check for rapid successive logins
        $rapidLogins = $recentSessions->filter(function($session, $key) use ($recentSessions) {
            if ($key === 0) return false;
            $previousSession = $recentSessions[$key - 1];
            return $session->login_at->diffInMinutes($previousSession->login_at) < 5;
        });
        
        if ($rapidLogins->count() > 0) {
            $suspicious[] = [
                'type' => 'rapid_logins',
                'message' => 'Multiple logins within short time periods',
                'count' => $rapidLogins->count(),
                'severity' => 'high'
            ];
        }
        
        return $suspicious;
    }
}
