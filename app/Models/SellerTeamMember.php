<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SellerTeamMember extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'seller_id',
        'f_name',
        'l_name',
        'email',
        'password',
        'phone',
        'country_code',
        'role',
        'permissions',
        'status',
        'employee_id',
        'joining_date',
        'salary',
        'department',
        'notes',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->f_name . ' ' . $this->l_name;
    }

    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'manager' => 'Manager',
            'staff' => 'Staff',
            'accountant' => 'Accountant',
            'inventory_manager' => 'Inventory Manager',
            'customer_service' => 'Customer Service',
            default => 'Staff'
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => '<span class="badge badge-success">Active</span>',
            'inactive' => '<span class="badge badge-secondary">Inactive</span>',
            'suspended' => '<span class="badge badge-warning">Suspended</span>',
            default => '<span class="badge badge-secondary">Unknown</span>'
        };
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    // Permission methods
    public function hasPermission($permission): bool
    {
        if (!$this->permissions) {
            return false;
        }
        
        return in_array($permission, $this->permissions);
    }

    public function grantPermission($permission): void
    {
        $permissions = $this->permissions ?? [];
        if (!in_array($permission, $permissions)) {
            $permissions[] = $permission;
            $this->update(['permissions' => $permissions]);
        }
    }

    public function revokePermission($permission): void
    {
        $permissions = $this->permissions ?? [];
        $permissions = array_filter($permissions, fn($p) => $p !== $permission);
        $this->update(['permissions' => array_values($permissions)]);
    }

    // Available permissions
    public static function getAvailablePermissions(): array
    {
        return [
            'manage_products' => 'Manage Products',
            'manage_orders' => 'Manage Orders',
            'manage_inventory' => 'Manage Inventory',
            'view_analytics' => 'View Analytics',
            'manage_customers' => 'Manage Customers',
            'manage_payments' => 'Manage Payments',
            'manage_reviews' => 'Manage Reviews',
            'manage_settings' => 'Manage Settings',
        ];
    }

    // Available roles
    public static function getAvailableRoles(): array
    {
        return [
            'manager' => 'Manager',
            'staff' => 'Staff',
            'accountant' => 'Accountant',
            'inventory_manager' => 'Inventory Manager',
            'customer_service' => 'Customer Service',
        ];
    }
}