<?php

namespace App\Services\Interfaces;

use App\Models\SellerStore;
use Illuminate\Http\UploadedFile;

interface SellerStoreServiceInterface
{
    /**
     * Create a new seller store
     */
    public function createStore(array $storeData, ?UploadedFile $logo = null, ?UploadedFile $banner = null): SellerStore;
    /**
     * Get store dashboard data
     */
    public function getStoreDashboard(int $sellerId): array;

    /**
     * Get store information for editing
     */
    public function getStoreEditData(int $sellerId): array;

    /**
     * Update store basic information
     */
    public function updateStoreInfo(int $sellerId, array $data): bool;

    /**
     * Get store settings
     */
    public function getStoreSettings(int $sellerId): array;

    /**
     * Update store settings
     */
    public function updateStoreSettings(int $sellerId, array $settings): bool;

    /**
     * Get store branding data
     */
    public function getStoreBranding(int $sellerId): array;

    /**
     * Update store branding
     */
    public function updateStoreBranding(int $sellerId, array $branding): bool;
}
