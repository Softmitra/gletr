<?php

namespace App\Services;

use App\Models\Seller;
use App\Repositories\Interfaces\SellerProfileRepositoryInterface;
use App\Services\Interfaces\SellerProfileServiceInterface;
use App\Constants\SellerStatus;
use App\Constants\DocumentStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SellerProfileService implements SellerProfileServiceInterface
{
    public function __construct(
        private SellerProfileRepositoryInterface $profileRepository
    ) {}

    /**
     * Get seller profile data
     */
    public function getProfileData(int $sellerId): array
    {
        $seller = $this->profileRepository->getSellerWithRelations($sellerId, [
            'sellerType',
            'sellerDocuments',
            'verificationLogs.user'
        ]);

        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        return [
            'seller' => $seller,
            'verification_status' => $this->getVerificationStatus($sellerId),
            'activity_logs' => $this->profileRepository->getActivityLogs($seller, 20),
            'documents' => $seller->sellerDocuments,
            'profile_completion' => $this->calculateProfileCompletion($seller),
        ];
    }

    /**
     * Update seller profile
     */
    public function updateProfile(int $sellerId, array $data): bool
    {
        $seller = $this->profileRepository->findById($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        // Validate data
        $validatedData = $this->validateProfileData($data, $sellerId);

        // Update profile
        $updated = $this->profileRepository->updateProfile($seller, $validatedData);

        if ($updated) {
            Log::info('Seller profile updated', [
                'seller_id' => $sellerId,
                'updated_fields' => array_keys($validatedData)
            ]);
        }

        return $updated;
    }

    /**
     * Update seller password
     */
    public function updatePassword(int $sellerId, string $currentPassword, string $newPassword): bool
    {
        $seller = $this->profileRepository->findById($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        // Verify current password
        if (!Hash::check($currentPassword, $seller->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.']
            ]);
        }

        // Update password
        $updated = $this->profileRepository->updatePassword($seller, $newPassword);

        if ($updated) {
            Log::info('Seller password updated', ['seller_id' => $sellerId]);
        }

        return $updated;
    }

    /**
     * Update seller avatar
     */
    public function updateAvatar(int $sellerId, UploadedFile $file): array
    {
        $seller = $this->profileRepository->findById($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        // Validate file
        $validator = Validator::make(['avatar' => $file], [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        try {
            $path = $this->profileRepository->updateAvatar($seller, $file);
            
            Log::info('Seller avatar updated', [
                'seller_id' => $sellerId,
                'file_path' => $path
            ]);

            return [
                'success' => true,
                'path' => $path,
                'url' => asset('storage/' . $path)
            ];
        } catch (\Exception $e) {
            Log::error('Failed to update seller avatar', [
                'seller_id' => $sellerId,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Failed to update avatar: ' . $e->getMessage());
        }
    }

    /**
     * Update business information
     */
    public function updateBusinessInfo(int $sellerId, array $data): bool
    {
        $seller = $this->profileRepository->findById($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        return $this->profileRepository->updateBusinessInfo($seller, $data);
    }

    /**
     * Update contact information
     */
    public function updateContactInfo(int $sellerId, array $data): bool
    {
        $seller = $this->profileRepository->findById($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        return $this->profileRepository->updateContactInfo($seller, $data);
    }

    /**
     * Get seller dashboard data
     */
    public function getDashboardData(int $sellerId): array
    {
        $seller = $this->profileRepository->getSellerWithRelations($sellerId, [
            'sellerDocuments',
            'verificationLogs'
        ]);

        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        return [
            'seller' => $seller,
            'stats' => [
                'total_products' => 0, // TODO: Implement when product module is ready
                'active_products' => 0,
                'total_orders' => 0,
                'total_revenue' => 0,
            ],
            'verification_status' => $this->getVerificationStatus($sellerId),
            'recent_activities' => $this->profileRepository->getActivityLogs($seller, 10),
        ];
    }

    /**
     * Get seller verification status
     */
    public function getVerificationStatus(int $sellerId): array
    {
        $seller = $this->profileRepository->getSellerWithRelations($sellerId, ['sellerDocuments']);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        $documents = $seller->sellerDocuments;
        
        $documentStats = [
            'total' => $documents->count(),
            'pending' => $documents->where('verification_status', DocumentStatus::PENDING)->count(),
            'verified' => $documents->where('verification_status', DocumentStatus::VERIFIED)->count(),
            'rejected' => $documents->where('verification_status', DocumentStatus::REJECTED)->count(),
        ];

        return [
            'status' => $seller->verification_status,
            'is_verified' => $seller->isFullyVerified(),
            'documents' => $documentStats,
            'progress_percentage' => $this->calculateVerificationProgress($seller, $documentStats),
            'next_step' => $this->getNextVerificationStep($seller, $documentStats),
        ];
    }

    /**
     * Validate profile update data
     */
    public function validateProfileData(array $data, int $sellerId): array
    {
        $rules = [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'sometimes|string|max:20',
            'business_name' => 'sometimes|string|max:255',
            'business_type' => 'sometimes|string|max:100',
            'address' => 'sometimes|string|max:500',
            'city' => 'sometimes|string|max:100',
            'state' => 'sometimes|string|max:100',
            'postal_code' => 'sometimes|string|max:20',
            'country' => 'sometimes|string|max:100',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $validatedData = $validator->validated();

        // Check email uniqueness if email is being updated
        if (isset($validatedData['email'])) {
            if ($this->profileRepository->emailExistsForOtherSellers($validatedData['email'], $sellerId)) {
                throw ValidationException::withMessages([
                    'email' => ['The email has already been taken by another seller.']
                ]);
            }
        }

        return $validatedData;
    }

    /**
     * Get seller activity timeline
     */
    public function getActivityTimeline(int $sellerId): array
    {
        $seller = $this->profileRepository->findById($sellerId);
        
        if (!$seller) {
            throw new \Exception('Seller not found');
        }

        $activities = $this->profileRepository->getActivityLogs($seller, 50);

        return $activities->map(function ($activity) {
            return [
                'id' => $activity->id,
                'action' => $activity->action,
                'formatted_action' => $activity->formatted_action,
                'user' => $activity->user ? $activity->user->name : 'System',
                'created_at' => $activity->created_at,
                'data' => $activity->data,
            ];
        })->toArray();
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion(Seller $seller): int
    {
        $fields = [
            'name', 'email', 'phone', 'business_name', 'business_type',
            'address', 'city', 'state', 'postal_code', 'country'
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($seller->$field)) {
                $completed++;
            }
        }

        return round(($completed / count($fields)) * 100);
    }

    /**
     * Calculate verification progress
     */
    private function calculateVerificationProgress(Seller $seller, array $documentStats): int
    {
        $totalSteps = 4;
        $completedSteps = 1; // Registration complete

        // Documents uploaded
        if ($documentStats['total'] > 0) {
            $completedSteps++;
        }

        // Documents reviewed
        if ($documentStats['total'] > 0 && $documentStats['pending'] === 0) {
            $completedSteps++;
        }

        // Final verification
        if ($seller->verification_status === SellerStatus::VERIFIED) {
            $completedSteps++;
        }

        return round(($completedSteps / $totalSteps) * 100);
    }

    /**
     * Get next verification step
     */
    private function getNextVerificationStep(Seller $seller, array $documentStats): string
    {
        if ($seller->verification_status === SellerStatus::VERIFIED) {
            return 'Verification complete';
        }

        if ($documentStats['total'] === 0) {
            return 'Upload required documents';
        }

        if ($documentStats['rejected'] > 0) {
            return 'Resubmit rejected documents';
        }

        if ($documentStats['pending'] > 0) {
            return 'Wait for document review';
        }

        return 'Wait for final approval';
    }
}
