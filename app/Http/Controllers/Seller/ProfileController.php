<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\SellerProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private SellerProfileServiceInterface $profileService
    ) {}

    /**
     * Show seller profile
     */
    public function show(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $profileData = $this->profileService->getProfileData($sellerId);

        return view('seller.profile.show', $profileData);
    }

    /**
     * Show profile edit form
     */
    public function edit(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $profileData = $this->profileService->getProfileData($sellerId);

        return view('seller.profile.edit', $profileData);
    }

    /**
     * Update seller profile
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->profileService->updateProfile($sellerId, $request->all());

            return redirect()->route('seller.profile.show')
                ->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Update seller password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->profileService->updatePassword(
                $sellerId,
                $request->current_password,
                $request->password
            );

            return redirect()->route('seller.profile.show')
                ->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update seller avatar
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->profileService->updateAvatar($sellerId, $request->file('avatar'));

            return redirect()->route('seller.profile.show')
                ->with('success', 'Profile picture updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show business information edit form
     */
    public function editBusiness(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $profileData = $this->profileService->getProfileData($sellerId);

        return view('seller.profile.business', $profileData);
    }

    /**
     * Update business information
     */
    public function updateBusiness(Request $request): RedirectResponse
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:100',
            'business_registration_number' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:50',
            'gst_number' => 'nullable|string|max:50',
            'business_address' => 'required|string|max:500',
            'business_city' => 'required|string|max:100',
            'business_state' => 'required|string|max:100',
            'business_postal_code' => 'required|string|max:20',
            'business_country' => 'required|string|max:100',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->profileService->updateBusinessInfo($sellerId, $request->all());

            return redirect()->route('seller.profile.show')
                ->with('success', 'Business information updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show contact information edit form
     */
    public function editContact(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $profileData = $this->profileService->getProfileData($sellerId);

        return view('seller.profile.contact', $profileData);
    }

    /**
     * Update contact information
     */
    public function updateContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->profileService->updateContactInfo($sellerId, $request->all());

            return redirect()->route('seller.profile.show')
                ->with('success', 'Contact information updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show seller settings
     */
    public function settings(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $profileData = $this->profileService->getProfileData($sellerId);

        return view('seller.profile.settings', $profileData);
    }

    /**
     * Show activity timeline
     */
    public function activity(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $activities = $this->profileService->getActivityTimeline($sellerId);

        return view('seller.profile.activity', compact('activities'));
    }
}
