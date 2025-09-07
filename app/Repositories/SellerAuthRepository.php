<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Models\User;
use App\Repositories\Interfaces\SellerAuthRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SellerAuthRepository implements SellerAuthRepositoryInterface
{
    /**
     * Find seller by email
     */
    public function findSellerByEmail(string $email): ?Seller
    {
        return Seller::where('email', $email)->first();
    }

    /**
     * Check if seller is verified and active
     */
    public function isSellerVerified(Seller $seller): bool
    {
        return $seller->is_verified && $seller->status === 'active';
    }

    /**
     * Check if seller is active
     */
    public function isSellerActive(Seller $seller): bool
    {
        return $seller->status === 'active';
    }

    /**
     * Update seller last login
     */
    public function updateLastLogin(Seller $seller): void
    {
        $seller->update([
            'last_login_at' => now(),
            'login_count' => ($seller->login_count ?? 0) + 1,
        ]);

        // Clear any cached seller data
        Cache::forget("seller.{$seller->id}");
    }

    /**
     * Verify seller password
     */
    public function verifyPassword(Seller $seller, string $password): bool
    {
        return Hash::check($password, $seller->password);
    }

    /**
     * Get authenticated seller by ID
     */
    public function findSellerById(int $id): ?Seller
    {
        return Seller::find($id);
    }
}
