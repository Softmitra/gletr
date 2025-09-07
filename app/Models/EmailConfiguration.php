<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'event',
        'is_enabled',
        'subject',
        'template_path',
        'variables',
        'description',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'variables' => 'array',
    ];

    // Email types
    const TYPE_CUSTOMER = 'customer';
    const TYPE_SELLER = 'seller';

    // Email events for customers
    const CUSTOMER_REGISTRATION = 'registration';
    const CUSTOMER_ORDER_PLACED = 'order_placed';
    const CUSTOMER_ORDER_CONFIRMED = 'order_confirmed';
    const CUSTOMER_ORDER_SHIPPED = 'order_shipped';
    const CUSTOMER_ORDER_DELIVERED = 'order_delivered';
    const CUSTOMER_ORDER_CANCELLED = 'order_cancelled';
    const CUSTOMER_PASSWORD_RESET = 'password_reset';
    const CUSTOMER_WELCOME = 'welcome';

    // Email events for sellers
    const SELLER_REGISTRATION = 'registration';
    const SELLER_VERIFICATION_APPROVED = 'verification_approved';
    const SELLER_VERIFICATION_REJECTED = 'verification_rejected';
    const SELLER_NEW_ORDER = 'new_order';
    const SELLER_ORDER_CANCELLED = 'order_cancelled';
    const SELLER_PAYMENT_RECEIVED = 'payment_received';
    const SELLER_PASSWORD_RESET = 'password_reset';
    const SELLER_WELCOME = 'welcome';

    /**
     * Get all available email types
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_CUSTOMER => 'Customer',
            self::TYPE_SELLER => 'Seller',
        ];
    }

    /**
     * Get all available events for a specific type
     */
    public static function getEventsForType(string $type): array
    {
        switch ($type) {
            case self::TYPE_CUSTOMER:
                return [
                    self::CUSTOMER_REGISTRATION => 'Registration',
                    self::CUSTOMER_ORDER_PLACED => 'Order Placed',
                    self::CUSTOMER_ORDER_CONFIRMED => 'Order Confirmed',
                    self::CUSTOMER_ORDER_SHIPPED => 'Order Shipped',
                    self::CUSTOMER_ORDER_DELIVERED => 'Order Delivered',
                    self::CUSTOMER_ORDER_CANCELLED => 'Order Cancelled',
                    self::CUSTOMER_PASSWORD_RESET => 'Password Reset',
                    self::CUSTOMER_WELCOME => 'Welcome Email',
                ];

            case self::TYPE_SELLER:
                return [
                    self::SELLER_REGISTRATION => 'Registration',
                    self::SELLER_VERIFICATION_APPROVED => 'Verification Approved',
                    self::SELLER_VERIFICATION_REJECTED => 'Verification Rejected',
                    self::SELLER_NEW_ORDER => 'New Order Received',
                    self::SELLER_ORDER_CANCELLED => 'Order Cancelled',
                    self::SELLER_PAYMENT_RECEIVED => 'Payment Received',
                    self::SELLER_PASSWORD_RESET => 'Password Reset',
                    self::SELLER_WELCOME => 'Welcome Email',
                ];

            default:
                return [];
        }
    }

    /**
     * Get default template variables for an event
     */
    public static function getDefaultVariables(string $type, string $event): array
    {
        $commonVars = [
            'site_name' => 'Website Name',
            'site_url' => 'Website URL',
            'support_email' => 'Support Email',
            'current_year' => 'Current Year',
        ];

        switch ($type) {
            case self::TYPE_CUSTOMER:
                $customerVars = [
                    'customer_name' => 'Customer Name',
                    'customer_email' => 'Customer Email',
                ];

                switch ($event) {
                    case self::CUSTOMER_REGISTRATION:
                        return array_merge($commonVars, $customerVars, [
                            'verification_link' => 'Email Verification Link',
                        ]);

                    case self::CUSTOMER_ORDER_PLACED:
                    case self::CUSTOMER_ORDER_CONFIRMED:
                    case self::CUSTOMER_ORDER_SHIPPED:
                    case self::CUSTOMER_ORDER_DELIVERED:
                    case self::CUSTOMER_ORDER_CANCELLED:
                        return array_merge($commonVars, $customerVars, [
                            'order_number' => 'Order Number',
                            'order_total' => 'Order Total',
                            'order_date' => 'Order Date',
                            'order_status' => 'Order Status',
                            'tracking_number' => 'Tracking Number',
                        ]);

                    default:
                        return array_merge($commonVars, $customerVars);
                }

            case self::TYPE_SELLER:
                $sellerVars = [
                    'seller_name' => 'Seller Name',
                    'seller_email' => 'Seller Email',
                    'business_name' => 'Business Name',
                ];

                switch ($event) {
                    case self::SELLER_REGISTRATION:
                        return array_merge($commonVars, $sellerVars, [
                            'verification_link' => 'Email Verification Link',
                            'dashboard_url' => 'Seller Dashboard URL',
                        ]);

                    case self::SELLER_NEW_ORDER:
                        return array_merge($commonVars, $sellerVars, [
                            'order_number' => 'Order Number',
                            'order_total' => 'Order Total',
                            'customer_name' => 'Customer Name',
                            'order_date' => 'Order Date',
                        ]);

                    default:
                        return array_merge($commonVars, $sellerVars);
                }

            default:
                return $commonVars;
        }
    }

    /**
     * Check if email is enabled for specific type and event
     */
    public static function isEnabled(string $type, string $event): bool
    {
        $config = self::where('type', $type)
            ->where('event', $event)
            ->first();

        return $config ? $config->is_enabled : false;
    }

    /**
     * Get configuration for specific type and event
     */
    public static function getConfig(string $type, string $event): ?self
    {
        return self::where('type', $type)
            ->where('event', $event)
            ->first();
    }

    /**
     * Seed default configurations
     */
    public static function seedDefaults(): void
    {
        $types = self::getTypes();

        foreach ($types as $typeKey => $typeName) {
            $events = self::getEventsForType($typeKey);

            foreach ($events as $eventKey => $eventName) {
                self::updateOrCreate([
                    'type' => $typeKey,
                    'event' => $eventKey,
                ], [
                    'is_enabled' => true,
                    'subject' => self::getDefaultSubject($typeKey, $eventKey),
                    'template_path' => "emails.{$typeKey}.{$eventKey}",
                    'variables' => self::getDefaultVariables($typeKey, $eventKey),
                    'description' => "Email sent to {$typeName} when {$eventName} occurs",
                ]);
            }
        }
    }

    /**
     * Get default subject for email
     */
    private static function getDefaultSubject(string $type, string $event): string
    {
        $subjects = [
            self::TYPE_CUSTOMER => [
                self::CUSTOMER_REGISTRATION => 'Welcome to {{site_name}} - Please verify your email',
                self::CUSTOMER_ORDER_PLACED => 'Order Confirmation - {{order_number}}',
                self::CUSTOMER_ORDER_CONFIRMED => 'Your order {{order_number}} has been confirmed',
                self::CUSTOMER_ORDER_SHIPPED => 'Your order {{order_number}} has been shipped',
                self::CUSTOMER_ORDER_DELIVERED => 'Your order {{order_number}} has been delivered',
                self::CUSTOMER_ORDER_CANCELLED => 'Your order {{order_number}} has been cancelled',
                self::CUSTOMER_PASSWORD_RESET => 'Reset your password',
                self::CUSTOMER_WELCOME => 'Welcome to {{site_name}}!',
            ],
            self::TYPE_SELLER => [
                self::SELLER_REGISTRATION => 'Welcome to {{site_name}} - Seller Registration Received',
                self::SELLER_VERIFICATION_APPROVED => 'Your seller account has been approved',
                self::SELLER_VERIFICATION_REJECTED => 'Your seller verification needs attention',
                self::SELLER_NEW_ORDER => 'New Order Received - {{order_number}}',
                self::SELLER_ORDER_CANCELLED => 'Order Cancelled - {{order_number}}',
                self::SELLER_PAYMENT_RECEIVED => 'Payment received for order {{order_number}}',
                self::SELLER_PASSWORD_RESET => 'Reset your seller account password',
                self::SELLER_WELCOME => 'Welcome to {{site_name}} Seller Portal!',
            ],
        ];

        return $subjects[$type][$event] ?? 'Notification from {{site_name}}';
    }
}