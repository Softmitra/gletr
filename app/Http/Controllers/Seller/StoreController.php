<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\SellerStoreServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private SellerStoreServiceInterface $storeService
    ) {}

    /**
     * Show store dashboard
     */
    public function show(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $storeData = $this->storeService->getStoreDashboard($sellerId);

        return view('seller.store.show', $storeData);
    }

    /**
     * Show store edit form
     */
    public function edit(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $storeData = $this->storeService->getStoreEditData($sellerId);

        return view('seller.store.edit', $storeData);
    }

    /**
     * Update store information
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->storeService->updateStoreInfo($sellerId, $request->all());

            return redirect()->route('seller.store.show')
                ->with('success', 'Store information updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show store settings
     */
    public function settings(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $settingsData = $this->storeService->getStoreSettings($sellerId);

        return view('seller.store.settings', $settingsData);
    }

    /**
     * Update store settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->storeService->updateStoreSettings($sellerId, $request->all());

            return redirect()->route('seller.store.settings')
                ->with('success', 'Store settings updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show store branding
     */
    public function branding(): View
    {
        $sellerId = Auth::guard('seller')->id();
        $brandingData = $this->storeService->getStoreBranding($sellerId);

        return view('seller.store.branding', $brandingData);
    }

    /**
     * Update store branding
     */
    public function updateBranding(Request $request): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->storeService->updateStoreBranding($sellerId, $request->all());

            return redirect()->route('seller.store.branding')
                ->with('success', 'Store branding updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}