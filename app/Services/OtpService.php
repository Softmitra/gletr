<?php

namespace App\Services;

use App\Models\EmailVerificationOtp;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OtpService
{
    /**
     * Generate and send OTP for email verification
     */
    public function generateAndSendOtp(string $email, string $type = 'email_verification', int $expiryMinutes = 10): array
    {
        try {
            // Clean up expired OTPs for this email
            $this->cleanupExpiredOtps($email, $type);

            // Check if there's already a valid OTP
            $existingOtp = EmailVerificationOtp::forEmailAndType($email, $type)
                ->valid()
                ->first();

            if ($existingOtp) {
                // If OTP was sent less than 1 minute ago, don't send another
                if ($existingOtp->created_at->diffInMinutes(now()) < 1) {
                    return [
                        'success' => false,
                        'message' => 'Please wait before requesting another OTP.',
                        'retry_after' => 60 - $existingOtp->created_at->diffInSeconds(now())
                    ];
                }
            }

            // Generate 6-digit OTP
            $otp = $this->generateOtp();

            // Create OTP record
            $otpRecord = EmailVerificationOtp::create([
                'email' => $email,
                'otp' => $otp,
                'type' => $type,
                'expires_at' => now()->addMinutes($expiryMinutes),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Send OTP via email
            $this->sendOtpEmail($email, $otp, $type);

            Log::info('OTP generated and sent', [
                'email' => $email,
                'type' => $type,
                'otp_id' => $otpRecord->id,
                'expires_at' => $otpRecord->expires_at
            ]);

            return [
                'success' => true,
                'message' => 'OTP sent successfully to your email address.',
                'expires_in' => $expiryMinutes * 60, // seconds
                'otp_id' => $otpRecord->id
            ];

        } catch (\Exception $e) {
            Log::error('Failed to generate and send OTP', [
                'email' => $email,
                'type' => $type,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(string $email, string $otp, string $type = 'email_verification'): array
    {
        try {
            $otpRecord = EmailVerificationOtp::forEmailAndType($email, $type)
                ->where('otp', $otp)
                ->first();

            if (!$otpRecord) {
                return [
                    'success' => false,
                    'message' => 'Invalid OTP.',
                    'attempts_remaining' => $this->getRemainingAttempts($email, $type)
                ];
            }

            if ($otpRecord->is_used) {
                return [
                    'success' => false,
                    'message' => 'This OTP has already been used.',
                    'attempts_remaining' => $this->getRemainingAttempts($email, $type)
                ];
            }

            if ($otpRecord->isExpired()) {
                return [
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new one.',
                    'attempts_remaining' => $this->getRemainingAttempts($email, $type)
                ];
            }

            // Mark OTP as used
            $otpRecord->markAsUsed();

            Log::info('OTP verified successfully', [
                'email' => $email,
                'type' => $type,
                'otp_id' => $otpRecord->id
            ]);

            return [
                'success' => true,
                'message' => 'Email verified successfully.',
                'verified_at' => now()
            ];

        } catch (\Exception $e) {
            Log::error('Failed to verify OTP', [
                'email' => $email,
                'type' => $type,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to verify OTP. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(string $email, string $type = 'email_verification'): array
    {
        // Clean up expired OTPs
        $this->cleanupExpiredOtps($email, $type);

        // Check rate limiting (max 5 OTPs per hour)
        $recentOtps = EmailVerificationOtp::forEmailAndType($email, $type)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentOtps >= 5) {
            return [
                'success' => false,
                'message' => 'Too many OTP requests. Please try again after 1 hour.',
                'retry_after' => 3600
            ];
        }

        return $this->generateAndSendOtp($email, $type);
    }

    /**
     * Generate 6-digit OTP
     */
    private function generateOtp(): string
    {
        return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Send OTP via email
     */
    private function sendOtpEmail(string $email, string $otp, string $type): void
    {
        $mailData = [
            'otp' => $otp,
            'email' => $email,
            'type' => $type,
            'expires_in' => 10, // minutes
        ];

        Mail::to($email)->send(new OtpVerificationMail($mailData));
    }

    /**
     * Clean up expired OTPs for specific email and type
     */
    private function cleanupExpiredOtps(string $email, string $type): void
    {
        EmailVerificationOtp::forEmailAndType($email, $type)
            ->where('expires_at', '<', now())
            ->delete();
    }

    /**
     * Get remaining attempts for email verification
     */
    private function getRemainingAttempts(string $email, string $type): int
    {
        $attempts = EmailVerificationOtp::forEmailAndType($email, $type)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        return max(0, 5 - $attempts);
    }

    /**
     * Check if email is verified (has valid OTP verification)
     */
    public function isEmailVerified(string $email, string $type = 'email_verification'): bool
    {
        return EmailVerificationOtp::forEmailAndType($email, $type)
            ->where('is_used', true)
            ->where('used_at', '>=', now()->subDay()) // Verification valid for 24 hours
            ->exists();
    }

    /**
     * Get OTP expiry time for email
     */
    public function getOtpExpiry(string $email, string $type = 'email_verification'): ?Carbon
    {
        $otp = EmailVerificationOtp::forEmailAndType($email, $type)
            ->valid()
            ->first();

        return $otp ? $otp->expires_at : null;
    }
}
