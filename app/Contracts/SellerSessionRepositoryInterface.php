<?php

namespace App\Contracts;

use App\Models\Seller;
use App\Models\SellerSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface SellerSessionRepositoryInterface
{
    /**
     * Get paginated sessions with filters
     */
    public function getPaginatedSessions(array $filters = [], int $perPage = 20): LengthAwarePaginator;

    /**
     * Get session statistics
     */
    public function getSessionStats(): array;

    /**
     * Get analytics data for a period
     */
    public function getAnalyticsData(int $days): array;

    /**
     * Find session by ID
     */
    public function findSession(int $sessionId): ?SellerSession;

    /**
     * Find session by session ID string
     */
    public function findBySessionId(string $sessionId): ?SellerSession;

    /**
     * Get active sessions for seller
     */
    public function getActiveSessionsForSeller(int $sellerId): Collection;

    /**
     * Get all sessions for seller
     */
    public function getSessionsForSeller(int $sellerId, int $limit = null): Collection;

    /**
     * Create new session
     */
    public function createSession(Seller $seller, Request $request): SellerSession;

    /**
     * Update session activity
     */
    public function updateSessionActivity(SellerSession $session): bool;

    /**
     * Mark session as logged out
     */
    public function markSessionAsLoggedOut(SellerSession $session): bool;

    /**
     * Terminate session
     */
    public function terminateSession(SellerSession $session): bool;

    /**
     * Terminate all sessions for seller except current
     */
    public function terminateAllSessionsForSeller(int $sellerId, string $currentSessionId = null): int;

    /**
     * Get suspicious activities count
     */
    public function getSuspiciousActivitiesCount(): int;

    /**
     * Get session analytics for specific seller
     */
    public function getSellerSessionAnalytics(int $sellerId): array;

    /**
     * Clean up old inactive sessions
     */
    public function cleanupOldSessions(int $sellerId, int $keepCount = 50): int;

    /**
     * Get sessions by criteria
     */
    public function getSessionsByCriteria(array $criteria): Collection;

    /**
     * Count sessions by criteria
     */
    public function countSessionsByCriteria(array $criteria): int;
}
