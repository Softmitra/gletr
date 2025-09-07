<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage users',
            'manage products',
            'manage orders',
            'manage categories',
            'manage sellers',
            'manage settings',
            'view analytics',
            'manage reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $sellerRole->givePermissionTo(['manage products', 'view analytics', 'manage reviews']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gletr.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Create seller user
        $seller = User::firstOrCreate(
            ['email' => 'seller@gletr.com'],
            [
                'name' => 'Demo Seller',
                'password' => Hash::make('seller123'),
                'email_verified_at' => now(),
            ]
        );
        $seller->assignRole('seller');

        // Create customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@gletr.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('customer123'),
                'email_verified_at' => now(),
            ]
        );
        $customer->assignRole('customer');

        // Create additional test users
        User::factory(10)->create()->each(function ($user) use ($customerRole) {
            $user->assignRole($customerRole);
        });
    }
}
