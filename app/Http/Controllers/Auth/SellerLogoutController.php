<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerLogoutController extends Controller
{
    /**
     * Handle seller logout
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // Logout the seller
        Auth::guard('seller')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('seller.login')->with('status', 'You have been logged out successfully.');
    }
}
