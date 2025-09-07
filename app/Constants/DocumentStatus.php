<?php

namespace App\Constants;

class DocumentStatus
{
    // Document verification statuses
    public const PENDING = 'pending';
    public const VERIFIED = 'verified';
    public const REJECTED = 'rejected';
    public const EXPIRED = 'expired';
    public const AI_VERIFIED = 'ai_verified'; // For future AI verification
    
    // Status display names
    public const DISPLAY_NAMES = [
        self::PENDING => 'Pending Review',
        self::VERIFIED => 'Verified',
        self::REJECTED => 'Rejected',
        self::EXPIRED => 'Expired',
        self::AI_VERIFIED => 'AI Verified',
    ];
    
    // Status badge classes for UI
    public const BADGE_CLASSES = [
        self::PENDING => 'bg-yellow-100 text-yellow-800',
        self::VERIFIED => 'bg-green-100 text-green-800',
        self::REJECTED => 'bg-red-100 text-red-800',
        self::EXPIRED => 'bg-gray-100 text-gray-800',
        self::AI_VERIFIED => 'bg-blue-100 text-blue-800',
    ];
    
    /**
     * Get all available statuses
     */
    public static function getAllStatuses(): array
    {
        return [
            self::PENDING,
            self::VERIFIED,
            self::REJECTED,
            self::EXPIRED,
            self::AI_VERIFIED,
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
     * Check if status is verified
     */
    public static function isVerified(string $status): bool
    {
        return in_array($status, [self::VERIFIED, self::AI_VERIFIED]);
    }
    
    /**
     * Check if status is pending
     */
    public static function isPending(string $status): bool
    {
        return $status === self::PENDING;
    }
    
    /**
     * Check if status is rejected
     */
    public static function isRejected(string $status): bool
    {
        return $status === self::REJECTED;
    }
    
    /**
     * Check if status is expired
     */
    public static function isExpired(string $status): bool
    {
        return $status === self::EXPIRED;
    }
}
