<?php

namespace App\Services;

use App\Models\EmailConfiguration;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send email based on configuration
     */
    public function sendConfiguredEmail(string $type, string $event, string $toEmail, array $data = []): bool
    {
        try {
            $config = EmailConfiguration::getConfig($type, $event);
            
            if (!$config || !$config->is_enabled) {
                Log::info("Email not sent - configuration disabled", [
                    'type' => $type,
                    'event' => $event,
                    'to' => $toEmail
                ]);
                return false;
            }

            // Prepare email data
            $emailData = $this->prepareEmailData($config, $data);
            
            // Send email
            Mail::send($config->template_path, $emailData, function ($message) use ($toEmail, $config, $emailData) {
                $message->to($toEmail)
                        ->subject($this->processSubject($config->subject, $emailData));
            });

            Log::info("Email sent successfully", [
                'type' => $type,
                'event' => $event,
                'to' => $toEmail,
                'subject' => $config->subject
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error("Failed to send email", [
                'type' => $type,
                'event' => $event,
                'to' => $toEmail,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send customer registration email
     */
    public function sendCustomerRegistrationEmail(string $email, array $data): bool
    {
        $defaultData = [
            'site_name' => config('app.name', 'Gletr'),
            'site_url' => config('app.url'),
            'support_email' => config('mail.support_address', 'support@gletr.com'),
            'current_year' => date('Y'),
        ];

        $emailData = array_merge($defaultData, $data);
        
        return $this->sendConfiguredEmail(
            EmailConfiguration::TYPE_CUSTOMER,
            EmailConfiguration::CUSTOMER_REGISTRATION,
            $email,
            $emailData
        );
    }

    /**
     * Send seller registration email
     */
    public function sendSellerRegistrationEmail(string $email, array $data): bool
    {
        $defaultData = [
            'site_name' => config('app.name', 'Gletr'),
            'site_url' => config('app.url'),
            'support_email' => config('mail.support_address', 'support@gletr.com'),
            'dashboard_url' => route('seller.dashboard'),
            'current_year' => date('Y'),
        ];

        $emailData = array_merge($defaultData, $data);
        
        return $this->sendConfiguredEmail(
            EmailConfiguration::TYPE_SELLER,
            EmailConfiguration::SELLER_REGISTRATION,
            $email,
            $emailData
        );
    }

    /**
     * Send order related emails
     */
    public function sendOrderEmail(string $type, string $event, string $email, array $orderData): bool
    {
        $defaultData = [
            'site_name' => config('app.name', 'Gletr'),
            'site_url' => config('app.url'),
            'support_email' => config('mail.support_address', 'support@gletr.com'),
            'current_year' => date('Y'),
        ];

        $emailData = array_merge($defaultData, $orderData);
        
        return $this->sendConfiguredEmail($type, $event, $email, $emailData);
    }

    /**
     * Prepare email data with default values
     */
    private function prepareEmailData(EmailConfiguration $config, array $data): array
    {
        $defaultData = [
            'site_name' => config('app.name', 'Gletr'),
            'site_url' => config('app.url'),
            'support_email' => config('mail.support_address', 'support@gletr.com'),
            'current_year' => date('Y'),
        ];

        return array_merge($defaultData, $data);
    }

    /**
     * Process email subject with variables
     */
    private function processSubject(string $subject, array $data): string
    {
        $processedSubject = $subject;
        
        foreach ($data as $key => $value) {
            $processedSubject = str_replace('{{' . $key . '}}', $value, $processedSubject);
        }
        
        return $processedSubject;
    }

    /**
     * Check if email is enabled for specific event
     */
    public function isEmailEnabled(string $type, string $event): bool
    {
        return EmailConfiguration::isEnabled($type, $event);
    }

    /**
     * Get all enabled email configurations
     */
    public function getEnabledConfigurations(): array
    {
        return EmailConfiguration::where('is_enabled', true)
            ->get()
            ->groupBy('type')
            ->toArray();
    }

    /**
     * Send test email
     */
    public function sendTestEmail(string $type, string $event, string $toEmail): bool
    {
        try {
            $config = EmailConfiguration::getConfig($type, $event);
            
            if (!$config || !$config->is_enabled) {
                Log::warning("Test email not sent - configuration disabled", [
                    'type' => $type,
                    'event' => $event,
                    'to' => $toEmail
                ]);
                return false;
            }

            // Prepare test email data
            $testData = [
                'type' => $type,
                'event' => $event,
                'site_name' => config('app.name', 'Gletr'),
                'site_url' => config('app.url'),
                'support_email' => config('mail.from.address'),
                'customer_name' => 'Test Customer',
                'seller_name' => 'Test Seller',
                'business_name' => 'Test Business',
                'order_number' => 'TEST-' . rand(1000, 9999),
                'verification_link' => config('app.url') . '/verify-test',
                'current_year' => date('Y'),
                'subject' => $config->subject
            ];

            // Send test email using TestEmail mailable
            Mail::to($toEmail)->send(new TestEmail($testData));

            Log::info("Test email sent successfully", [
                'type' => $type,
                'event' => $event,
                'to' => $toEmail
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error("Failed to send test email", [
                'type' => $type,
                'event' => $event,
                'to' => $toEmail,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
