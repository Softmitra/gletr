<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = [
            [
                'name' => 'Golden Treasures Owner',
                'email' => 'contact@goldentreasures.com',
                'phone' => '+1-555-0101',
                'business_name' => 'Golden Treasures',
                'description' => 'Premium gold jewelry and accessories',
                'status' => 'active',
                'is_verified' => true,
                'commission_rate' => 5.0,
                'address' => json_encode(['address' => '123 Jewelry District, New York, NY 10001']),
            ],
            [
                'name' => 'Diamond Dreams Owner',
                'email' => 'info@diamonddreams.com',
                'phone' => '+1-555-0102',
                'business_name' => 'Diamond Dreams',
                'description' => 'Exquisite diamond jewelry and engagement rings',
                'status' => 'active',
                'is_verified' => true,
                'commission_rate' => 4.5,
                'address' => json_encode(['address' => '456 Luxury Ave, Beverly Hills, CA 90210']),
            ],
            [
                'name' => 'Silver Elegance Owner',
                'email' => 'hello@silverelegance.com',
                'phone' => '+1-555-0103',
                'business_name' => 'Silver Elegance',
                'description' => 'Beautiful silver jewelry and accessories',
                'status' => 'active',
                'is_verified' => true,
                'commission_rate' => 6.0,
                'address' => json_encode(['address' => '789 Artisan Street, San Francisco, CA 94102']),
            ],
            [
                'name' => 'Vintage Gems Owner',
                'email' => 'vintage@gems.com',
                'phone' => '+1-555-0104',
                'business_name' => 'Vintage Gems',
                'description' => 'Antique and vintage jewelry collection',
                'status' => 'active',
                'is_verified' => true,
                'commission_rate' => 5.5,
                'address' => json_encode(['address' => '321 Heritage Lane, Boston, MA 02101']),
            ],
            [
                'name' => 'Modern Jewels Owner',
                'email' => 'modern@jewels.com',
                'phone' => '+1-555-0105',
                'business_name' => 'Modern Jewels',
                'description' => 'Contemporary and fashion-forward jewelry',
                'status' => 'active',
                'is_verified' => false,
                'commission_rate' => 7.0,
                'address' => json_encode(['address' => '654 Fashion Blvd, Miami, FL 33101']),
            ],
        ];

        foreach ($sellers as $sellerData) {
            Seller::firstOrCreate(
                ['email' => $sellerData['email']],
                $sellerData
            );
        }
    }
}
