<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view orders');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        // Super admin and ops admin can view all orders
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Customers can view their own orders
        if ($user->hasRole('customer') && $order->user_id === $user->id) {
            return true;
        }

        // Sellers can view orders containing their products
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            if ($seller) {
                return $order->items()->whereHas('product', function ($query) use ($seller) {
                    $query->where('seller_id', $seller->id);
                })->exists();
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create orders');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        // Super admin and ops admin can update any order
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('edit orders')) {
            return false;
        }

        // Customers can update their own orders (limited scenarios)
        if ($user->hasRole('customer') && $order->user_id === $user->id) {
            // Only allow updates if order is in pending or processing status
            return in_array($order->status, ['pending', 'processing']);
        }

        // Sellers can update orders containing their products
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            if ($seller) {
                return $order->items()->whereHas('product', function ($query) use ($seller) {
                    $query->where('seller_id', $seller->id);
                })->exists();
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        // Only super admin can delete orders
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->hasAnyRole(['super_admin', 'ops_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can cancel the order.
     */
    public function cancel(User $user, Order $order): bool
    {
        // Super admin and ops admin can cancel any order
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('cancel orders')) {
            return false;
        }

        // Customers can cancel their own orders if in cancellable status
        if ($user->hasRole('customer') && $order->user_id === $user->id) {
            return in_array($order->status, ['pending', 'processing']);
        }

        return false;
    }

    /**
     * Determine whether the user can refund the order.
     */
    public function refund(User $user, Order $order): bool
    {
        return $user->can('refund orders');
    }

    /**
     * Determine whether the user can manage order status.
     */
    public function manageStatus(User $user, Order $order): bool
    {
        // Super admin and ops admin can manage any order status
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('manage order status')) {
            return false;
        }

        // Sellers can manage status of orders containing their products
        if ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            if ($seller) {
                return $order->items()->whereHas('product', function ($query) use ($seller) {
                    $query->where('seller_id', $seller->id);
                })->exists();
            }
        }

        return false;
    }

    /**
     * Determine whether the user can view order analytics.
     */
    public function viewAnalytics(User $user, ?Order $order = null): bool
    {
        // Super admin and ops admin can view all order analytics
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('view order analytics')) {
            return false;
        }

        // Seller owners can view analytics for orders containing their products
        if ($user->hasRole('seller_owner')) {
            if (!$order) {
                return true; // Can view general analytics
            }
            
            $seller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            if ($seller) {
                return $order->items()->whereHas('product', function ($query) use ($seller) {
                    $query->where('seller_id', $seller->id);
                })->exists();
            }
        }

        return false;
    }

    /**
     * Determine whether the user can process payments for the order.
     */
    public function processPayment(User $user, Order $order): bool
    {
        // Super admin and ops admin can process payments
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('process payments')) {
            return false;
        }

        // Customers can process payments for their own orders
        if ($user->hasRole('customer') && $order->user_id === $user->id) {
            return $order->status === 'pending';
        }

        return false;
    }
}