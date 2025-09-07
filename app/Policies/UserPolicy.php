<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Super admin can view all users
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Ops admin can view all users
        if ($user->hasRole('ops_admin')) {
            return true;
        }

        // Users can view their own profile
        if ($user->id === $model->id) {
            return true;
        }

        // Seller owners can view their staff members
        if ($user->hasRole('seller_owner') && $model->hasRole('seller_staff')) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            $modelSeller = $model->seller ?? \App\Models\Seller::where('email', $model->email)->first();
            return $userSeller && $modelSeller && $userSeller->id === $modelSeller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create users');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Super admin can update all users
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Ops admin can update users (except super admins)
        if ($user->hasRole('ops_admin') && !$model->hasRole('super_admin')) {
            return true;
        }

        // Users can update their own profile
        if ($user->id === $model->id) {
            return true;
        }

        // Seller owners can update their staff members
        if ($user->hasRole('seller_owner') && $model->hasRole('seller_staff')) {
            $userSeller = $user->seller ?? \App\Models\Seller::where('email', $user->email)->first();
            $modelSeller = $model->seller ?? \App\Models\Seller::where('email', $model->email)->first();
            return $userSeller && $modelSeller && $userSeller->id === $modelSeller->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Super admin can delete users (except themselves)
        if ($user->hasRole('super_admin') && $user->id !== $model->id) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('delete users')) {
            return false;
        }

        // Ops admin can delete users (except super admins and themselves)
        if ($user->hasRole('ops_admin') && !$model->hasRole('super_admin') && $user->id !== $model->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasAnyRole(['super_admin', 'ops_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('super_admin') && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can manage roles for the model.
     */
    public function manageRoles(User $user, User $model): bool
    {
        // Super admin can manage all roles
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Check if user has general permission
        if (!$user->can('manage user roles')) {
            return false;
        }

        // Ops admin can manage roles (except for super admins)
        if ($user->hasRole('ops_admin') && !$model->hasRole('super_admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can impersonate the model.
     */
    public function impersonate(User $user, User $model): bool
    {
        // Only super admin can impersonate
        if (!$user->hasRole('super_admin')) {
            return false;
        }

        // Cannot impersonate yourself
        if ($user->id === $model->id) {
            return false;
        }

        // Cannot impersonate other super admins
        if ($model->hasRole('super_admin')) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can view user analytics.
     */
    public function viewAnalytics(User $user, ?User $model = null): bool
    {
        // Super admin and ops admin can view all user analytics
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return true;
        }

        // Users can view their own analytics
        if ($model && $user->id === $model->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can suspend the model.
     */
    public function suspend(User $user, User $model): bool
    {
        // Super admin can suspend users (except themselves)
        if ($user->hasRole('super_admin') && $user->id !== $model->id) {
            return true;
        }

        // Ops admin can suspend users (except super admins and themselves)
        if ($user->hasRole('ops_admin') && !$model->hasRole('super_admin') && $user->id !== $model->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can activate the model.
     */
    public function activate(User $user, User $model): bool
    {
        // Super admin can activate users
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Ops admin can activate users (except super admins)
        if ($user->hasRole('ops_admin') && !$model->hasRole('super_admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can reset password for the model.
     */
    public function resetPassword(User $user, User $model): bool
    {
        // Super admin can reset passwords for all users (except themselves)
        if ($user->hasRole('super_admin') && $user->id !== $model->id) {
            return true;
        }

        // Ops admin can reset passwords (except for super admins)
        if ($user->hasRole('ops_admin') && !$model->hasRole('super_admin')) {
            return true;
        }

        return false;
    }
}