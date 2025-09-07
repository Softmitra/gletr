<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with the default web guard
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'redirect_url' => route('admin.login')
                ], 401);
            }
            
            // Store the intended URL for redirect after login
            session(['url.intended' => $request->url()]);
            
            return redirect()->route('admin.login')
                ->with('info', 'Please login to access the admin dashboard.');
        }

        $user = Auth::user();

        // Check if user has admin role
        if (!$user->hasAnyRole(['super_admin', 'ops_admin'])) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('admin.login')
                ->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}