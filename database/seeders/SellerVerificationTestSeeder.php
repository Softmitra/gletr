<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;
use App\Models\SellerType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SellerVerificationTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test seller types if they don't exist
        $individualType = SellerType::firstOrCreate([
            'name' => 'Individual',
            'slug' => 'individual',
            'status' => true,
            'sort_order' => 1,
        ]);

        $businessType = SellerType::firstOrCreate([
            'name' => 'Business',
            'slug' => 'business', 
            'status' => true,
            'sort_order' => 2,
        ]);

        // Create test sellers with different verification statuses
        $testSellers = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+91-9876543210',
                'business_name' => 'John\'s Jewelry Store',
                'seller_type_id' => $individualType->id,
                'verification_status' => 'pending',
                'status' => 'pending',
                'documents' => json_encode([
                    [
                        'document_requirement_id' => 1,
                        'document_name' => 'Aadhaar Card',
                        'file_path' => 'sellers/documents/test_aadhaar.pdf',
                        'original_filename' => 'aadhaar_card.pdf',
                        'file_size' => 1024000,
                        'mime_type' => 'application/pdf',
                        'is_verified' => false,
                        'uploaded_at' => now()->subDays(2)->toDateTimeString(),
                    ],
                    [
                        'document_requirement_id' => 2,
                        'document_name' => 'PAN Card',
                        'file_path' => 'sellers/documents/test_pan.pdf',
                        'original_filename' => 'pan_card.pdf',
                        'file_size' => 512000,
                        'mime_type' => 'application/pdf',
                        'is_verified' => false,
                        'uploaded_at' => now()->subDays(2)->toDateTimeString(),
                    ],
                ]),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+91-9876543211',
                'business_name' => 'Smith Gems & Jewelry',
                'seller_type_id' => $businessType->id,
                'verification_status' => 'documents_verified',
                'status' => 'pending',
                'documents' => json_encode([
                    [
                        'document_requirement_id' => 1,
                        'document_name' => 'GST Certificate',
                        'file_path' => 'sellers/documents/test_gst.pdf',
                        'original_filename' => 'gst_certificate.pdf',
                        'file_size' => 2048000,
                        'mime_type' => 'application/pdf',
                        'is_verified' => true,
                        'verification_status' => 'approved',
                        'verified_at' => now()->subDays(1)->toDateTimeString(),
                        'uploaded_at' => now()->subDays(3)->toDateTimeString(),
                    ],
                    [
                        'document_requirement_id' => 2,
                        'document_name' => 'Trade License',
                        'file_path' => 'sellers/documents/test_trade_license.pdf',
                        'original_filename' => 'trade_license.pdf',
                        'file_size' => 1536000,
                        'mime_type' => 'application/pdf',
                        'is_verified' => true,
                        'verification_status' => 'approved',
                        'verified_at' => now()->subDays(1)->toDateTimeString(),
                        'uploaded_at' => now()->subDays(3)->toDateTimeString(),
                    ],
                ]),
            ],
            [
                'name' => 'Raj Patel',
                'email' => 'raj.patel@example.com',
                'phone' => '+91-9876543212',
                'business_name' => 'Patel Precious Metals',
                'seller_type_id' => $individualType->id,
                'verification_status' => 'verified',
                'status' => 'active',
                'is_verified' => true,
                'verification_completed_at' => now()->subDays(1),
                'documents' => json_encode([
                    [
                        'document_requirement_id' => 1,
                        'document_name' => 'Aadhaar Card',
                        'file_path' => 'sellers/documents/test_aadhaar_raj.pdf',
                        'original_filename' => 'raj_aadhaar.pdf',
                        'file_size' => 1024000,
                        'mime_type' => 'application/pdf',
                        'is_verified' => true,
                        'verification_status' => 'approved',
                        'verified_at' => now()->subDays(2)->toDateTimeString(),
                        'uploaded_at' => now()->subDays(5)->toDateTimeString(),
                    ],
                ]),
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.sharma@example.com',
                'phone' => '+91-9876543213',
                'business_name' => 'Sharma Jewelry Collection',
                'seller_type_id' => $individualType->id,
                'verification_status' => 'rejected',
                'status' => 'suspended',
                'verification_notes' => 'Documents are not clear and readable. Please resubmit with better quality images.',
                'documents' => json_encode([
                    [
                        'document_requirement_id' => 1,
                        'document_name' => 'Aadhaar Card',
                        'file_path' => 'sellers/documents/test_aadhaar_priya.pdf',
                        'original_filename' => 'priya_aadhaar.pdf',
                        'file_size' => 512000,
                        'mime_type' => 'application/pdf',
                        'is_verified' => false,
                        'verification_status' => 'rejected',
                        'verification_comments' => 'Image is blurry and text is not readable',
                        'verified_at' => now()->subDays(1)->toDateTimeString(),
                        'uploaded_at' => now()->subDays(4)->toDateTimeString(),
                    ],
                ]),
            ],
        ];

        foreach ($testSellers as $sellerData) {
            // Add common fields
            $sellerData = array_merge($sellerData, [
                'password' => Hash::make('password123'),
                'pincode' => '400001',
                'address_line_1' => 'Test Address Line 1',
                'area' => 'Test Area',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'bank_name' => 'Test Bank',
                'holder_name' => $sellerData['name'],
                'account_no' => '1234567890',
                'ifsc_code' => 'TEST0001234',
                'branch' => 'Test Branch',
            ]);

            Seller::firstOrCreate(
                ['email' => $sellerData['email']],
                $sellerData
            );
        }

        // Create test users with verification roles
        $documentVerifierRole = Role::where('name', 'document_verifier')->first();
        $seniorVerifierRole = Role::where('name', 'senior_verifier')->first();

        if ($documentVerifierRole) {
            $verifier = User::firstOrCreate(
                ['email' => 'verifier@gletr.com'],
                [
                    'name' => 'Document Verifier',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );
            $verifier->assignRole($documentVerifierRole);
        }

        if ($seniorVerifierRole) {
            $seniorVerifier = User::firstOrCreate(
                ['email' => 'senior.verifier@gletr.com'],
                [
                    'name' => 'Senior Verifier',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );
            $seniorVerifier->assignRole($seniorVerifierRole);
        }

        $this->command->info('Test seller verification data created successfully!');
        $this->command->info('Test sellers created: ' . count($testSellers));
        $this->command->info('Test users created: Document Verifier (verifier@gletr.com), Senior Verifier (senior.verifier@gletr.com)');
        $this->command->info('Password for all test accounts: password123');
    }
}
