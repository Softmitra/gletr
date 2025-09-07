<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage user roles',
            
            // Seller Management
            'view sellers',
            'create sellers',
            'edit sellers',
            'delete sellers',
            'approve sellers',
            'suspend sellers',
            'manage seller verification',
            
            // Product Management
            'view products',
            'create products',
            'edit products',
            'delete products',
            'approve products',
            'feature products',
            'manage product categories',
            'view product analytics',
            
            // Order Management
            'view orders',
            'create orders',
            'edit orders',
            'cancel orders',
            'refund orders',
            'manage order status',
            'view order analytics',
            
            // Payment Management
            'view payments',
            'process payments',
            'refund payments',
            'manage payment methods',
            'view payment analytics',
            
            // Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'manage category hierarchy',
            
            // Review Management
            'view reviews',
            'create reviews',
            'edit reviews',
            'delete reviews',
            'moderate reviews',
            
            // Settings Management
            'view settings',
            'edit settings',
            'manage system settings',
            'manage marketplace settings',
            
            // Analytics & Reports
            'view analytics',
            'view sales reports',
            'view user reports',
            'view system reports',
            'view system logs',
            'export reports',
            
            // Content Management
            'manage content',
            'manage banners',
            'manage notifications',
            'manage emails',
            
            // Support & Communication
            'view support tickets',
            'create support tickets',
            'respond to tickets',
            'manage support system',
            
            // Inventory Management
            'view inventory',
            'manage inventory',
            'update stock levels',
            'manage variants',
            
            // Marketing & Promotions
            'view promotions',
            'create promotions',
            'edit promotions',
            'delete promotions',
            'manage coupons',
            
            // Financial Management
            'view financial reports',
            'manage commissions',
            'manage payouts',
            'view transaction logs',
            
            // Document Verification (New)
            'view seller documents',
            'verify seller documents',
            'reject seller documents',
            'approve seller verification',
            'manage verification workflow',
            'view verification logs',
            
            // Seller Session Management (New)
            'view seller sessions',
            'terminate seller sessions',
            'view session analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin - Full system access
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Operations Admin - Operational management
        $opsAdmin = Role::firstOrCreate(['name' => 'ops_admin']);
        $opsAdmin->givePermissionTo([
            'view users', 'edit users', 'manage user roles',
            'view sellers', 'edit sellers', 'approve sellers', 'suspend sellers', 'manage seller verification',
            'view products', 'edit products', 'approve products', 'feature products', 'manage product categories',
            'view orders', 'edit orders', 'cancel orders', 'refund orders', 'manage order status',
            'view payments', 'process payments', 'refund payments',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view reviews', 'moderate reviews', 'delete reviews',
            'view analytics', 'view sales reports', 'view user reports', 'view system logs',
            'manage content', 'manage banners', 'manage notifications',
            'view support tickets', 'respond to tickets', 'manage support system',
            'view promotions', 'create promotions', 'edit promotions', 'manage coupons',
            'view seller documents', 'verify seller documents', 'reject seller documents', 
            'approve seller verification', 'manage verification workflow', 'view verification logs',
            'view seller sessions', 'terminate seller sessions', 'view session analytics',
        ]);

        // Seller Owner - Full seller account management
        $sellerOwner = Role::firstOrCreate(['name' => 'seller_owner']);
        $sellerOwner->givePermissionTo([
            'view products', 'create products', 'edit products', 'delete products',
            'view orders', 'edit orders', 'manage order status',
            'view payments', 'view payment analytics',
            'view inventory', 'manage inventory', 'update stock levels', 'manage variants',
            'view reviews', 'create reviews',
            'view analytics', 'view sales reports',
            'view support tickets', 'create support tickets',
            'view promotions', 'create promotions', 'edit promotions',
            'view financial reports', 'view transaction logs',
        ]);

        // Seller Staff - Limited seller operations
        $sellerStaff = Role::firstOrCreate(['name' => 'seller_staff']);
        $sellerStaff->givePermissionTo([
            'view products', 'edit products',
            'view orders', 'manage order status',
            'view inventory', 'update stock levels',
            'view reviews',
            'view support tickets', 'create support tickets',
        ]);

        // Customer - Standard customer permissions
        $customer = Role::firstOrCreate(['name' => 'customer']);
        $customer->givePermissionTo([
            'view products',
            'create orders',
            'view orders',
            'create reviews',
            'view reviews',
            'create support tickets',
            'view support tickets',
        ]);

        // Document Verifier - Can verify seller documents
        $documentVerifier = Role::firstOrCreate(['name' => 'document_verifier']);
        $documentVerifier->givePermissionTo([
            'view sellers',
            'view seller documents',
            'verify seller documents',
            'reject seller documents',
            'view verification logs',
        ]);

        // Senior Verifier - Can do final seller approval
        $seniorVerifier = Role::firstOrCreate(['name' => 'senior_verifier']);
        $seniorVerifier->givePermissionTo([
            'view sellers',
            'view seller documents',
            'verify seller documents',
            'reject seller documents',
            'approve seller verification',
            'manage verification workflow',
            'view verification logs',
        ]);

        // Guest - Public access (no explicit permissions needed as they're handled by middleware)
        $guest = Role::firstOrCreate(['name' => 'guest']);
        // Guests have no specific permissions - they can only view public content

        $this->command->info('Roles and permissions created successfully!');
        $this->command->table(
            ['Role', 'Permissions Count'],
            [
                ['Super Admin', $superAdmin->permissions->count()],
                ['Operations Admin', $opsAdmin->permissions->count()],
                ['Document Verifier', $documentVerifier->permissions->count()],
                ['Senior Verifier', $seniorVerifier->permissions->count()],
                ['Seller Owner', $sellerOwner->permissions->count()],
                ['Seller Staff', $sellerStaff->permissions->count()],
                ['Customer', $customer->permissions->count()],
                ['Guest', $guest->permissions->count()],
            ]
        );
    }
}