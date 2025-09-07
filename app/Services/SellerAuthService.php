<?php

namespace App\Services;

use App\Models\Seller;
use App\Models\User;
use App\Repositories\Interfaces\SellerAuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SellerAuthService
{
    public function __construct(
        private SellerAuthRepositoryInterface $sellerAuthRepository
    ) {}

    /**
     * Authenticate seller with email and password
     */
    public function authenticate(string $email, string $password, bool $remember = false): Seller
    {
        Log::info('Seller authentication attempt', ['email' => $email]);

        // Find seller by email
        $seller = $this->sellerAuthRepository->findSellerByEmail($email);

        if (!$seller) {
            Log::warning('Seller not found', ['email' => $email]);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Check if seller has password set
        if (!$seller->password) {
            Log::warning('Seller password not set', ['seller_id' => $seller->id]);
            throw ValidationException::withMessages([
                'email' => ['Please complete your seller registration first.'],
            ]);
        }

        // Verify password
        if (!$this->sellerAuthRepository->verifyPassword($seller, $password)) {
            Log::warning('Invalid password for seller', ['seller_id' => $seller->id]);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Check if seller account is suspended or rejected (these should not be allowed to login)
        if (in_array($seller->status, ['suspended', 'rejected'])) {
            Log::warning('Blocked seller login attempt', ['seller_id' => $seller->id, 'status' => $seller->status]);
            
            $message = match($seller->status) {
                'suspended' => 'Your seller account has been suspended. Please contact support.',
                'rejected' => 'Your seller application was rejected. Please contact support for more information.',
                default => 'Your seller account is not active. Please contact support.',
            };

            throw ValidationException::withMessages([
                'email' => [$message],
            ]);
        }

        // Allow login for pending/unverified sellers - they will be redirected to verification dashboard

        // Login successful
        Log::info('Seller login successful', ['seller_id' => $seller->id]);

        return $seller;
    }

    /**
     * Login the seller
     */
    public function login(Seller $seller, bool $remember = false): void
    {
        // Login the seller directly
        Auth::guard('seller')->login($seller, $remember);

        // Update seller login statistics
        $this->sellerAuthRepository->updateLastLogin($seller);

        Log::info('Seller logged in successfully', [
            'seller_id' => $seller->id,
            'remember' => $remember,
        ]);
    }

    /**
     * Logout the seller
     */
    public function logout(): void
    {
        $seller = Auth::guard('seller')->user();
        
        if ($seller) {
            Log::info('Seller logout', [
                'seller_id' => $seller->id,
            ]);
        }

        Auth::guard('seller')->logout();
    }

    /**
     * Get current authenticated seller
     */
    public function getCurrentSeller(): ?Seller
    {
        /** @var Seller|null $seller */
        $seller = Auth::guard('seller')->user();
        return $seller;
    }

    /**
     * Check if current user is a seller
     */
    public function isCurrentUserSeller(): bool
    {
        return Auth::guard('seller')->check();
    }

    /**
     * Get seller dashboard data
     */
    public function getDashboardData(Seller $seller): array
    {
        return [
            'seller' => $seller,
            'verification_status' => $seller->status,
            'is_verified' => $this->sellerAuthRepository->isSellerVerified($seller),
            'is_active' => $this->sellerAuthRepository->isSellerActive($seller),
            'last_login' => $seller->last_login_at,
            'login_count' => $seller->login_count ?? 0,
        ];
    }
}
