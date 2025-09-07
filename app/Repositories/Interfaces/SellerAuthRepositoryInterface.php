<?php

namespace App\Repositories\Interfaces;

use App\Models\Seller;
use App\Models\User;

interface SellerAuthRepositoryInterface
{
    /**
     * Find seller by email
     */
    public function findSellerByEmail(string $email): ?Seller;

    /**
     * Check if seller is verified and active
     */
    public function isSellerVerified(Seller $seller): bool;

    /**
     * Check if seller is active
     */
    public function isSellerActive(Seller $seller): bool;

    /**
     * Update seller last login
     */
    public function updateLastLogin(Seller $seller): void;

    /**
     * Verify seller password
     */
    public function verifyPassword(Seller $seller, string $password): bool;

    /**
     * Get authenticated seller by ID
     */
    public function findSellerById(int $id): ?Seller;
}
