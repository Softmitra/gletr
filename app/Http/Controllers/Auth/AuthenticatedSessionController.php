<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Check if this is an admin login request
        if (request()->is('admin/login')) {
            return view('auth.admin-login');
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Check if this is an admin login (from /admin/login route)
        if ($request->is('admin/login')) {
            // For admin login, always redirect to admin dashboard
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back! You have been successfully logged in.');
        }

        // For other login routes, redirect based on user role
        if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back! You have been successfully logged in.');
        } elseif ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
            return redirect()->route('seller.dashboard')
                ->with('success', 'Welcome back! You have been successfully logged in.');
        } elseif ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Welcome back! You have been successfully logged in.');
        }

        // Default fallback - redirect to admin dashboard for any authenticated user
        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome back! You have been successfully logged in.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
