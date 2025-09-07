<?php

namespace App\Constants;

class SellerStatus
{
    // Seller verification statuses
    public const PENDING = 'pending';
    public const DOCUMENTS_PENDING = 'documents_pending';
    public const DOCUMENTS_SUBMITTED = 'documents_submitted';
    public const UNDER_REVIEW = 'under_review';
    public const VERIFIED = 'verified';
    public const REJECTED = 'rejected';
    public const SUSPENDED = 'suspended';
    public const INACTIVE = 'inactive';
    
    // Status display names
    public const DISPLAY_NAMES = [
        self::PENDING => 'Registration Pending',
        self::DOCUMENTS_PENDING => 'Documents Pending',
        self::DOCUMENTS_SUBMITTED => 'Documents Submitted',
        self::UNDER_REVIEW => 'Under Review',
        self::VERIFIED => 'Verified',
        self::REJECTED => 'Rejected',
        self::SUSPENDED => 'Suspended',
        self::INACTIVE => 'Inactive',
    ];
    
    // Status badge classes for UI
    public const BADGE_CLASSES = [
        self::PENDING => 'bg-yellow-100 text-yellow-800',
        self::DOCUMENTS_PENDING => 'bg-orange-100 text-orange-800',
        self::DOCUMENTS_SUBMITTED => 'bg-blue-100 text-blue-800',
        self::UNDER_REVIEW => 'bg-purple-100 text-purple-800',
        self::VERIFIED => 'bg-green-100 text-green-800',
        self::REJECTED => 'bg-red-100 text-red-800',
        self::SUSPENDED => 'bg-red-100 text-red-800',
        self::INACTIVE => 'bg-gray-100 text-gray-800',
    ];
    
    /**
     * Get all available statuses
     */
    public static function getAllStatuses(): array
    {
        return [
            self::PENDING,
            self::DOCUMENTS_PENDING,
            self::DOCUMENTS_SUBMITTED,
            self::UNDER_REVIEW,
            self::VERIFIED,
            self::REJECTED,
            self::SUSPENDED,
            self::INACTIVE,
        ];
    }
    
    /**
     * Get display name for status
     */
    public static function getDisplayName(string $status): string
    {
        return self::DISPLAY_NAMES[$status] ?? 'Unknown';
    }
    
    /**
     * Get badge class for status
     */
    public static function getBadgeClass(string $status): string
    {
        return self::BADGE_CLASSES[$status] ?? 'bg-gray-100 text-gray-800';
    }
    
    /**
     * Check if seller is verified
     */
    public static function isVerified(string $status): bool
    {
        return $status === self::VERIFIED;
    }
    
    /**
     * Check if seller is pending
     */
    public static function isPending(string $status): bool
    {
        return in_array($status, [self::PENDING, self::DOCUMENTS_PENDING, self::DOCUMENTS_SUBMITTED, self::UNDER_REVIEW]);
    }
    
    /**
     * Check if seller is rejected
     */
    public static function isRejected(string $status): bool
    {
        return $status === self::REJECTED;
    }
    
    /**
     * Check if seller is active
     */
    public static function isActive(string $status): bool
    {
        return in_array($status, [self::VERIFIED, self::DOCUMENTS_SUBMITTED, self::UNDER_REVIEW]);
    }
}
