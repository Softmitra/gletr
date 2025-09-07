<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSession;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class UserTrackingService
{
    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Create a new user session
     */
    public function createSession(User $user, Request $request): UserSession
    {
        $sessionData = [
            'user_id' => $user->id,
            'session_id' => $request->session()->getId(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => $this->getDeviceType(),
            'browser' => $this->agent->browser(),
            'platform' => $this->agent->platform(),
            'location' => $this->getLocation($request->ip()),
            'login_at' => now(),
            'last_activity_at' => now(),
            'is_active' => true,
            'session_data' => [
                'user_agent_parsed' => [
                    'device' => $this->agent->device(),
                    'robot' => $this->agent->robot(),
                    'browser_version' => $this->agent->version($this->agent->browser()),
                    'platform_version' => $this->agent->version($this->agent->platform()),
                ]
            ]
        ];

        $session = UserSession::create($sessionData);

        // Log login activity
        $this->logActivity($user, $session, 'login', 'login', 'user', $user->id, 'User logged in successfully');

        return $session;
    }

    /**
     * Update session activity
     */
    public function updateSessionActivity(UserSession $session): void
    {
        $session->updateActivity();
    }

    /**
     * End user session
     */
    public function endSession(UserSession $session, string $reason = 'logout'): void
    {
        $session->markInactive($reason);

        // Log logout activity
        $this->logActivity(
            $session->user,
            $session,
            'logout',
            'logout',
            'user',
            $session->user->id,
            'User logged out'
        );
    }

    /**
     * Log user activity
     */
    public function logActivity(
        User $user,
        ?UserSession $session = null,
        string $activityType = 'action',
        ?string $action = null,
        ?string $resourceType = null,
        ?int $resourceId = null,
        ?string $description = null,
        ?array $metadata = null
    ): UserActivity {
        $activityData = [
            'user_id' => $user->id,
            'user_session_id' => $session?->id,
            'activity_type' => $activityType,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'request_data' => $this->sanitizeRequestData(request()->all()),
            'response_time' => $this->getResponseTime(),
            'status_code' => $this->getStatusCode(),
            'metadata' => $metadata,
        ];

        return UserActivity::create($activityData);
    }

    /**
     * Log page view activity
     */
    public function logPageView(User $user, ?UserSession $session = null, string $page = null): UserActivity
    {
        return $this->logActivity(
            $user,
            $session,
            'page_view',
            'view',
            'page',
            null,
            'Viewed page: ' . ($page ?? request()->path())
        );
    }

    /**
     * Log CRUD activity
     */
    public function logCrudActivity(
        User $user,
        string $action,
        string $resourceType,
        int $resourceId,
        ?string $description = null,
        ?UserSession $session = null
    ): UserActivity {
        return $this->logActivity(
            $user,
            $session,
            'action',
            $action,
            $resourceType,
            $resourceId,
            $description ?? ucfirst($action) . ' ' . $resourceType
        );
    }

    /**
     * Log security activity
     */
    public function logSecurityActivity(
        User $user,
        string $action,
        string $description,
        ?UserSession $session = null
    ): UserActivity {
        return $this->logActivity(
            $user,
            $session,
            'security',
            $action,
            'security',
            null,
            $description
        );
    }

    /**
     * Get device type
     */
    protected function getDeviceType(): string
    {
        if ($this->agent->isTablet()) {
            return 'tablet';
        } elseif ($this->agent->isMobile()) {
            return 'mobile';
        } else {
            return 'desktop';
        }
    }

    /**
     * Get location from IP (placeholder - would use a real geolocation service)
     */
    protected function getLocation(string $ip): ?string
    {
        // This is a placeholder. In a real application, you would use a service like:
        // - MaxMind GeoIP2
        // - IP-API
        // - ipinfo.io
        // For now, we'll return null
        return null;
    }

    /**
     * Sanitize request data to remove sensitive information
     */
    protected function sanitizeRequestData(array $data): array
    {
        $sensitiveFields = ['password', 'password_confirmation', 'token', 'api_key', 'secret'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***HIDDEN***';
            }
        }

        return $data;
    }

    /**
     * Get response time (placeholder)
     */
    protected function getResponseTime(): ?int
    {
        // In a real application, you would measure the actual response time
        // For now, we'll return null
        return null;
    }

    /**
     * Get status code (placeholder)
     */
    protected function getStatusCode(): ?int
    {
        // In a real application, you would get the actual HTTP status code
        // For now, we'll return null
        return null;
    }

    /**
     * Clean up expired sessions
     */
    public function cleanupExpiredSessions(): int
    {
        $expiredSessions = UserSession::where('last_activity_at', '<', now()->subHours(24))
            ->where('is_active', true)
            ->get();

        $count = 0;
        foreach ($expiredSessions as $session) {
            $this->endSession($session, 'timeout');
            $count++;
        }

        return $count;
    }

    /**
     * Get user activity summary
     */
    public function getUserActivitySummary(User $user, int $days = 30): array
    {
        $startDate = now()->subDays($days);

        return [
            'total_activities' => $user->activities()->where('created_at', '>=', $startDate)->count(),
            'login_count' => $user->activities()->logins()->where('created_at', '>=', $startDate)->count(),
            'page_views' => $user->activities()->pageViews()->where('created_at', '>=', $startDate)->count(),
            'actions' => $user->activities()->actions()->where('created_at', '>=', $startDate)->count(),
            'last_activity' => $user->activities()->latest()->first(),
            'most_active_day' => $user->activities()
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', $startDate)
                ->groupBy('date')
                ->orderByDesc('count')
                ->first(),
        ];
    }

    /**
     * Get system-wide activity statistics
     */
    public function getSystemActivityStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);

        return [
            'total_activities' => UserActivity::where('created_at', '>=', $startDate)->count(),
            'total_logins' => UserActivity::logins()->where('created_at', '>=', $startDate)->count(),
            'total_sessions' => UserSession::where('login_at', '>=', $startDate)->count(),
            'active_sessions' => UserSession::active()->count(),
            'unique_users' => UserActivity::where('created_at', '>=', $startDate)->distinct('user_id')->count(),
            'top_activities' => UserActivity::where('created_at', '>=', $startDate)
                ->selectRaw('activity_type, COUNT(*) as count')
                ->groupBy('activity_type')
                ->orderByDesc('count')
                ->limit(5)
                ->pluck('count', 'activity_type')
                ->toArray(),
        ];
    }
}
