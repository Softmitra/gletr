<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Repositories\Interfaces\SellerStoreManagementRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class SellerStoreManagementRepository implements SellerStoreManagementRepositoryInterface
{
    /**
     * Get seller store information
     */
    public function getStoreInfo(int $sellerId): ?Seller
    {
        return Seller::with(['sellerType'])->find($sellerId);
    }

    /**
     * Update store basic information
     */
    public function updateStoreInfo(Seller $seller, array $data): bool
    {
        $updated = $seller->update($data);
        
        if ($updated) {
            Cache::forget("seller.{$seller->id}");
        }
        
        return $updated;
    }

    /**
     * Update store settings
     */
    public function updateStoreSettings(Seller $seller, array $settings): bool
    {
        // For now, we'll store settings in the seller record
        // In the future, this could be moved to a separate store_settings table
        $storeSettings = array_merge($seller->store_settings ?? [], $settings);
        
        $updated = $seller->update(['store_settings' => $storeSettings]);
        
        if ($updated) {
            Cache::forget("seller.{$seller->id}");
        }
        
        return $updated;
    }

    /**
     * Update store branding
     */
    public function updateStoreBranding(Seller $seller, array $branding): bool
    {
        // Store branding information in seller record
        $storeBranding = array_merge($seller->store_branding ?? [], $branding);
        
        $updated = $seller->update(['store_branding' => $storeBranding]);
        
        if ($updated) {
            Cache::forget("seller.{$seller->id}");
        }
        
        return $updated;
    }

    /**
     * Get store with relationships
     */
    public function getStoreWithRelations(int $sellerId, array $relations = []): ?Seller
    {
        $query = Seller::where('id', $sellerId);
        
        if (!empty($relations)) {
            $query->with($relations);
        }
        
        return $query->first();
    }
}
