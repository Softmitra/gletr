<?php

namespace Database\Seeders;

use App\Models\SellerType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SellerTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellerTypes = [
            [
                'name' => 'Gold Dealer',
                'slug' => 'gold_dealer',
                'description' => 'Dealers specializing in gold jewelry and ornaments',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'bis_hallmark_license',
                    'gold_dealer_license',
                    'identity_proof',
                    'address_proof',
                    'bank_documents'
                ],
                'status' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Diamond Dealer',
                'slug' => 'diamond_dealer',
                'description' => 'Dealers specializing in diamond jewelry and precious stones',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'diamond_certification',
                    'gemological_certificates',
                    'identity_proof',
                    'address_proof',
                    'bank_documents',
                    'import_export_license'
                ],
                'status' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'General Jewelry',
                'slug' => 'general_jewelry',
                'description' => 'General jewelry dealers and retailers',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'trade_license',
                    'identity_proof',
                    'address_proof',
                    'bank_documents'
                ],
                'status' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Artisan/Craftsman',
                'slug' => 'artisan_craftsman',
                'description' => 'Individual artisans and craftsmen creating handmade jewelry',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'identity_proof',
                    'address_proof',
                    'bank_documents',
                    'quality_certification'
                ],
                'status' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Platinum Dealer',
                'slug' => 'platinum_dealer',
                'description' => 'Dealers specializing in platinum jewelry',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'bis_hallmark_license',
                    'quality_certification',
                    'identity_proof',
                    'address_proof',
                    'bank_documents'
                ],
                'status' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Silver Dealer',
                'slug' => 'silver_dealer',
                'description' => 'Dealers specializing in silver jewelry and ornaments',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'bis_hallmark_license',
                    'identity_proof',
                    'address_proof',
                    'bank_documents'
                ],
                'status' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'Gemstone Dealer',
                'slug' => 'gemstone_dealer',
                'description' => 'Dealers specializing in precious and semi-precious gemstones',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'gemological_certificates',
                    'quality_certification',
                    'identity_proof',
                    'address_proof',
                    'bank_documents',
                    'import_export_license'
                ],
                'status' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'Watch Dealer',
                'slug' => 'watch_dealer',
                'description' => 'Dealers specializing in luxury watches and timepieces',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'trade_license',
                    'identity_proof',
                    'address_proof',
                    'bank_documents',
                    'insurance_certificate'
                ],
                'status' => true,
                'sort_order' => 8
            ],
            [
                'name' => 'Antique Jewelry',
                'slug' => 'antique_jewelry',
                'description' => 'Dealers specializing in antique and vintage jewelry',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'trade_license',
                    'quality_certification',
                    'identity_proof',
                    'address_proof',
                    'bank_documents',
                    'insurance_certificate'
                ],
                'status' => true,
                'sort_order' => 9
            ],
            [
                'name' => 'Costume Jewelry',
                'slug' => 'costume_jewelry',
                'description' => 'Dealers specializing in fashion and costume jewelry',
                'document_requirements' => [
                    'business_license',
                    'gst_certificate',
                    'trade_license',
                    'identity_proof',
                    'address_proof',
                    'bank_documents'
                ],
                'status' => true,
                'sort_order' => 10
            ]
        ];

        foreach ($sellerTypes as $sellerType) {
            SellerType::updateOrCreate(
                ['slug' => $sellerType['slug']],
                $sellerType
            );
        }
    }
}
