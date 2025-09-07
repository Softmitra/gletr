<?php

namespace App\Repositories\Interfaces;

use App\Models\Seller;

interface SellerStoreManagementRepositoryInterface
{
    /**
     * Get seller store information
     */
    public function getStoreInfo(int $sellerId): ?Seller;

    /**
     * Update store basic information
     */
    public function updateStoreInfo(Seller $seller, array $data): bool;

    /**
     * Update store settings
     */
    public function updateStoreSettings(Seller $seller, array $settings): bool;

    /**
     * Update store branding
     */
    public function updateStoreBranding(Seller $seller, array $branding): bool;

    /**
     * Get store with relationships
     */
    public function getStoreWithRelations(int $sellerId, array $relations = []): ?Seller;
}
