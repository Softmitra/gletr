<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Gletr Jewellery Marketplace',
                'type' => 'string',
                'group' => 'general',
                'description' => 'The name of the website'
            ],
            [
                'key' => 'site_description',
                'value' => 'Premium jewellery marketplace connecting buyers with verified sellers',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Site description for SEO'
            ],
            [
                'key' => 'site_keywords',
                'value' => 'jewellery, jewelry, marketplace, gold, silver, diamonds, rings, necklaces',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Site keywords for SEO'
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@gletr.com',
                'type' => 'email',
                'group' => 'general',
                'description' => 'Main contact email address'
            ],
            [
                'key' => 'support_email',
                'value' => 'support@gletr.com',
                'type' => 'email',
                'group' => 'general',
                'description' => 'Support email address'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1-800-GLETR-01',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Main contact phone number'
            ],

            // Currency & Pricing
            [
                'key' => 'default_currency',
                'value' => 'USD',
                'type' => 'string',
                'group' => 'currency',
                'description' => 'Default currency code'
            ],
            [
                'key' => 'currency_symbol',
                'value' => '$',
                'type' => 'string',
                'group' => 'currency',
                'description' => 'Currency symbol'
            ],
            [
                'key' => 'tax_rate',
                'value' => '8.5',
                'type' => 'decimal',
                'group' => 'pricing',
                'description' => 'Default tax rate percentage'
            ],
            [
                'key' => 'commission_rate',
                'value' => '5.0',
                'type' => 'decimal',
                'group' => 'pricing',
                'description' => 'Default seller commission rate percentage'
            ],

            // Shipping
            [
                'key' => 'free_shipping_threshold',
                'value' => '100.00',
                'type' => 'decimal',
                'group' => 'shipping',
                'description' => 'Minimum order amount for free shipping'
            ],
            [
                'key' => 'standard_shipping_cost',
                'value' => '9.99',
                'type' => 'decimal',
                'group' => 'shipping',
                'description' => 'Standard shipping cost'
            ],
            [
                'key' => 'express_shipping_cost',
                'value' => '19.99',
                'type' => 'decimal',
                'group' => 'shipping',
                'description' => 'Express shipping cost'
            ],

            // Features
            [
                'key' => 'enable_reviews',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'features',
                'description' => 'Enable product reviews'
            ],
            [
                'key' => 'enable_wishlist',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'features',
                'description' => 'Enable wishlist functionality'
            ],
            [
                'key' => 'enable_multi_vendor',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'features',
                'description' => 'Enable multi-vendor marketplace'
            ],
            [
                'key' => 'require_seller_approval',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'features',
                'description' => 'Require admin approval for new sellers'
            ],

            // Email Settings
            [
                'key' => 'order_confirmation_email',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'email',
                'description' => 'Send order confirmation emails'
            ],
            [
                'key' => 'shipping_notification_email',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'email',
                'description' => 'Send shipping notification emails'
            ],
            [
                'key' => 'newsletter_signup',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'email',
                'description' => 'Enable newsletter signup'
            ],

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/gletr',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Facebook page URL'
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/gletr',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Instagram profile URL'
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/gletr',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Twitter profile URL'
            ],

            // Analytics
            [
                'key' => 'google_analytics_id',
                'value' => '',
                'type' => 'string',
                'group' => 'analytics',
                'description' => 'Google Analytics tracking ID'
            ],
            [
                'key' => 'facebook_pixel_id',
                'value' => '',
                'type' => 'string',
                'group' => 'analytics',
                'description' => 'Facebook Pixel ID'
            ],

            // Maintenance
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'maintenance',
                'description' => 'Enable maintenance mode'
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'We are currently performing scheduled maintenance. Please check back soon.',
                'type' => 'text',
                'group' => 'maintenance',
                'description' => 'Maintenance mode message'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
