<?php

namespace App\Services\Interfaces;

use App\Models\Seller;
use Illuminate\Http\UploadedFile;

interface SellerProfileServiceInterface
{
    /**
     * Get seller profile data
     */
    public function getProfileData(int $sellerId): array;

    /**
     * Update seller profile
     */
    public function updateProfile(int $sellerId, array $data): bool;

    /**
     * Update seller password
     */
    public function updatePassword(int $sellerId, string $currentPassword, string $newPassword): bool;

    /**
     * Update seller avatar
     */
    public function updateAvatar(int $sellerId, UploadedFile $file): array;

    /**
     * Update business information
     */
    public function updateBusinessInfo(int $sellerId, array $data): bool;

    /**
     * Update contact information
     */
    public function updateContactInfo(int $sellerId, array $data): bool;

    /**
     * Get seller dashboard data
     */
    public function getDashboardData(int $sellerId): array;

    /**
     * Get seller verification status
     */
    public function getVerificationStatus(int $sellerId): array;

    /**
     * Validate profile update data
     */
    public function validateProfileData(array $data, int $sellerId): array;

    /**
     * Get seller activity timeline
     */
    public function getActivityTimeline(int $sellerId): array;
}
