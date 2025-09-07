<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OtpVerificationController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ) {}

    /**
     * Show email verification form
     */
    public function showVerificationForm(): View|RedirectResponse
    {
        $email = session('verification_email');
        
        if (!$email) {
            return redirect()->route('seller.register')
                ->with('error', 'Please complete registration first.');
        }

        return view('auth.email-verification', compact('email'));
    }

    /**
     * Verify OTP and complete registration
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => 'required|string|size:6|regex:/^[0-9]{6}$/',
        ], [
            'otp.required' => 'Please enter the verification code.',
            'otp.size' => 'Verification code must be 6 digits.',
            'otp.regex' => 'Verification code must contain only numbers.',
        ]);

        $email = session('verification_email');
        
        if (!$email) {
            return redirect()->route('seller.register')
                ->with('error', 'Session expired. Please register again.');
        }

        $result = $this->otpService->verifyOtp($email, $request->otp, 'email_verification');

        if (!$result['success']) {
            return back()->withErrors(['otp' => $result['message']]);
        }

        // Mark seller email as verified
        $seller = Seller::where('email', $email)->first();
        if ($seller) {
            $seller->update([
                'email_verified_at' => now(),
                'status' => 'active', // Activate seller after email verification
            ]);

            Log::info('Seller email verified successfully', [
                'seller_id' => $seller->id,
                'email' => $email
            ]);
        }

        // Clear verification session
        session()->forget(['verification_email', 'seller_registration_data']);

        return redirect()->route('seller.login')
            ->with('success', 'Email verified successfully! You can now login to your account.');
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request): JsonResponse
    {
        $email = session('verification_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please register again.'
            ], 400);
        }

        $result = $this->otpService->resendOtp($email, 'email_verification');

        return response()->json($result);
    }

    /**
     * Check OTP status (for AJAX requests)
     */
    public function checkOtpStatus(Request $request): JsonResponse
    {
        $email = session('verification_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'No verification session found.'
            ], 400);
        }

        $isVerified = $this->otpService->isEmailVerified($email, 'email_verification');
        $expiry = $this->otpService->getOtpExpiry($email, 'email_verification');

        return response()->json([
            'success' => true,
            'is_verified' => $isVerified,
            'expires_at' => $expiry?->toISOString(),
            'expires_in' => $expiry ? $expiry->diffInSeconds(now()) : 0
        ]);
    }
}