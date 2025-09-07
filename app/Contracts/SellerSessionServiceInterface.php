<?php

namespace App\Contracts;

use App\Models\Seller;
use App\Models\SellerSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface SellerSessionServiceInterface
{
    /**
     * Get sessions with filters and pagination
     */
    public function getSessionsWithFilters(array $filters, int $perPage = 20): LengthAwarePaginator;

    /**
     * Get session statistics for dashboard
     */
    public function getDashboardStats(): array;

    /**
     * Get analytics data for admin dashboard
     */
    public function getAnalyticsData(int $period = 7): array;

    /**
     * Create new session for seller login
     */
    public function createLoginSession(Seller $seller, Request $request): SellerSession;

    /**
     * Handle seller logout and session cleanup
     */
    public function handleLogout(Seller $seller, string $sessionId): bool;

    /**
     * Terminate specific session (admin action)
     */
    public function terminateSession(int $sessionId, int $adminId, string $reason = null): bool;

    /**
     * Terminate all sessions for a seller (admin action)
     */
    public function terminateAllSellerSessions(int $sellerId, int $adminId, string $reason = null): int;

    /**
     * Terminate other sessions for seller (seller action)
     */
    public function terminateOtherSessions(int $sellerId, string $currentSessionId): int;

    /**
     * Get session details with analytics
     */
    public function getSessionDetails(int $sessionId): ?array;

    /**
     * Get seller session analytics
     */
    public function getSellerSessionAnalytics(int $sellerId): array;

    /**
     * Update session activity (middleware)
     */
    public function updateSessionActivity(string $sessionId): bool;

    /**
     * Detect and get suspicious activities
     */
    public function getSuspiciousActivities(): array;

    /**
     * Get session activity timeline for seller
     */
    public function getSessionActivityTimeline(int $sellerId): array;

    /**
     * Cleanup old sessions for seller
     */
    public function cleanupOldSessions(int $sellerId): int;

    /**
     * Validate session security
     */
    public function validateSessionSecurity(SellerSession $session): array;

    /**
     * Get session insights for seller dashboard
     */
    public function getSellerSessionInsights(int $sellerId): array;
}
