<?php

namespace App\Repositories;

use App\Contracts\SellerSessionRepositoryInterface;
use App\Models\Seller;
use App\Models\SellerSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SellerSessionRepository implements SellerSessionRepositoryInterface
{
    /**
     * Get paginated sessions with filters
     */
    public function getPaginatedSessions(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = SellerSession::with('seller');

        // Apply filters
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->where('is_active', true);
            } elseif ($filters['status'] === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if (!empty($filters['seller_id'])) {
            $query->where('seller_id', $filters['seller_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('login_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('login_at', '<=', $filters['date_to'] . ' 23:59:59');
        }

        if (!empty($filters['device_type'])) {
            $query->where('device_type', $filters['device_type']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('seller', function($q) use ($filters) {
                $q->where('business_name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%")
                  ->orWhere('contact_person', 'like', "%{$filters['search']}%");
            })->orWhere('ip_address', 'like', "%{$filters['search']}%")
              ->orWhere('location', 'like', "%{$filters['search']}%");
        }

        return $query->orderBy('login_at', 'desc')->paginate($perPage);
    }

    /**
     * Get session statistics
     */
    public function getSessionStats(): array
    {
        return [
            'total_sessions' => SellerSession::count(),
            'active_sessions' => SellerSession::where('is_active', true)->count(),
            'sessions_today' => SellerSession::whereDate('login_at', today())->count(),
            'sessions_this_week' => SellerSession::where('login_at', '>=', Carbon::now()->startOfWeek())->count(),
            'unique_sellers' => SellerSession::distinct('seller_id')->count(),
            'unique_devices' => SellerSession::distinct('device_type')->count(),
            'unique_locations' => SellerSession::whereNotNull('location')->distinct('location')->count(),
            'suspicious_activities' => $this->getSuspiciousActivitiesCount(),
        ];
    }

    /**
     * Get analytics data for a period
     */
    public function getAnalyticsData(int $days): array
    {
        $startDate = Carbon::now()->subDays($days);

        return [
            'daily_sessions' => $this->getDailySessions($startDate),
            'device_stats' => $this->getDeviceStats($startDate),
            'browser_stats' => $this->getBrowserStats($startDate),
            'location_stats' => $this->getLocationStats($startDate),
            'active_seller_stats' => $this->getActiveSellerStats($startDate),
        ];
    }

    /**
     * Find session by ID
     */
    public function findSession(int $sessionId): ?SellerSession
    {
        return SellerSession::with('seller')->find($sessionId);
    }

    /**
     * Find session by session ID string
     */
    public function findBySessionId(string $sessionId): ?SellerSession
    {
        return SellerSession::where('session_id', $sessionId)->first();
    }

    /**
     * Get active sessions for seller
     */
    public function getActiveSessionsForSeller(int $sellerId): Collection
    {
        return SellerSession::where('seller_id', $sellerId)
            ->where('is_active', true)
            ->orderBy('login_at', 'desc')
            ->get();
    }

    /**
     * Get all sessions for seller
     */
    public function getSessionsForSeller(int $sellerId, int $limit = null): Collection
    {
        $query = SellerSession::where('seller_id', $sellerId)
            ->orderBy('login_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Create new session
     */
    public function createSession(Seller $seller, Request $request): SellerSession
    {
        return SellerSession::createSession($seller, $request);
    }

    /**
     * Update session activity
     */
    public function updateSessionActivity(SellerSession $session): bool
    {
        return $session->update(['last_activity' => now()]);
    }

    /**
     * Mark session as logged out
     */
    public function markSessionAsLoggedOut(SellerSession $session): bool
    {
        return $session->update([
            'logout_at' => now(),
            'is_active' => false,
        ]);
    }

    /**
     * Terminate session
     */
    public function terminateSession(SellerSession $session): bool
    {
        return $this->markSessionAsLoggedOut($session);
    }

    /**
     * Terminate all sessions for seller except current
     */
    public function terminateAllSessionsForSeller(int $sellerId, string $currentSessionId = null): int
    {
        $query = SellerSession::where('seller_id', $sellerId)
            ->where('is_active', true);

        if ($currentSessionId) {
            $query->where('session_id', '!=', $currentSessionId);
        }

        return $query->update([
            'logout_at' => now(),
            'is_active' => false,
        ]);
    }

    /**
     * Get suspicious activities count
     */
    public function getSuspiciousActivitiesCount(): int
    {
        $count = 0;
        
        try {
            // Multiple IPs in short time
            $multipleIPs = DB::select("
                SELECT COUNT(*) as count 
                FROM (
                    SELECT seller_id 
                    FROM seller_sessions 
                    WHERE login_at >= ? 
                    GROUP BY seller_id 
                    HAVING COUNT(DISTINCT ip_address) > 3
                ) as temp
            ", [Carbon::now()->subHours(24)]);
            
            $count += $multipleIPs[0]->count ?? 0;
            
            // Rapid logins
            $rapidLogins = DB::select("
                SELECT COUNT(*) as count 
                FROM (
                    SELECT seller_id 
                    FROM seller_sessions 
                    WHERE login_at >= ? 
                    GROUP BY seller_id 
                    HAVING COUNT(*) > 5
                ) as temp
            ", [Carbon::now()->subHours(1)]);
            
            $count += $rapidLogins[0]->count ?? 0;
            
        } catch (\Exception $e) {
            \Log::warning('Error calculating suspicious activities', [
                'error' => $e->getMessage()
            ]);
            return 0;
        }
        
        return $count;
    }

    /**
     * Get session analytics for specific seller
     */
    public function getSellerSessionAnalytics(int $sellerId): array
    {
        return [
            'total_sessions' => SellerSession::where('seller_id', $sellerId)->count(),
            'active_sessions' => SellerSession::where('seller_id', $sellerId)->where('is_active', true)->count(),
            'avg_session_duration' => $this->getAverageSessionDuration($sellerId),
            'most_used_device' => $this->getMostUsedDevice($sellerId),
            'login_locations' => $this->getLoginLocations($sellerId),
            'recent_activities' => $this->getRecentActivities($sellerId),
        ];
    }

    /**
     * Clean up old inactive sessions
     */
    public function cleanupOldSessions(int $sellerId, int $keepCount = 50): int
    {
        $oldSessions = SellerSession::where('seller_id', $sellerId)
            ->where('is_active', false)
            ->orderBy('logout_at', 'desc')
            ->skip($keepCount)
            ->pluck('id');
            
        if ($oldSessions->isNotEmpty()) {
            return SellerSession::whereIn('id', $oldSessions)->delete();
        }
        
        return 0;
    }

    /**
     * Get sessions by criteria
     */
    public function getSessionsByCriteria(array $criteria): Collection
    {
        $query = SellerSession::query();

        foreach ($criteria as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query->get();
    }

    /**
     * Count sessions by criteria
     */
    public function countSessionsByCriteria(array $criteria): int
    {
        $query = SellerSession::query();

        foreach ($criteria as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query->count();
    }

    // Private helper methods

    private function getDailySessions(Carbon $startDate): Collection
    {
        return SellerSession::select(
                DB::raw('DATE(login_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(CASE WHEN is_active = 1 THEN 1 END) as active')
            )
            ->where('login_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(login_at)'))
            ->orderBy('date')
            ->get();
    }

    private function getDeviceStats(Carbon $startDate): Collection
    {
        return SellerSession::select('device_type', DB::raw('COUNT(*) as count'))
            ->where('login_at', '>=', $startDate)
            ->groupBy('device_type')
            ->get();
    }

    private function getBrowserStats(Carbon $startDate): Collection
    {
        return SellerSession::select('browser', DB::raw('COUNT(*) as count'))
            ->where('login_at', '>=', $startDate)
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getLocationStats(Carbon $startDate): Collection
    {
        return SellerSession::select('location', DB::raw('COUNT(*) as count'))
            ->where('login_at', '>=', $startDate)
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getActiveSellerStats(Carbon $startDate): Collection
    {
        return SellerSession::select('seller_id', DB::raw('COUNT(*) as session_count'))
            ->with('seller:id,business_name,email')
            ->where('login_at', '>=', $startDate)
            ->groupBy('seller_id')
            ->orderBy('session_count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getAverageSessionDuration(int $sellerId): string
    {
        $sessions = SellerSession::where('seller_id', $sellerId)
            ->whereNotNull('logout_at')
            ->get();
            
        if ($sessions->isEmpty()) {
            return 'N/A';
        }
        
        $totalMinutes = $sessions->sum(function($session) {
            return $session->login_at->diffInMinutes($session->logout_at);
        });
        
        $avgMinutes = $totalMinutes / $sessions->count();
        
        if ($avgMinutes < 60) {
            return round($avgMinutes) . ' minutes';
        }
        
        return round($avgMinutes / 60, 1) . ' hours';
    }

    private function getMostUsedDevice(int $sellerId): ?string
    {
        return SellerSession::where('seller_id', $sellerId)
            ->select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->orderBy('count', 'desc')
            ->first()
            ?->device_type;
    }

    private function getLoginLocations(int $sellerId): array
    {
        return SellerSession::where('seller_id', $sellerId)
            ->whereNotNull('location')
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    private function getRecentActivities(int $sellerId): array
    {
        return SellerSession::where('seller_id', $sellerId)
            ->orderBy('login_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($session) {
                return [
                    'date' => $session->login_at->format('M d, Y H:i'),
                    'device' => $session->device_type,
                    'location' => $session->location ?? $session->ip_address,
                    'status' => $session->is_active ? 'Active' : 'Ended',
                ];
            })
            ->toArray();
    }
}
