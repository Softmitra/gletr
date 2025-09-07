<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SellerAuthService;
use App\Models\SellerSession;
use App\Models\SellerActivity;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SellerLoginController extends Controller
{
    public function __construct(
        private SellerAuthService $sellerAuthService
    ) {}

    /**
     * Show the seller login form.
     */
    public function create(): View
    {
        return view('auth.seller-login');
    }

    /**
     * Handle seller login request.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['boolean'],
        ]);

        // Authenticate seller through service
        $seller = $this->sellerAuthService->authenticate(
            $credentials['email'],
            $credentials['password'],
            $credentials['remember'] ?? false
        );

        // Login the seller
        $this->sellerAuthService->login(
            $seller,
            $credentials['remember'] ?? false
        );

        // Regenerate session for security
        $request->session()->regenerate();

        // Create session and activity tracking
        $this->createSellerSession($seller, $request);
        $this->logSellerActivity($seller, $request, 'login', 'Seller logged in successfully');

        // Redirect based on verification status
        return $this->redirectAfterLogin($seller);
    }

    /**
     * Handle seller logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $seller = auth('seller')->user();
        
        if ($seller) {
            // Log logout activity
            $this->logSellerActivity($seller, $request, 'logout', 'Seller logged out');
            
            // Mark current session as logged out
            $currentSession = SellerSession::where('seller_id', $seller->id)
                ->where('session_id', $request->session()->getId())
                ->where('is_active', true)
                ->first();
                
            if ($currentSession) {
                $currentSession->markAsLoggedOut();
            }
        }

        // Logout through service
        $this->sellerAuthService->logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login')
            ->with('success', 'You have been successfully logged out.');
    }

    /**
     * Redirect seller after login based on their verification status
     */
    private function redirectAfterLogin($seller): RedirectResponse
    {
        // Get intended URL from session (set by our custom middleware)
        $intendedUrl = session('url.intended');
        
        // First check if email is verified - this is the most important step
        if (!$seller->email_verified_at) {
            // Email not verified - check if there's a pending OTP
            $pendingOtp = \App\Models\EmailVerificationOtp::forEmailAndType($seller->email, 'email_verification')
                ->valid()
                ->first();
            
            if ($pendingOtp) {
                // There's a valid OTP waiting, redirect to verification page
                session(['verification_email' => $seller->email]);
                return redirect()->route('seller.verify-email')
                    ->with('info', 'Please complete your email verification. Check your email for the verification code.');
            } else {
                // No pending OTP, generate and send new one
                $otpService = app(\App\Services\OtpService::class);
                $result = $otpService->generateAndSendOtp($seller->email, 'email_verification');
                
                if ($result['success']) {
                    session(['verification_email' => $seller->email]);
                    return redirect()->route('seller.verify-email')
                        ->with('success', 'New verification code sent! Please check your email.');
                } else {
                    return redirect()->route('seller.login')
                        ->with('error', 'Unable to send verification code. Please try again.');
                }
            }
        }
        
        // Email is verified, now check other verification statuses
        if ($seller->isFullyVerified()) {
            // If there's an intended URL and seller is verified, redirect there
            if ($intendedUrl && str_contains($intendedUrl, '/seller/')) {
                session()->forget('url.intended');
                return redirect($intendedUrl)
                    ->with('success', 'Welcome back! You have been successfully logged in.');
            }
            return redirect()->route('seller.dashboard')
                ->with('success', 'Welcome back! You have been successfully logged in.');
        } elseif ($seller->isPendingVerification() || $seller->hasDocumentsVerified()) {
            return redirect()->route('seller.verification.status')
                ->with('info', 'Welcome back! Please check your verification status.');
        } elseif ($seller->isVerificationRejected()) {
            return redirect()->route('seller.verification.documents')
                ->with('warning', 'Welcome back! Please resubmit your rejected documents.');
        } else {
            return redirect()->route('seller.verification.status')
                ->with('info', 'Welcome back! Please complete your verification process.');
        }
    }

    /**
     * Create seller session record
     */
    private function createSellerSession($seller, Request $request): void
    {
        // Create session tracking record
        $session = SellerSession::createSession($seller, $request);
        
        // Clean up old inactive sessions (keep last 50)
        $oldSessions = SellerSession::where('seller_id', $seller->id)
            ->inactive()
            ->orderBy('logout_at', 'desc')
            ->skip(50)
            ->pluck('id');
            
        if ($oldSessions->isNotEmpty()) {
            SellerSession::whereIn('id', $oldSessions)->delete();
        }
    }

    /**
     * Log seller activity
     */
    private function logSellerActivity($seller, Request $request, string $activityType, string $description): void
    {
        // Get current session
        $session = SellerSession::where('seller_id', $seller->id)
            ->where('session_id', $request->session()->getId())
            ->where('is_active', true)
            ->first();

        SellerActivity::create([
            'seller_id' => $seller->id,
            'seller_session_id' => $session?->id,
            'activity_type' => $activityType,
            'action' => $activityType,
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'request_data' => $activityType === 'login' ? ['remember' => $request->boolean('remember')] : null,
            'status_code' => 200,
        ]);
    }
}