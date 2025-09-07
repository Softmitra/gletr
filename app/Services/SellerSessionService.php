<?php

namespace App\Services;

use App\Contracts\SellerSessionRepositoryInterface;
use App\Contracts\SellerSessionServiceInterface;
use App\Models\Seller;
use App\Models\SellerSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SellerSessionService implements SellerSessionServiceInterface
{
    protected SellerSessionRepositoryInterface $sessionRepository;

    public function __construct(SellerSessionRepositoryInterface $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    /**
     * Get sessions with filters and pagination
     */
    public function getSessionsWithFilters(array $filters, int $perPage = 20): LengthAwarePaginator
    {
        return $this->sessionRepository->getPaginatedSessions($filters, $perPage);
    }

    /**
     * Get session statistics for dashboard
     */
    public function getDashboardStats(): array
    {
        return $this->sessionRepository->getSessionStats();
    }

    /**
     * Get analytics data for admin dashboard
     */
    public function getAnalyticsData(int $period = 7): array
    {
        return $this->sessionRepository->getAnalyticsData($period);
    }

    /**
     * Create new session for seller login
     */
    public function createLoginSession(Seller $seller, Request $request): SellerSession
    {
        // Create new session
        $session = $this->sessionRepository->createSession($seller, $request);

        // Clean up old sessions
        $this->cleanupOldSessions($seller->id);

        // Log successful login
        Log::info('Seller login session created', [
            'seller_id' => $seller->id,
            'session_id' => $session->session_id,
            'ip_address' => $request->ip(),
            'device_type' => $session->device_type,
            'location' => $session->location,
        ]);

        return $session;
    }

    /**
     * Handle seller logout and session cleanup
     */
    public function handleLogout(Seller $seller, string $sessionId): bool
    {
        $session = $this->sessionRepository->findBySessionId($sessionId);
        
        if (!$session || $session->seller_id !== $seller->id) {
            return false;
        }

        $success = $this->sessionRepository->markSessionAsLoggedOut($session);

        if ($success) {
            Log::info('Seller logout completed', [
                'seller_id' => $seller->id,
                'session_id' => $sessionId,
                'session_duration' => $session->login_at->diffForHumans($session->logout_at ?? now(), true),
            ]);
        }

        return $success;
    }

    /**
     * Terminate specific session (admin action)
     */
    public function terminateSession(int $sessionId, int $adminId, string $reason = null): bool
    {
        $session = $this->sessionRepository->findSession($sessionId);
        
        if (!$session || !$session->is_active) {
            return false;
        }

        $success = $this->sessionRepository->terminateSession($session);

        if ($success) {
            // Log admin action
            Log::info('Admin terminated seller session', [
                'admin_id' => $adminId,
                'seller_id' => $session->seller_id,
                'session_id' => $session->session_id,
                'reason' => $reason ?? 'Terminated by admin',
                'terminated_at' => now()
            ]);
        }

        return $success;
    }

    /**
     * Terminate all sessions for a seller (admin action)
     */
    public function terminateAllSellerSessions(int $sellerId, int $adminId, string $reason = null): int
    {
        $terminatedCount = $this->sessionRepository->terminateAllSessionsForSeller($sellerId);

        if ($terminatedCount > 0) {
            Log::info('Admin terminated all seller sessions', [
                'admin_id' => $adminId,
                'seller_id' => $sellerId,
                'terminated_sessions' => $terminatedCount,
                'reason' => $reason ?? 'All sessions terminated by admin',
                'terminated_at' => now()
            ]);
        }

        return $terminatedCount;
    }

    /**
     * Terminate other sessions for seller (seller action)
     */
    public function terminateOtherSessions(int $sellerId, string $currentSessionId): int
    {
        $terminatedCount = $this->sessionRepository->terminateAllSessionsForSeller($sellerId, $currentSessionId);

        if ($terminatedCount > 0) {
            Log::info('Seller terminated other sessions', [
                'seller_id' => $sellerId,
                'current_session_id' => $currentSessionId,
                'terminated_sessions' => $terminatedCount,
                'terminated_at' => now()
            ]);
        }

        return $terminatedCount;
    }

    /**
     * Get session details with analytics
     */
    public function getSessionDetails(int $sessionId): ?array
    {
        $session = $this->sessionRepository->findSession($sessionId);
        
        if (!$session) {
            return null;
        }

        $analytics = $this->sessionRepository->getSellerSessionAnalytics($session->seller_id);
        $otherSessions = $this->sessionRepository->getSessionsForSeller($session->seller_id, 10);

        return [
            'session' => $session,
            'analytics' => $analytics,
            'other_sessions' => $otherSessions->where('id', '!=', $session->id),
            'security_insights' => $this->validateSessionSecurity($session),
        ];
    }

    /**
     * Get seller session analytics
     */
    public function getSellerSessionAnalytics(int $sellerId): array
    {
        return $this->sessionRepository->getSellerSessionAnalytics($sellerId);
    }

    /**
     * Update session activity (middleware)
     */
    public function updateSessionActivity(string $sessionId): bool
    {
        $session = $this->sessionRepository->findBySessionId($sessionId);
        
        if (!$session || !$session->is_active) {
            return false;
        }

        return $this->sessionRepository->updateSessionActivity($session);
    }

    /**
     * Detect and get suspicious activities
     */
    public function getSuspiciousActivities(): array
    {
        $suspiciousCount = $this->sessionRepository->getSuspiciousActivitiesCount();
        
        $activities = [];
        
        // Get detailed suspicious activities
        $multipleIPs = $this->getMultipleIPActivities();
        $rapidLogins = $this->getRapidLoginActivities();
        $unusualHours = $this->getUnusualHourActivities();

        return [
            'total_count' => $suspiciousCount,
            'multiple_ips' => $multipleIPs,
            'rapid_logins' => $rapidLogins,
            'unusual_hours' => $unusualHours,
        ];
    }

    /**
     * Get session activity timeline for seller
     */
    public function getSessionActivityTimeline(int $sellerId): array
    {
        $sessions = $this->sessionRepository->getSessionsForSeller($sellerId, 50);
        
        return $sessions->groupBy(function($session) {
            return $session->login_at->format('Y-m-d');
        })->map(function($dailySessions, $date) {
            return [
                'date' => $date,
                'sessions' => $dailySessions->map(function($session) {
                    return [
                        'id' => $session->id,
                        'login_time' => $session->login_at->format('H:i:s'),
                        'device' => $session->device_type,
                        'location' => $session->location ?? $session->ip_address,
                        'status' => $session->is_active ? 'Active' : 'Ended',
                        'duration' => $session->logout_at 
                            ? $session->login_at->diffForHumans($session->logout_at, true)
                            : $session->login_at->diffForHumans(now(), true),
                    ];
                })->toArray(),
            ];
        })->values()->toArray();
    }

    /**
     * Cleanup old sessions for seller
     */
    public function cleanupOldSessions(int $sellerId): int
    {
        return $this->sessionRepository->cleanupOldSessions($sellerId, 50);
    }

    /**
     * Validate session security
     */
    public function validateSessionSecurity(SellerSession $session): array
    {
        $insights = [];
        
        // Check for multiple recent IPs
        $recentSessions = $this->sessionRepository->getSessionsByCriteria([
            'seller_id' => $session->seller_id,
        ])->where('login_at', '>=', Carbon::now()->subDays(7));
        
        $uniqueIPs = $recentSessions->pluck('ip_address')->unique();
        if ($uniqueIPs->count() > 3) {
            $insights[] = [
                'type' => 'multiple_ips',
                'severity' => 'medium',
                'message' => "Multiple IP addresses ({$uniqueIPs->count()}) used in last 7 days",
                'data' => $uniqueIPs->toArray(),
            ];
        }

        // Check for unusual login time
        $loginHour = $session->login_at->hour;
        if ($loginHour >= 23 || $loginHour <= 5) {
            $insights[] = [
                'type' => 'unusual_hour',
                'severity' => 'low',
                'message' => 'Login during unusual hours (11 PM - 5 AM)',
                'data' => ['hour' => $loginHour],
            ];
        }

        // Check session duration
        if ($session->is_active) {
            $duration = $session->login_at->diffInHours(now());
            if ($duration > 24) {
                $insights[] = [
                    'type' => 'long_session',
                    'severity' => 'low',
                    'message' => "Session active for {$duration} hours",
                    'data' => ['duration_hours' => $duration],
                ];
            }
        }

        return $insights;
    }

    /**
     * Get session insights for seller dashboard
     */
    public function getSellerSessionInsights(int $sellerId): array
    {
        $analytics = $this->sessionRepository->getSellerSessionAnalytics($sellerId);
        $activeSessions = $this->sessionRepository->getActiveSessionsForSeller($sellerId);
        
        return [
            'total_sessions' => $analytics['total_sessions'],
            'active_sessions' => $activeSessions->count(),
            'most_used_device' => $analytics['most_used_device'],
            'recent_locations' => $analytics['login_locations'],
            'security_score' => $this->calculateSecurityScore($sellerId),
            'recommendations' => $this->getSecurityRecommendations($sellerId),
        ];
    }

    // Private helper methods

    private function getMultipleIPActivities(): array
    {
        // Implementation for detecting multiple IP activities
        return [];
    }

    private function getRapidLoginActivities(): array
    {
        // Implementation for detecting rapid login activities
        return [];
    }

    private function getUnusualHourActivities(): array
    {
        // Implementation for detecting unusual hour activities
        return [];
    }

    private function calculateSecurityScore(int $sellerId): int
    {
        $score = 100;
        
        // Deduct points for security issues
        $recentSessions = $this->sessionRepository->getSessionsForSeller($sellerId, 20);
        
        // Multiple IPs
        $uniqueIPs = $recentSessions->pluck('ip_address')->unique();
        if ($uniqueIPs->count() > 5) {
            $score -= 20;
        }
        
        // Too many active sessions
        $activeSessions = $recentSessions->where('is_active', true);
        if ($activeSessions->count() > 3) {
            $score -= 15;
        }
        
        return max(0, $score);
    }

    private function getSecurityRecommendations(int $sellerId): array
    {
        $recommendations = [];
        
        $activeSessions = $this->sessionRepository->getActiveSessionsForSeller($sellerId);
        
        if ($activeSessions->count() > 3) {
            $recommendations[] = [
                'type' => 'multiple_sessions',
                'message' => 'You have multiple active sessions. Consider terminating unused sessions.',
                'action' => 'terminate_sessions',
            ];
        }
        
        return $recommendations;
    }
}
