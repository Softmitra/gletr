<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use App\Models\Seller;
use App\Models\EmailVerificationOtp;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class SellerVerificationController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ) {}

    /**
     * Show verification recovery page
     */
    public function showRecoveryForm(): View
    {
        return view('auth.verification-recovery');
    }

    /**
     * Handle verification recovery request
     */
    public function handleRecovery(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Check if seller exists and is not verified
        $seller = Seller::where('email', $email)->first();

        if (!$seller) {
            return back()->withErrors(['email' => 'No seller account found with this email address.']);
        }

        if ($seller->email_verified_at) {
            return redirect()->route('seller.login')
                ->with('info', 'Your email is already verified. You can login to your account.');
        }

        // Check if there's a pending OTP
        $pendingOtp = EmailVerificationOtp::forEmailAndType($email, 'email_verification')
            ->valid()
            ->first();

        if ($pendingOtp) {
            // There's already a valid OTP, redirect to verification page
            session(['verification_email' => $email]);
            return redirect()->route('seller.verify-email')
                ->with('info', 'We found your pending verification. Please check your email for the verification code.');
        }

        // Generate and send new OTP
        $result = $this->otpService->generateAndSendOtp($email, 'email_verification');

        if (!$result['success']) {
            return back()->withErrors(['email' => $result['message']]);
        }

        // Store verification email in session
        session(['verification_email' => $email]);

        Log::info('Verification recovery initiated', [
            'email' => $email,
            'seller_id' => $seller->id
        ]);

        return redirect()->route('seller.verify-email')
            ->with('success', 'New verification code sent! Please check your email.');
    }

    /**
     * Check verification status for email
     */
    public function checkVerificationStatus(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $seller = Seller::where('email', $email)->first();

        if (!$seller) {
            return response()->json([
                'exists' => false,
                'verified' => false,
                'message' => 'No seller account found with this email.'
            ]);
        }

        $isVerified = (bool) $seller->email_verified_at;
        $pendingOtp = EmailVerificationOtp::forEmailAndType($email, 'email_verification')
            ->valid()
            ->first();

        return response()->json([
            'exists' => true,
            'verified' => $isVerified,
            'has_pending_otp' => (bool) $pendingOtp,
            'otp_expires_at' => $pendingOtp?->expires_at?->toISOString(),
            'message' => $isVerified 
                ? 'Email is already verified' 
                : ($pendingOtp ? 'Verification pending' : 'No pending verification')
        ]);
    }
}
