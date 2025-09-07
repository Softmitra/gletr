<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerAuth
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
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'redirect_url' => route('seller.login')
                ], 401);
            }
            
            // Store the intended URL for redirect after login
            session(['url.intended' => $request->url()]);
            
            return redirect()->route('seller.login')
                ->with('info', 'Please login to access your seller dashboard.');
        }

        $seller = Auth::guard('seller')->user();

        // Check if seller account is suspended
        if ($seller->status === 'suspended') {
            Auth::guard('seller')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('seller.login')
                ->with('error', 'Your seller account has been suspended. Please contact support.');
        }

        // Check if seller account is inactive
        if ($seller->status === 'inactive') {
            Auth::guard('seller')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('seller.login')
                ->with('error', 'Your seller account is inactive. Please contact support.');
        }

        return $next($request);
    }
}