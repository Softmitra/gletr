<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSession;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display users list with session and activity information
     */
    public function index(Request $request)
    {
        $query = User::with(['roles', 'sessions', 'activities'])
            ->withCount(['sessions', 'activities']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $users = $query->paginate(20)->withQueryString();

        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'suspended_users' => User::where('status', 'suspended')->count(),
            'banned_users' => User::where('status', 'banned')->count(),
            'online_users' => UserSession::active()->count(),
            'today_logins' => UserActivity::logins()->whereDate('created_at', today())->count(),
        ];

        // Get roles for filter
        $roles = \Spatie\Permission\Models\Role::all();

        return view('admin.users.index', compact('users', 'stats', 'roles'));
    }

    /**
     * Show user details with sessions and activities
     */
    public function show(User $user)
    {
        $user->load(['roles', 'sessions', 'activities']);

        // Get recent sessions
        $recentSessions = $user->sessions()
            ->with('activities')
            ->latest('login_at')
            ->take(10)
            ->get();

        // Get recent activities
        $recentActivities = $user->activities()
            ->with('session')
            ->latest()
            ->take(20)
            ->get();

        // Get activity statistics
        $activityStats = [
            'total_logins' => $user->activities()->logins()->count(),
            'total_logouts' => $user->activities()->logouts()->count(),
            'total_page_views' => $user->activities()->pageViews()->count(),
            'total_actions' => $user->activities()->actions()->count(),
            'last_activity' => $user->activities()->latest()->first(),
            'avg_session_duration' => $user->sessions()
                ->whereNotNull('logout_at')
                ->avg(DB::raw('TIMESTAMPDIFF(SECOND, login_at, logout_at)')),
        ];

        // Get activity by type chart data
        $activityByType = $user->activities()
            ->selectRaw('activity_type, COUNT(*) as count')
            ->groupBy('activity_type')
            ->pluck('count', 'activity_type')
            ->toArray();

        // Get activity by date chart data (last 30 days)
        $activityByDate = $user->activities()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('admin.users.show', compact(
            'user',
            'recentSessions',
            'recentActivities',
            'activityStats',
            'activityByType',
            'activityByDate'
        ));
    }

    /**
     * Show user sessions
     */
    public function sessions(User $user, Request $request)
    {
        $query = $user->sessions()->with('activities');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } else {
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

        $sessions = $query->latest('login_at')->paginate(20)->withQueryString();

        $stats = [
            'total_sessions' => $user->sessions()->count(),
            'active_sessions' => $user->sessions()->active()->count(),
            'total_duration' => $user->sessions()
                ->whereNotNull('logout_at')
                ->sum(DB::raw('TIMESTAMPDIFF(SECOND, login_at, logout_at)')),
            'avg_duration' => $user->sessions()
                ->whereNotNull('logout_at')
                ->avg(DB::raw('TIMESTAMPDIFF(SECOND, login_at, logout_at)')),
        ];

        return view('admin.users.sessions', compact('user', 'sessions', 'stats'));
    }

    /**
     * Show user activities
     */
    public function activities(User $user, Request $request)
    {
        $query = $user->activities()->with('session');

        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by resource type
        if ($request->filled('resource_type')) {
            $query->where('resource_type', $request->resource_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $activities = $query->latest()->paginate(50)->withQueryString();

        $stats = [
            'total_activities' => $user->activities()->count(),
            'today_activities' => $user->activities()->whereDate('created_at', today())->count(),
            'this_week_activities' => $user->activities()->where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month_activities' => $user->activities()->where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Get activity types for filter
        $activityTypes = $user->activities()
            ->select('activity_type')
            ->distinct()
            ->pluck('activity_type');

        return view('admin.users.activities', compact('user', 'activities', 'stats', 'activityTypes'));
    }

    /**
     * Terminate user session
     */
    public function terminateSession(UserSession $session)
    {
        $session->markInactive('admin_terminated');
        
        return back()->with('success', 'Session terminated successfully.');
    }

    /**
     * Terminate all user sessions
     */
    public function terminateAllSessions(User $user)
    {
        $user->sessions()->active()->update([
            'is_active' => false,
            'logout_at' => now(),
            'logout_reason' => 'admin_terminated_all',
        ]);

        return back()->with('success', 'All user sessions terminated successfully.');
    }

    /**
     * Suspend user
     */
    public function suspend(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $user->suspend($request->reason);

        // Terminate all active sessions
        $user->sessions()->active()->update([
            'is_active' => false,
            'logout_at' => now(),
            'logout_reason' => 'user_suspended',
        ]);

        return back()->with('success', 'User suspended successfully.');
    }

    /**
     * Activate user
     */
    public function activate(User $user)
    {
        $user->activate();

        return back()->with('success', 'User activated successfully.');
    }

    /**
     * Ban user
     */
    public function ban(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $user->ban($request->reason);

        // Terminate all active sessions
        $user->sessions()->active()->update([
            'is_active' => false,
            'logout_at' => now(),
            'logout_reason' => 'user_banned',
        ]);

        return back()->with('success', 'User banned successfully.');
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
            'login_attempts' => 0,
            'locked_until' => null,
        ]);

        // Log the activity
        UserActivity::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'activity_type' => 'action',
            'action' => 'reset_password',
            'resource_type' => 'user',
            'resource_id' => $user->id,
            'description' => 'Password reset for user: ' . $user->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'User password reset successfully.');
    }

    /**
     * Get user activity chart data
     */
    public function activityChart(User $user, Request $request)
    {
        $days = $request->get('days', 30);
        $type = $request->get('type', 'activity_type');

        $query = $user->activities();

        if ($type === 'activity_type') {
            $data = $query->selectRaw('activity_type, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays($days))
                ->groupBy('activity_type')
                ->pluck('count', 'activity_type')
                ->toArray();
        } else {
            $data = $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays($days))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count', 'date')
                ->toArray();
        }

        return response()->json($data);
    }

    /**
     * Export user data
     */
    public function export(User $user)
    {
        // This would typically generate a CSV or Excel file
        // For now, we'll just return a success message
        return back()->with('success', 'User data export feature will be implemented soon.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:suspend,activate,ban,delete,terminate_sessions',
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $count = 0;

        foreach ($users as $user) {
            switch ($request->action) {
                case 'suspend':
                    $user->suspend('Bulk suspension by admin');
                    break;
                case 'activate':
                    $user->activate();
                    break;
                case 'ban':
                    $user->ban('Bulk ban by admin');
                    break;
                case 'terminate_sessions':
                    $user->sessions()->active()->update([
                        'is_active' => false,
                        'logout_at' => now(),
                        'logout_reason' => 'bulk_termination',
                    ]);
                    break;
            }
            $count++;
        }

        $action = str_replace('_', ' ', $request->action);
        return back()->with('success', ucfirst($action) . " applied to {$count} users successfully.");
    }

    /**
     * Show all user sessions (global view).
     */
    public function allSessions(Request $request)
    {
        $query = UserSession::with(['user'])
            ->orderBy('login_at', 'desc');

        // Apply filters
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('device')) {
            $query->where('device_type', $request->device);
        }

        if ($request->filled('browser')) {
            $query->where('browser', 'like', '%' . $request->browser . '%');
        }

        if ($request->filled('date_from')) {
            $query->where('login_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('login_at', '<=', $request->date_to . ' 23:59:59');
        }

        $sessions = $query->paginate(20);

        // Statistics
        $stats = [
            'total_sessions' => UserSession::count(),
            'active_sessions' => UserSession::where('is_active', true)->count(),
            'total_users' => UserSession::distinct('user_id')->count(),
            'today_sessions' => UserSession::whereDate('login_at', today())->count(),
        ];

        return view('admin.users.all-sessions', compact('sessions', 'stats'));
    }

    /**
     * Show all user activities (global view).
     */
    public function allActivities(Request $request)
    {
        $query = UserActivity::with(['user', 'session'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $activities = $query->paginate(20);

        // Statistics
        $stats = [
            'total_activities' => UserActivity::count(),
            'total_logins' => UserActivity::where('activity_type', 'login')->count(),
            'total_page_views' => UserActivity::where('activity_type', 'page_view')->count(),
            'total_actions' => UserActivity::where('activity_type', 'action')->count(),
            'today_activities' => UserActivity::whereDate('created_at', today())->count(),
        ];

        return view('admin.users.all-activities', compact('activities', 'stats'));
    }
}
