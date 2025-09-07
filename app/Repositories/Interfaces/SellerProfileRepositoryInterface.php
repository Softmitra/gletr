<?php

namespace App\Repositories\Interfaces;

use App\Models\Seller;
use Illuminate\Http\UploadedFile;

interface SellerProfileRepositoryInterface
{
    /**
     * Get seller by ID
     */
    public function findById(int $id): ?Seller;

    /**
     * Update seller profile
     */
    public function updateProfile(Seller $seller, array $data): bool;

    /**
     * Update seller password
     */
    public function updatePassword(Seller $seller, string $password): bool;

    /**
     * Update seller avatar/image
     */
    public function updateAvatar(Seller $seller, UploadedFile $file): string;

    /**
     * Get seller with relationships
     */
    public function getSellerWithRelations(int $id, array $relations = []): ?Seller;

    /**
     * Check if email exists for other sellers
     */
    public function emailExistsForOtherSellers(string $email, int $sellerId): bool;

    /**
     * Get seller verification documents
     */
    public function getVerificationDocuments(Seller $seller): array;

    /**
     * Update seller business information
     */
    public function updateBusinessInfo(Seller $seller, array $data): bool;

    /**
     * Update seller contact information
     */
    public function updateContactInfo(Seller $seller, array $data): bool;

    /**
     * Get seller activity logs
     */
    public function getActivityLogs(Seller $seller, int $limit = 50): \Illuminate\Database\Eloquent\Collection;
}
