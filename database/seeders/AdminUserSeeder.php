<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@gletr.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign super_admin role
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole && !$superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole($superAdminRole);
        }

        // Create Operations Admin User
        $opsAdmin = User::firstOrCreate(
            ['email' => 'ops@gletr.com'],
            [
                'name' => 'Operations Admin',
                'password' => Hash::make('Ops@123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign ops_admin role
        $opsAdminRole = Role::where('name', 'ops_admin')->first();
        if ($opsAdminRole && !$opsAdmin->hasRole('ops_admin')) {
            $opsAdmin->assignRole($opsAdminRole);
        }

        // Create Test Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@gletr.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('Customer@123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign customer role
        $customerRole = Role::where('name', 'customer')->first();
        if ($customerRole && !$customer->hasRole('customer')) {
            $customer->assignRole($customerRole);
        }

        $this->command->info('Admin users created successfully!');
        $this->command->table(
            ['Role', 'Email', 'Password', 'Name'],
            [
                ['Super Admin', 'admin@gletr.com', 'Admin@123', 'Super Admin'],
                ['Operations Admin', 'ops@gletr.com', 'Ops@123', 'Operations Admin'],
                ['Customer', 'customer@gletr.com', 'Customer@123', 'Test Customer'],
            ]
        );
        
        $this->command->warn('⚠️  IMPORTANT: Change these default passwords in production!');
    }
}