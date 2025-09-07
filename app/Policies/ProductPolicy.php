<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view products');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Product $product): bool
    {
        // Public products can be viewed by anyone (including guests)
        if ($product->is_active && $product->is_approved) {
            return true;
        }

        // If user is not authenticated, deny access to non-public products
        if (!$user) {
            return false;
        }

        // Super admin and ops admin can view all products
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Sellers can view their own products
        if ($user->hasRole(['seller_owner', 'seller_staff'])) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $seller && $product->seller_id === $seller->id;
        }

        // Customers can only view active and approved products
        return $user->hasRole('customer') && $product->is_active && $product->is_approved;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create products');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Super admin and ops admin can update any product
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('edit products')) {
            return false;
        }

        // Sellers can only update their own products
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $seller && $product->seller_id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Super admin can delete any product
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('delete products')) {
            return false;
        }

        // Ops admin can delete any product
        if ($user->hasRole('ops_admin')) {
            return true;
        }

        // Seller owners can delete their own products
        if ($user->hasRole('seller_owner')) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $seller && $product->seller_id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->hasAnyRole(['super_admin', 'ops_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can approve the product.
     */
    public function approve(User $user, Product $product): bool
    {
        return $user->can('approve products');
    }

    /**
     * Determine whether the user can feature the product.
     */
    public function feature(User $user, Product $product): bool
    {
        return $user->can('feature products');
    }

    /**
     * Determine whether the user can manage product inventory.
     */
    public function manageInventory(User $user, Product $product): bool
    {
        // Super admin and ops admin can manage any product inventory
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('manage inventory')) {
            return false;
        }

        // Sellers can manage their own product inventory
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $seller && $product->seller_id === $seller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can view product analytics.
     */
    public function viewAnalytics(User $user, Product $product): bool
    {
        // Super admin and ops admin can view analytics for any product
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('view product analytics')) {
            return false;
        }

        // Seller owners can view analytics for their own products
        if ($user->hasRole('seller_owner')) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            return $seller && $product->seller_id === $seller->id;
        }

        return false;
    }
}