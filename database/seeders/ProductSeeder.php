<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::whereNotNull('parent_id')->get();
        $sellers = Seller::where('status', 'active')->get();

        if ($categories->isEmpty() || $sellers->isEmpty()) {
            return;
        }

        $products = [
            [
                'name' => 'Classic Diamond Engagement Ring',
                'description' => 'A timeless solitaire diamond engagement ring featuring a brilliant cut diamond set in 18k white gold.',
                'price' => 2499.99,
                'compare_at_price' => 2999.99,
                'sku' => 'RING-001',
                'weight' => 3.5,
                'material' => '18k White Gold',
                'gemstone' => 'Diamond',
                'is_featured' => true,
                'variants' => [
                    ['size' => '5', 'price' => 2499.99, 'stock' => 5],
                    ['size' => '6', 'price' => 2499.99, 'stock' => 8],
                    ['size' => '7', 'price' => 2499.99, 'stock' => 6],
                    ['size' => '8', 'price' => 2499.99, 'stock' => 4],
                ]
            ],
            [
                'name' => 'Pearl Drop Earrings',
                'description' => 'Elegant freshwater pearl drop earrings with sterling silver hooks.',
                'price' => 149.99,
                'compare_at_price' => 199.99,
                'sku' => 'EAR-001',
                'weight' => 2.1,
                'material' => 'Sterling Silver',
                'gemstone' => 'Freshwater Pearl',
                'is_featured' => true,
                'variants' => [
                    ['color' => 'White', 'price' => 149.99, 'stock' => 12],
                    ['color' => 'Pink', 'price' => 159.99, 'stock' => 8],
                    ['color' => 'Black', 'price' => 169.99, 'stock' => 6],
                ]
            ],
            [
                'name' => 'Gold Chain Necklace',
                'description' => 'Beautiful 14k gold chain necklace, perfect for layering or wearing alone.',
                'price' => 399.99,
                'compare_at_price' => null,
                'sku' => 'NECK-001',
                'weight' => 5.2,
                'material' => '14k Gold',
                'gemstone' => null,
                'is_featured' => false,
                'variants' => [
                    ['length' => '16"', 'price' => 399.99, 'stock' => 10],
                    ['length' => '18"', 'price' => 429.99, 'stock' => 15],
                    ['length' => '20"', 'price' => 459.99, 'stock' => 8],
                ]
            ],
            [
                'name' => 'Silver Tennis Bracelet',
                'description' => 'Stunning sterling silver tennis bracelet with cubic zirconia stones.',
                'price' => 89.99,
                'compare_at_price' => 129.99,
                'sku' => 'BRAC-001',
                'weight' => 8.7,
                'material' => 'Sterling Silver',
                'gemstone' => 'Cubic Zirconia',
                'is_featured' => true,
                'variants' => [
                    ['size' => 'Small (6.5")', 'price' => 89.99, 'stock' => 7],
                    ['size' => 'Medium (7")', 'price' => 89.99, 'stock' => 12],
                    ['size' => 'Large (7.5")', 'price' => 89.99, 'stock' => 9],
                ]
            ],
            [
                'name' => 'Vintage Emerald Ring',
                'description' => 'Antique-style emerald ring with intricate gold detailing and side diamonds.',
                'price' => 1299.99,
                'compare_at_price' => 1599.99,
                'sku' => 'RING-002',
                'weight' => 4.2,
                'material' => '14k Yellow Gold',
                'gemstone' => 'Emerald',
                'is_featured' => false,
                'variants' => [
                    ['size' => '5', 'price' => 1299.99, 'stock' => 2],
                    ['size' => '6', 'price' => 1299.99, 'stock' => 3],
                    ['size' => '7', 'price' => 1299.99, 'stock' => 2],
                ]
            ],
        ];

        foreach ($products as $productData) {
            $variants = $productData['variants'];
            unset($productData['variants']);

            $productData['slug'] = Str::slug($productData['name']);
            $productData['category_id'] = $categories->random()->id;
            $productData['seller_id'] = $sellers->random()->id;
            $productData['status'] = 'active';
            $productData['is_active'] = true;

            $product = Product::firstOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );

            // Create product variants
            foreach ($variants as $variantData) {
                $variantData['product_id'] = $product->id;
                $variantData['sku'] = $product->sku . '-' . Str::upper(Str::slug(array_values($variantData)[0]));
                
                ProductVariant::firstOrCreate(
                    ['sku' => $variantData['sku']],
                    $variantData
                );
            }
        }

        // Create additional random products
        Product::factory(20)->create()->each(function ($product) {
            // Create 1-3 variants for each product
            $variantCount = rand(1, 3);
            ProductVariant::factory($variantCount)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
