<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */
    'name' => env('APP_NAME', 'Gletr'),

    /*
    |--------------------------------------------------------------------------
    | Jewelry Marketplace Settings
    |--------------------------------------------------------------------------
    */
    'jewelry' => [
        'metal_types' => [
            'gold' => 'Gold',
            'silver' => 'Silver',
            'platinum' => 'Platinum',
            'diamond' => 'Diamond',
        ],

        'purities' => [
            'gold' => ['24k', '22k', '18k', '14k', '10k'],
            'silver' => ['925', '999'],
            'platinum' => ['950', '900'],
        ],

        'size_units' => [
            'ring' => 'US Size',
            'bangle' => 'Inches',
            'chain' => 'Inches',
            'earring' => 'MM',
        ],

        'weight_units' => [
            'gram' => 'Grams',
            'carat' => 'Carats',
            'ounce' => 'Ounces',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Settings
    |--------------------------------------------------------------------------
    */
    'orders' => [
        'statuses' => [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
        ],

        'payment_statuses' => [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
        ],

        'cancellation_reasons' => [
            'customer_request' => 'Customer Request',
            'payment_failed' => 'Payment Failed',
            'stock_unavailable' => 'Stock Unavailable',
            'seller_unable_fulfill' => 'Seller Unable to Fulfill',
            'quality_issues' => 'Quality Issues',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Seller Settings
    |--------------------------------------------------------------------------
    */
    'sellers' => [
        'statuses' => [
            'pending' => 'Pending Approval',
            'approved' => 'Approved',
            'suspended' => 'Suspended',
            'rejected' => 'Rejected',
        ],

        'kyc_documents' => [
            'pan' => 'PAN Card',
            'gstin' => 'GSTIN Certificate',
            'bank_statement' => 'Bank Statement',
            'hallmark_certificate' => 'Hallmark Certificate',
            'shop_license' => 'Shop License',
            'address_proof' => 'Address Proof',
        ],

        'commission_rates' => [
            'default' => 5.0, // 5%
            'gold' => 3.0,     // 3% for gold
            'diamond' => 7.0,  // 7% for diamond
            'silver' => 4.0,   // 4% for silver
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Product Settings
    |--------------------------------------------------------------------------
    */
    'products' => [
        'statuses' => [
            'draft' => 'Draft',
            'pending' => 'Pending Approval',
            'live' => 'Live',
            'rejected' => 'Rejected',
            'discontinued' => 'Discontinued',
        ],

        'making_charge_types' => [
            'fixed' => 'Fixed Amount',
            'per_gram' => 'Per Gram',
            'percentage' => 'Percentage of Metal Value',
        ],

        'image_requirements' => [
            'min_images' => 3,
            'max_images' => 10,
            'max_size' => 5 * 1024 * 1024, // 5MB
            'allowed_types' => ['jpeg', 'jpg', 'png', 'webp'],
            'dimensions' => [
                'min_width' => 800,
                'min_height' => 800,
                'recommended_width' => 1200,
                'recommended_height' => 1200,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */
    'payments' => [
        'gateways' => [
            'razorpay' => [
                'enabled' => env('RAZORPAY_ENABLED', true),
                'key_id' => env('RAZORPAY_KEY_ID'),
                'key_secret' => env('RAZORPAY_KEY_SECRET'),
            ],
            'cashfree' => [
                'enabled' => env('CASHFREE_ENABLED', false),
                'app_id' => env('CASHFREE_APP_ID'),
                'secret_key' => env('CASHFREE_SECRET_KEY'),
            ],
        ],

        'methods' => [
            'card' => 'Credit/Debit Card',
            'upi' => 'UPI',
            'netbanking' => 'Net Banking',
            'wallet' => 'Wallet',
            'cod' => 'Cash on Delivery',
        ],

        'cod' => [
            'enabled' => true,
            'max_amount' => 50000, // ₹50,000
            'min_amount' => 100,   // ₹100
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Shipping Settings
    |--------------------------------------------------------------------------
    */
    'shipping' => [
        'providers' => [
            'clickpost' => [
                'enabled' => env('CLICKPOST_ENABLED', true),
                'api_key' => env('CLICKPOST_API_KEY'),
                'base_url' => env('CLICKPOST_BASE_URL', 'https://www.clickpost.in/api/v3/'),
            ],
            'jewelxpress' => [
                'enabled' => env('JEWELXPRESS_ENABLED', true),
                'api_key' => env('JEWELXPRESS_API_KEY'),
                'base_url' => env('JEWELXPRESS_BASE_URL'),
            ],
        ],

        'value_thresholds' => [
            'low_value' => 5000,     // ₹5,000
            'medium_value' => 25000, // ₹25,000
            'high_value' => 100000,  // ₹1,00,000
        ],

        'insurance_rates' => [
            'standard' => 0.5,   // 0.5%
            'express' => 0.75,   // 0.75%
            'premium' => 1.0,    // 1.0%
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Settings
    |--------------------------------------------------------------------------
    */
    'tax' => [
        'gst_rates' => [
            'jewelry' => 3.0,      // 3% GST
            'gold' => 3.0,         // 3% GST
            'silver' => 3.0,       // 3% GST
            'diamond' => 0.25,     // 0.25% GST
        ],

        'hsn_codes' => [
            'gold_jewelry' => '7113',
            'silver_jewelry' => '7113',
            'diamond_jewelry' => '7113',
            'imitation_jewelry' => '7117',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Settings
    |--------------------------------------------------------------------------
    */
    'storage' => [
        'default_driver' => env('STORAGE_DRIVER', 'local'),
        'aws_s3' => [
            'region' => env('AWS_DEFAULT_REGION', 'ap-south-1'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],
        'cdn' => [
            'enabled' => env('CDN_ENABLED', false),
            'url' => env('CDN_URL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Business Rules
    |--------------------------------------------------------------------------
    */
    'business' => [
        'return_policy' => [
            'default_days' => 7,
            'high_value_days' => 3, // For items > ₹1,00,000
            'custom_made_returnable' => false,
        ],

        'inventory' => [
            'low_stock_threshold' => 5,
            'auto_disable_out_of_stock' => true,
        ],

        'pricing' => [
            'metal_rate_cache_duration' => 3600, // 1 hour
            'price_change_notification' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    */
    'currency' => [
        'code' => 'INR',
        'symbol' => '₹',
        'name' => 'Indian Rupee',
        'decimal_places' => 2,
        'thousands_separator' => ',',
        'decimal_separator' => '.',
        'symbol_position' => 'before', // before or after
    ],

    /*
    |--------------------------------------------------------------------------
    | Localization Settings
    |--------------------------------------------------------------------------
    */
    'locale' => [
        'timezone' => 'Asia/Kolkata',
        'date_format' => 'd/m/Y',
        'time_format' => 'h:i A',
        'datetime_format' => 'd/m/Y h:i A',
        'currency_locale' => 'en_IN',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Settings
    |--------------------------------------------------------------------------
    */
    'admin' => [
        'pagination' => [
            'per_page' => 25,
            'max_per_page' => 100,
        ],

        'dashboard' => [
            'refresh_interval' => 300, // 5 minutes
        ],

        'bulk_operations' => [
            'max_items' => 1000,
            'chunk_size' => 100,
        ],
    ],
];
