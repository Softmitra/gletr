<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if seller is authenticated
        if (!Auth::guard('seller')->check()) {
            return redirect()->route('seller.login')->with('error', 'Please login to access your seller dashboard.');
        }

        $seller = Auth::guard('seller')->user();

        // Check if seller account is suspended
        if ($seller->status === 'suspended') {
            Auth::guard('seller')->logout();
            return redirect()->route('seller.login')->with('error', 'Your seller account has been suspended. Please contact support.');
        }

        // Allow access to verification status page even if not verified
        if ($request->routeIs('seller.verification.*')) {
            return $next($request);
        }

        // For other routes, check if seller is verified (optional - can be removed if you want to allow unverified sellers)
        // Uncomment the following lines if you want to restrict access to verified sellers only
        /*
        if (!$seller->isFullyVerified()) {
            return redirect()->route('seller.verification.status')
                ->with('warning', 'Please complete your verification process to access all features.');
        }
        */

        return $next($request);
    }
}