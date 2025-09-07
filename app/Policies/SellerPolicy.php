<?php

namespace App\Policies;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SellerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view sellers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Seller $seller): bool
    {
        // Super admin and ops admin can view all sellers
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Sellers can view their own profile
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $userSeller && $userSeller->id === $seller->id;
        }

        // Customers can view active and verified seller profiles
        if ($user->hasRole('customer')) {
            return $seller->is_active && $seller->is_verified;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create sellers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Seller $seller): bool
    {
        // Super admin and ops admin can update any seller
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('edit sellers')) {
            return false;
        }

        // Seller owners can update their own profile
        if ($user->hasRole('seller_owner')) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $userSeller && $userSeller->id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Seller $seller): bool
    {
        // Only super admin can delete sellers
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('delete sellers')) {
            return false;
        }

        // Ops admin can delete sellers
        return $user->hasRole('ops_admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Seller $seller): bool
    {
        return $user->hasAnyRole(['super_admin', 'ops_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Seller $seller): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can approve the seller.
     */
    public function approve(User $user, Seller $seller): bool
    {
        return $user->can('approve sellers');
    }

    /**
     * Determine whether the user can suspend the seller.
     */
    public function suspend(User $user, Seller $seller): bool
    {
        return $user->can('suspend sellers');
    }

    /**
     * Determine whether the user can manage seller verification.
     */
    public function manageVerification(User $user, Seller $seller): bool
    {
        return $user->can('manage seller verification');
    }

    /**
     * Determine whether the user can view seller analytics.
     */
    public function viewAnalytics(User $user, Seller $seller): bool
    {
        // Super admin and ops admin can view analytics for any seller
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Seller owners can view their own analytics
        if ($user->hasRole('seller_owner')) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $userSeller && $userSeller->id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can manage seller products.
     */
    public function manageProducts(User $user, Seller $seller): bool
    {
        // Super admin and ops admin can manage products for any seller
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Sellers can manage their own products
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $userSeller && $userSeller->id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can manage seller orders.
     */
    public function manageOrders(User $user, Seller $seller): bool
    {
        // Super admin and ops admin can manage orders for any seller
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Sellers can manage their own orders
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $userSeller && $userSeller->id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can manage seller staff.
     */
    public function manageStaff(User $user, Seller $seller): bool
    {
        // Super admin and ops admin can manage staff for any seller
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Only seller owners can manage their staff
        if ($user->hasRole('seller_owner')) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $userSeller && $userSeller->id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can view seller financial data.
     */
    public function viewFinancials(User $user, Seller $seller): bool
    {
        // Super admin and ops admin can view financials for any seller
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Seller owners can view their own financial data
        if ($user->hasRole('seller_owner')) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $userSeller && $userSeller->id === $seller->id;
        }

        return false;
    }
}