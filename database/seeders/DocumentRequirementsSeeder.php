<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentRequirement;

class DocumentRequirementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requirements = [
            [
                'document_type' => 'business_license',
                'document_name' => 'Business License',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman'],
                'description' => 'Valid business registration license',
                'is_active' => true
            ],
            [
                'document_type' => 'gst_certificate',
                'document_name' => 'GST Certificate',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman'],
                'description' => 'Goods and Services Tax registration certificate',
                'is_active' => true
            ],
            [
                'document_type' => 'bis_hallmark_license',
                'document_name' => 'BIS Hallmark License',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman'],
                'description' => 'Bureau of Indian Standards hallmarking license',
                'is_active' => true
            ],
            [
                'document_type' => 'gold_dealer_license',
                'document_name' => 'Gold Dealer License',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman'],
                'description' => 'Precious metals dealer license',
                'is_active' => true
            ],
            [
                'document_type' => 'diamond_certification',
                'document_name' => 'Diamond Certification',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman'],
                'description' => 'Diamond grading and authentication certificates',
                'is_active' => true
            ],
            [
                'document_type' => 'identity_proof',
                'document_name' => 'Identity Proof',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman'],
                'description' => 'Valid government-issued photo identification',
                'is_active' => true
            ]
        ];

        foreach ($requirements as $requirement) {
            DocumentRequirement::create($requirement);
        }
    }
}
