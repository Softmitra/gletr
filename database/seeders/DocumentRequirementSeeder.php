<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentRequirement;

class DocumentRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentRequirements = [
            [
                'document_type' => 'bis_hallmark_license',
                'document_name' => 'BIS Hallmark License',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman', 'platinum_dealer'],
                'description' => 'Bureau of Indian Standards hallmarking license',
                'is_active' => true
            ],
            [
                'document_type' => 'business_license',
                'document_name' => 'Business License',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman', 'platinum_dealer'],
                'description' => 'Valid business registration license',
                'is_active' => true
            ],
            [
                'document_type' => 'diamond_certification',
                'document_name' => 'Diamond Certification',
                'is_mandatory' => true,
                'applicable_seller_types' => ['diamond_dealer', 'general_jewelry', 'artisan_craftsman'],
                'description' => 'Diamond grading and authentication certificates',
                'is_active' => true
            ],
            [
                'document_type' => 'gst_certificate',
                'document_name' => 'GST Certificate',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman', 'platinum_dealer'],
                'description' => 'Goods and Services Tax registration certificate',
                'is_active' => true
            ],
            [
                'document_type' => 'identity_proof',
                'document_name' => 'Identity Proof',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman', 'platinum_dealer'],
                'description' => 'Valid government-issued identity proof (Aadhaar, PAN, Passport)',
                'is_active' => true
            ],
            [
                'document_type' => 'address_proof',
                'document_name' => 'Address Proof',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman', 'platinum_dealer'],
                'description' => 'Valid address proof (Utility bill, Bank statement, Rental agreement)',
                'is_active' => true
            ],
            [
                'document_type' => 'bank_documents',
                'document_name' => 'Bank Documents',
                'is_mandatory' => true,
                'applicable_seller_types' => ['gold_dealer', 'diamond_dealer', 'general_jewelry', 'artisan_craftsman', 'platinum_dealer'],
                'description' => 'Bank account details and cancelled cheque',
                'is_active' => true
            ]
        ];

        foreach ($documentRequirements as $requirement) {
            DocumentRequirement::create($requirement);
        }
    }
}
