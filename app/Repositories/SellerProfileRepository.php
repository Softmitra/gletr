<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Repositories\Interfaces\SellerProfileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SellerProfileRepository implements SellerProfileRepositoryInterface
{
    /**
     * Get seller by ID
     */
    public function findById(int $id): ?Seller
    {
        return Seller::find($id);
    }

    /**
     * Update seller profile
     */
    public function updateProfile(Seller $seller, array $data): bool
    {
        $updated = $seller->update($data);
        
        if ($updated) {
            // Clear cache
            Cache::forget("seller.{$seller->id}");
        }
        
        return $updated;
    }

    /**
     * Update seller password
     */
    public function updatePassword(Seller $seller, string $password): bool
    {
        return $seller->update([
            'password' => Hash::make($password),
            'password_updated_at' => now(),
        ]);
    }

    /**
     * Update seller avatar/image
     */
    public function updateAvatar(Seller $seller, UploadedFile $file): string
    {
        // Delete old avatar if exists
        if ($seller->image && Storage::disk('public')->exists($seller->image)) {
            Storage::disk('public')->delete($seller->image);
        }

        // Store new avatar
        $filename = 'seller_' . $seller->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sellers/avatars', $filename, 'public');

        // Update seller record
        $seller->update(['image' => $path]);

        return $path;
    }

    /**
     * Get seller with relationships
     */
    public function getSellerWithRelations(int $id, array $relations = []): ?Seller
    {
        $query = Seller::where('id', $id);
        
        if (!empty($relations)) {
            $query->with($relations);
        }
        
        return $query->first();
    }

    /**
     * Check if email exists for other sellers
     */
    public function emailExistsForOtherSellers(string $email, int $sellerId): bool
    {
        return Seller::where('email', $email)
            ->where('id', '!=', $sellerId)
            ->exists();
    }

    /**
     * Get seller verification documents
     */
    public function getVerificationDocuments(Seller $seller): array
    {
        return $seller->sellerDocuments()
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Update seller business information
     */
    public function updateBusinessInfo(Seller $seller, array $data): bool
    {
        $businessFields = [
            'business_name',
            'business_type',
            'business_registration_number',
            'tax_id',
            'gst_number',
            'business_address',
            'business_city',
            'business_state',
            'business_postal_code',
            'business_country',
        ];

        $businessData = array_intersect_key($data, array_flip($businessFields));
        
        return $this->updateProfile($seller, $businessData);
    }

    /**
     * Update seller contact information
     */
    public function updateContactInfo(Seller $seller, array $data): bool
    {
        $contactFields = [
            'name',
            'email',
            'phone',
            'alternate_phone',
            'address',
            'city',
            'state',
            'postal_code',
            'country',
        ];

        $contactData = array_intersect_key($data, array_flip($contactFields));
        
        return $this->updateProfile($seller, $contactData);
    }

    /**
     * Get seller activity logs
     */
    public function getActivityLogs(Seller $seller, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return $seller->verificationLogs()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
