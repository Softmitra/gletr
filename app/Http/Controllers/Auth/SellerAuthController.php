<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SellerAuthController extends Controller
{
    /**
     * Show the seller login form
     */
    public function showLoginForm()
    {
        return view('auth.seller-login');
    }

    /**
     * Handle seller login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Rate limiting
        $key = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        // Find seller
        $seller = Seller::where('email', $request->email)->first();

        if (!$seller || !Hash::check($request->password, $seller->password)) {
            RateLimiter::hit($key);
            
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Check if seller account is active
        if ($seller->status === 'suspended') {
            throw ValidationException::withMessages([
                'email' => 'Your seller account has been suspended. Please contact support.',
            ]);
        }

        // Clear rate limiter
        RateLimiter::clear($key);

        // Log the seller in
        Auth::guard('seller')->login($seller, $request->boolean('remember'));

        // Update login tracking
        $this->updateLoginTracking($seller, $request);

        // Log successful login
        Log::info('Seller logged in successfully', [
            'seller_id' => $seller->id,
            'email' => $seller->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Redirect based on verification status
        return $this->redirectAfterLogin($seller);
    }

    /**
     * Handle seller logout
     */
    public function logout(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        
        if ($seller) {
            // Mark current session as logged out
            $currentSession = SellerSession::where('seller_id', $seller->id)
                ->where('session_id', $request->session()->getId())
                ->active()
                ->first();
                
            if ($currentSession) {
                $currentSession->markAsLoggedOut();
            }
            
            Log::info('Seller logged out', [
                'seller_id' => $seller->id,
                'email' => $seller->email,
                'ip' => $request->ip(),
            ]);
        }

        Auth::guard('seller')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show seller dashboard
     */
    public function dashboard()
    {
        $seller = Auth::guard('seller')->user();
        
        // Redirect to verification status if not fully verified
        if (!$seller->isFullyVerified()) {
            return redirect()->route('seller.verification.status')
                ->with('info', 'Please complete your account verification to access the dashboard.');
        }
        
        // Get dashboard statistics
        $stats = [
            'total_products' => $seller->products()->count(),
            'active_products' => $seller->products()->where('status', 'active')->count(),
            'total_orders' => $seller->orders()->count(),
            'pending_orders' => $seller->orders()->where('status', 'pending')->count(),
            'processing_orders' => $seller->orders()->where('status', 'processing')->count(),
            'total_revenue' => $seller->orders()->where('status', 'delivered')->sum('grand_total'),
            'this_month_revenue' => $seller->orders()
                ->where('status', 'delivered')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('grand_total'),
        ];

        // Get recent orders
        $recentOrders = $seller->orders()
            ->with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent activities
        $recentActivities = $seller->verificationLogs()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('seller.dashboard', compact('seller', 'stats', 'recentOrders', 'recentActivities'));
    }



    /**
     * Update login tracking information
     */
    private function updateLoginTracking(Seller $seller, Request $request)
    {
        $seller->update([
            'last_login_at' => now(),
            'login_count' => $seller->login_count + 1,
        ]);

        // Create session tracking record
        SellerSession::createSession($seller, $request);
        
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
     * Redirect seller after login based on their status
     */
    private function redirectAfterLogin(Seller $seller)
    {
        // Get intended URL from session (set by our custom middleware)
        $intendedUrl = session('url.intended');
        
        // Check verification status and redirect accordingly
        if ($seller->isFullyVerified()) {
            // If there's an intended URL and seller is verified, redirect there
            if ($intendedUrl && str_contains($intendedUrl, '/seller/')) {
                session()->forget('url.intended');
                return redirect($intendedUrl);
            }
            return redirect()->route('seller.dashboard');
        } elseif ($seller->isPendingVerification() || $seller->hasDocumentsVerified()) {
            return redirect()->route('seller.verification.status');
        } elseif ($seller->isVerificationRejected()) {
            return redirect()->route('seller.verification.status');
        } else {
            return redirect()->route('seller.verification.status');
        }
    }
}
