<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Rings',
                'description' => 'Beautiful rings for all occasions',
                'is_active' => true,
                'sort_order' => 1,
                'subcategories' => [
                    'Engagement Rings',
                    'Wedding Rings',
                    'Fashion Rings',
                    'Statement Rings',
                ]
            ],
            [
                'name' => 'Necklaces',
                'description' => 'Elegant necklaces and pendants',
                'is_active' => true,
                'sort_order' => 2,
                'subcategories' => [
                    'Chain Necklaces',
                    'Pendant Necklaces',
                    'Chokers',
                    'Statement Necklaces',
                ]
            ],
            [
                'name' => 'Earrings',
                'description' => 'Stunning earrings for every style',
                'is_active' => true,
                'sort_order' => 3,
                'subcategories' => [
                    'Stud Earrings',
                    'Drop Earrings',
                    'Hoop Earrings',
                    'Chandelier Earrings',
                ]
            ],
            [
                'name' => 'Bracelets',
                'description' => 'Stylish bracelets and bangles',
                'is_active' => true,
                'sort_order' => 4,
                'subcategories' => [
                    'Chain Bracelets',
                    'Charm Bracelets',
                    'Bangles',
                    'Tennis Bracelets',
                ]
            ],
            [
                'name' => 'Watches',
                'description' => 'Luxury and fashion watches',
                'is_active' => true,
                'sort_order' => 5,
                'subcategories' => [
                    'Luxury Watches',
                    'Fashion Watches',
                    'Smart Watches',
                    'Vintage Watches',
                ]
            ],
            [
                'name' => 'Gemstones',
                'description' => 'Precious and semi-precious gemstones',
                'is_active' => true,
                'sort_order' => 6,
                'subcategories' => [
                    'Diamonds',
                    'Emeralds',
                    'Rubies',
                    'Sapphires',
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'];
            unset($categoryData['subcategories']);
            
            $categoryData['slug'] = Str::slug($categoryData['name']);
            
            $category = Category::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );

            // Create subcategories
            foreach ($subcategories as $index => $subcategoryName) {
                Category::firstOrCreate(
                    ['name' => $subcategoryName],
                    [
                        'name' => $subcategoryName,
                        'slug' => Str::slug($subcategoryName),
                        'description' => "Premium {$subcategoryName} collection",
                        'parent_id' => $category->id,
                        'is_active' => true,
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }
    }
}
