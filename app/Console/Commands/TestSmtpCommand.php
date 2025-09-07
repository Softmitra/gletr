<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestSmtpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:smtp {email : The email address to send test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test SMTP configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Testing SMTP configuration...");
        $this->info("Sending test email to: {$email}");
        
        try {
            $testData = [
                'site_name' => config('app.name', 'Gletr'),
                'site_url' => config('app.url'),
                'support_email' => config('mail.from.address'),
                'type' => 'SMTP Test',
                'event' => 'Configuration Test',
                'customer_name' => 'Test User',
            ];

            Mail::to($email)->send(new TestEmail($testData));
            
            $this->info("✅ Test email sent successfully!");
            $this->info("Check your inbox at: {$email}");
            
            // Show current mail configuration
            $this->info("\n📧 Current Mail Configuration:");
            $this->info("Driver: " . config('mail.default'));
            $this->info("Host: " . config('mail.mailers.smtp.host'));
            $this->info("Port: " . config('mail.mailers.smtp.port'));
            $this->info("Username: " . config('mail.mailers.smtp.username'));
            $this->info("Encryption: " . config('mail.mailers.smtp.encryption', 'none'));
            $this->info("From Address: " . config('mail.from.address'));
            $this->info("From Name: " . config('mail.from.name'));
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email!");
            $this->error("Error: " . $e->getMessage());
            
            $this->warn("\n🔍 Troubleshooting Tips:");
            $this->warn("1. Check your .env file for correct SMTP settings");
            $this->warn("2. Verify SMTP credentials are correct");
            $this->warn("3. Check if Gmail requires App Password (not regular password)");
            $this->warn("4. Ensure firewall allows SMTP connections");
            $this->warn("5. Check storage/logs/laravel.log for detailed errors");
            
            return 1;
        }
        
        return 0;
    }
}