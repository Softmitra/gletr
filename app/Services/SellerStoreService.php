<?php

namespace App\Services;

use App\Models\SellerStore;
use App\Repositories\Interfaces\SellerStoreManagementRepositoryInterface;
use App\Services\Interfaces\SellerStoreServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SellerStoreService implements SellerStoreServiceInterface
{
    public function __construct(
        private SellerStoreManagementRepositoryInterface $storeRepository
    ) {}

    /**
     * Create a new seller store
     */
    public function createStore(array $storeData, ?UploadedFile $logo = null, ?UploadedFile $banner = null): SellerStore
    {
        // Validate store data
        $validator = Validator::make($storeData, [
            'seller_id' => 'required|integer|exists:sellers,id',
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:500',
            'store_phone' => 'nullable|string|max:20',
            'store_email' => 'nullable|email|max:255',
            'store_description' => 'nullable|string|max:1000',
            'store_categories' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $validatedData = $validator->validated();

        // Handle logo upload
        if ($logo) {
            $logoPath = $this->uploadFile($logo, 'stores/logos');
            $validatedData['store_logo'] = $logoPath;
        }

        // Handle banner upload
        if ($banner) {
            $bannerPath = $this->uploadFile($banner, 'stores/banners');
            $validatedData['store_banner'] = $bannerPath;
        }

        // Create the store
        $store = SellerStore::create($validatedData);

        Log::info('Seller store created', [
            'store_id' => $store->id,
            'seller_id' => $validatedData['seller_id'],
            'store_name' => $validatedData['store_name']
        ]);

        return $store;
    }

    /**
     * Upload file and return path
     */
    private function uploadFile(UploadedFile $file, string $directory): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Get store dashboard data
     */
    public function getStoreDashboard(int $sellerId): array
    {
        $seller = $this->storeRepository->getStoreWithRelations($sellerId, ['sellerType']);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        return [
            'seller' => $seller,
            'store_stats' => [
                'total_products' => 0, // TODO: Implement when product module is ready
                'active_products' => 0,
                'draft_products' => 0,
                'out_of_stock' => 0,
            ],
            'store_settings' => $seller->store_settings ?? [],
            'store_branding' => $seller->store_branding ?? [],
        ];
    }

    /**
     * Get store information for editing
     */
    public function getStoreEditData(int $sellerId): array
    {
        $seller = $this->storeRepository->getStoreInfo($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        return [
            'seller' => $seller,
            'store_settings' => $seller->store_settings ?? [],
        ];
    }

    /**
     * Update store basic information
     */
    public function updateStoreInfo(int $sellerId, array $data): bool
    {
        $seller = $this->storeRepository->getStoreInfo($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        // Validate store data
        $validator = Validator::make($data, [
            'business_name' => 'required|string|max:255',
            'business_description' => 'nullable|string|max:1000',
            'business_address' => 'required|string|max:500',
            'business_city' => 'required|string|max:100',
            'business_state' => 'required|string|max:100',
            'business_postal_code' => 'required|string|max:20',
            'business_country' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $updated = $this->storeRepository->updateStoreInfo($seller, $validator->validated());

        if ($updated) {
            Log::info('Store information updated', [
                'seller_id' => $sellerId,
                'updated_fields' => array_keys($validator->validated())
            ]);
        }

        return $updated;
    }

    /**
     * Get store settings
     */
    public function getStoreSettings(int $sellerId): array
    {
        $seller = $this->storeRepository->getStoreInfo($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        $defaultSettings = [
            'store_status' => 'active',
            'allow_reviews' => true,
            'show_contact_info' => true,
            'auto_accept_orders' => false,
            'min_order_amount' => 0,
            'free_shipping_threshold' => 0,
            'processing_time' => '1-2 business days',
            'return_policy' => '7 days return policy',
        ];

        return [
            'seller' => $seller,
            'settings' => array_merge($defaultSettings, $seller->store_settings ?? []),
        ];
    }

    /**
     * Update store settings
     */
    public function updateStoreSettings(int $sellerId, array $settings): bool
    {
        $seller = $this->storeRepository->getStoreInfo($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        // Validate settings
        $validator = Validator::make($settings, [
            'store_status' => 'required|in:active,inactive,maintenance',
            'allow_reviews' => 'boolean',
            'show_contact_info' => 'boolean',
            'auto_accept_orders' => 'boolean',
            'min_order_amount' => 'numeric|min:0',
            'free_shipping_threshold' => 'numeric|min:0',
            'processing_time' => 'required|string|max:100',
            'return_policy' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $updated = $this->storeRepository->updateStoreSettings($seller, $validator->validated());

        if ($updated) {
            Log::info('Store settings updated', [
                'seller_id' => $sellerId,
                'updated_settings' => array_keys($validator->validated())
            ]);
        }

        return $updated;
    }

    /**
     * Get store branding data
     */
    public function getStoreBranding(int $sellerId): array
    {
        $seller = $this->storeRepository->getStoreInfo($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        $defaultBranding = [
            'store_logo' => null,
            'store_banner' => null,
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'store_tagline' => '',
            'social_facebook' => '',
            'social_instagram' => '',
            'social_twitter' => '',
            'social_youtube' => '',
        ];

        return [
            'seller' => $seller,
            'branding' => array_merge($defaultBranding, $seller->store_branding ?? []),
        ];
    }

    /**
     * Update store branding
     */
    public function updateStoreBranding(int $sellerId, array $branding): bool
    {
        $seller = $this->storeRepository->getStoreInfo($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        // Validate branding data
        $validator = Validator::make($branding, [
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'store_tagline' => 'nullable|string|max:200',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $updated = $this->storeRepository->updateStoreBranding($seller, $validator->validated());

        if ($updated) {
            Log::info('Store branding updated', [
                'seller_id' => $sellerId,
                'updated_branding' => array_keys($validator->validated())
            ]);
        }

        return $updated;
    }
}