<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle user logout with role-based redirects
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Determine redirect URL based on user role
        $redirectUrl = '/';
        
        if ($user) {
            if ($user->hasAnyRole(['super_admin', 'ops_admin'])) {
                $redirectUrl = route('admin.login');
            } elseif ($user->hasAnyRole(['seller_owner', 'seller_staff'])) {
                $redirectUrl = route('seller.login');
            } else {
                // Customer or regular user
                $redirectUrl = route('home');
            }
        }
        
        // Logout the user
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect($redirectUrl)->with('status', 'You have been logged out successfully.');
    }
}
