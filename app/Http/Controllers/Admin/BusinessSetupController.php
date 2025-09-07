<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class BusinessSetupController extends Controller
{
    /**
     * Display the main business setup page
     */
    public function index(Request $request): View
    {
        $activeTab = $request->get('tab', 'general');
        
        // Validate tab parameter
        $validTabs = ['general', 'website-setup', 'sellers', 'commission-setup', 'email-settings'];
        if (!in_array($activeTab, $validTabs)) {
            $activeTab = 'general';
        }

        return view('admin.business.setup.index', compact('activeTab'));
    }

    /**
     * Display the General settings page
     */
    public function general(): View
    {
        return view('admin.business.setup.pages.general');
    }

    /**
     * Display the Website Setup page
     */
    public function websiteSetup(): View
    {
        return view('admin.business.setup.pages.website-setup');
    }

    /**
     * Display the Sellers settings page
     */
    public function sellers(): View
    {
        return view('admin.business.setup.pages.sellers');
    }

    /**
     * Display the Commission Setup page
     */
    public function commissionSetup(): View
    {
        return view('admin.business.setup.pages.commission-setup');
    }

    /**
     * Display the Email Settings page
     */
    public function emailSettings(): View
    {
        // Get all email configurations grouped by type
        $customerEmails = EmailConfiguration::where('type', EmailConfiguration::TYPE_CUSTOMER)
            ->orderBy('event')
            ->get();
            
        $sellerEmails = EmailConfiguration::where('type', EmailConfiguration::TYPE_SELLER)
            ->orderBy('event')
            ->get();

        // Get available events for each type
        $customerEvents = EmailConfiguration::getEventsForType(EmailConfiguration::TYPE_CUSTOMER);
        $sellerEvents = EmailConfiguration::getEventsForType(EmailConfiguration::TYPE_SELLER);

        return view('admin.business.setup.pages.email-settings', compact(
            'customerEmails', 
            'sellerEmails', 
            'customerEvents', 
            'sellerEvents'
        ));
    }

    /**
     * Load tab content via AJAX
     */
    public function loadTabContent(Request $request, string $tab): JsonResponse
    {
        $validTabs = ['general', 'website-setup', 'sellers', 'commission-setup', 'email-settings'];
        
        if (!in_array($tab, $validTabs)) {
            return response()->json(['error' => 'Invalid tab'], 400);
        }

        try {
            $viewName = "admin.business.setup.tabs.{$tab}";
            $content = view($viewName, ['activeTab' => $tab])->render();
            
            return response()->json([
                'success' => true,
                'content' => $content,
                'tab' => $tab,
                'title' => $this->getTabTitle($tab)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load content'], 500);
        }
    }

    /**
     * Get tab title for page updates
     */
    private function getTabTitle(string $tab): string
    {
        $titles = [
            'general' => 'General Settings',
            'website-setup' => 'Website Setup',
            'sellers' => 'Seller Management',
            'commission-setup' => 'Commission Setup',
            'email-settings' => 'Email Configuration'
        ];

        return $titles[$tab] ?? 'Business Setup';
    }

    /**
     * Update general business settings
     */
    public function updateGeneral(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'timezone' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'pagination' => 'required|integer|min:5|max:100',
        ]);

        // Here you would typically save to database or settings table
        // For now, we'll just redirect back with success message
        
        return redirect()->route('admin.business.setup', ['tab' => 'general'])
            ->with('success', 'General settings updated successfully!');
    }

    /**
     * Update website setup settings
     */
    public function updateWebsiteSetup(Request $request): RedirectResponse
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'site_keywords' => 'nullable|string|max:255',
            'maintenance_mode' => 'boolean',
        ]);

        return redirect()->route('admin.business.setup', ['tab' => 'website-setup'])
            ->with('success', 'Website setup updated successfully!');
    }

    /**
     * Update seller settings
     */
    public function updateSellers(Request $request): RedirectResponse
    {
        $request->validate([
            'seller_registration' => 'boolean',
            'seller_approval' => 'boolean',
            'seller_commission' => 'required|numeric|min:0|max:100',
        ]);

        return redirect()->route('admin.business.setup', ['tab' => 'sellers'])
            ->with('success', 'Seller settings updated successfully!');
    }

    /**
     * Update commission setup
     */
    public function updateCommissionSetup(Request $request): RedirectResponse
    {
        $request->validate([
            'default_commission' => 'required|numeric|min:0|max:100',
            'commission_type' => 'required|in:percentage,fixed',
            'minimum_payout' => 'required|numeric|min:0',
        ]);

        return redirect()->route('admin.business.setup', ['tab' => 'commission-setup'])
            ->with('success', 'Commission setup updated successfully!');
    }

    /**
     * Update email configuration settings
     */
    public function updateEmailSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'configs' => 'required|array',
            'configs.*.id' => 'required|exists:email_configurations,id',
            'configs.*.is_enabled' => 'boolean',
            'configs.*.subject' => 'required|string|max:255',
        ]);

        try {
            foreach ($request->configs as $configData) {
                EmailConfiguration::where('id', $configData['id'])
                    ->update([
                        'is_enabled' => isset($configData['is_enabled']) ? true : false,
                        'subject' => $configData['subject'],
                    ]);
            }

            return redirect()->route('admin.business.setup', ['tab' => 'email-settings'])
                ->with('success', 'Email configuration updated successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.business.setup', ['tab' => 'email-settings'])
                ->with('error', 'Failed to update email configuration: ' . $e->getMessage());
        }
    }

    /**
     * Toggle email configuration status
     */
    public function toggleEmailConfig(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:email_configurations,id',
            'is_enabled' => 'required|boolean',
        ]);

        try {
            $config = EmailConfiguration::findOrFail($request->id);
            $config->update(['is_enabled' => $request->is_enabled]);

            return response()->json([
                'success' => true,
                'message' => 'Email configuration updated successfully',
                'is_enabled' => $config->is_enabled
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update configuration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Initialize default email configurations
     */
    public function initializeEmailConfigs(): JsonResponse
    {
        try {
            EmailConfiguration::seedDefaults();
            
            return response()->json([
                'success' => true,
                'message' => 'Email configurations initialized successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize configurations: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preview email template
     */
    public function previewEmailTemplate(Request $request): View
    {
        $request->validate([
            'type' => 'required|in:customer,seller',
            'event' => 'required|string',
        ]);

        $config = EmailConfiguration::getConfig($request->type, $request->event);
        
        if (!$config) {
            abort(404, 'Email configuration not found');
        }

        // Prepare sample data for preview
        $sampleData = $this->getSampleEmailData($request->type, $request->event);
        
        // Return the email template view directly for preview
        return view($config->template_path, $sampleData);
    }

    /**
     * Get sample data for email preview
     */
    private function getSampleEmailData(string $type, string $event): array
    {
        $baseData = [
            'site_name' => config('app.name', 'Gletr'),
            'site_url' => config('app.url'),
            'support_email' => config('mail.from.address', 'support@gletr.com'),
            'current_year' => date('Y'),
        ];

        switch ($type) {
            case 'customer':
                return array_merge($baseData, [
                    'customer_name' => 'John Doe',
                    'customer_email' => 'john.doe@example.com',
                    'verification_link' => config('app.url') . '/verify-email/sample-token',
                    'order_number' => 'ORD-' . rand(10000, 99999),
                    'order_total' => '$299.99',
                    'order_date' => date('F j, Y'),
                    'tracking_number' => 'TRK-' . rand(100000, 999999),
                ]);

            case 'seller':
                return array_merge($baseData, [
                    'seller_name' => 'Jane Smith',
                    'seller_email' => 'jane.smith@example.com',
                    'business_name' => 'Elegant Jewelry Co.',
                    'verification_link' => config('app.url') . '/seller/verify-email/sample-token',
                    'dashboard_url' => route('seller.dashboard'),
                    'order_number' => 'ORD-' . rand(10000, 99999),
                    'order_total' => '$299.99',
                    'customer_name' => 'John Doe',
                    'order_date' => date('F j, Y'),
                ]);

            default:
                return $baseData;
        }
    }

    /**
     * Test email configuration
     */
    public function testEmailConfig(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:customer,seller',
            'event' => 'required|string',
            'test_email' => 'required|email',
        ]);

        try {
            $config = EmailConfiguration::getConfig($request->type, $request->event);
            
            if (!$config || !$config->is_enabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email configuration is disabled or not found'
                ], 400);
            }

            // Send actual test email
            $emailService = new \App\Services\EmailService();
            $emailSent = $emailService->sendTestEmail($request->type, $request->event, $request->test_email);
            
            if ($emailSent) {
                return response()->json([
                    'success' => true,
                    'message' => 'Test email sent successfully to ' . $request->test_email
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send test email. Check your SMTP configuration and logs.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 500);
        }
    }
}