<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $seller = Auth::guard('seller')->user();
        
        if (!$seller) {
            return redirect()->route('seller.login');
        }
        
        if (!$seller->isFullyVerified()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your account verification is required to access this feature.',
                    'redirect_url' => route('seller.verification.status')
                ], 403);
            }
            
            return redirect()->route('seller.verification.status')
                ->with('warning', 'Please complete your account verification to access this feature.');
        }
        
        return $next($request);
    }
}