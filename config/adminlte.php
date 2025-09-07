<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Gletr Admin',
    'title_prefix' => '',
    'title_postfix' => ' - Jewelry Marketplace',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Gletr</b> Admin',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light elevation-1',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light elevation-1',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 0,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => true,
    'dashboard_url' => 'admin.dashboard',
    'logout_url' => 'logout',
    'login_url' => 'admin.login',
    'register_url' => 'register',
    'password_reset_url' => 'password.request',
    'password_email_url' => 'password.email',
    'profile_url' => false,
    'disable_darkmode_routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        
        // Quick Actions (Mobile Visible)
        [
            'text' => '',
            'url' => 'admin/products/create',
            'icon' => 'fas fa-plus',
            'topnav_right' => true,
            'classes' => 'd-sm-none',
            'title' => 'Add Product',
        ],
        [
            'text' => '',
            'url' => 'admin/orders',
            'icon' => 'fas fa-shopping-bag',
            'topnav_right' => true,
            'classes' => 'd-sm-none',
            'title' => 'Orders',
        ],

        // Sidebar items:
        // [
        //     'type' => 'sidebar-menu-search',
        //     'text' => 'Search Menu',
        //     'topnav_right' => false,
        // ],
        
        // Main Dashboard
        [
            'text' => 'Dashboard',
            'url' => 'admin/dashboard',
            'icon' => 'fas fa-fw fa-chart-pie',
            'classes' => 'nav-item-dashboard',
        ],
        
        ['header' => 'BUSINESS MANAGEMENT'],
        
        // Products Section
        [
            'text' => 'Products',
            'icon' => 'fas fa-fw fa-box-open',
            'classes' => 'nav-item-products',
            'submenu' => [
                [
                    'text' => 'All Products',
                    'url' => 'admin/products',
                    'icon' => 'fas fa-fw fa-th-large',
                ],
                [
                    'text' => 'Add Product',
                    'url' => 'admin/products/create',
                    'icon' => 'fas fa-fw fa-plus-circle',
                ],
                [
                    'text' => 'Categories',
                    'url' => 'admin/categories',
                    'icon' => 'fas fa-fw fa-layer-group',
                ],
                [
                    'text' => 'Product Reviews',
                    'url' => 'admin/reviews',
                    'icon' => 'fas fa-fw fa-star',
                ],
                [
                    'text' => 'Inventory',
                    'url' => 'admin/inventory',
                    'icon' => 'fas fa-fw fa-cubes',
                ],
            ],
        ],
        
        // Orders Section
        [
            'text' => 'Orders',
            'icon' => 'fas fa-fw fa-receipt',
            'classes' => 'nav-item-orders',
            'submenu' => [
                [
                    'text' => 'All Orders',
                    'url' => 'admin/orders',
                    'icon' => 'fas fa-fw fa-clipboard-list',
                ],
                [
                    'text' => 'Pending Orders',
                    'url' => 'admin/orders?status=pending',
                    'icon' => 'fas fa-fw fa-hourglass-half',
                    'label' => 'New',
                    'label_color' => 'warning',
                ],
                [
                    'text' => 'Processing',
                    'url' => 'admin/orders?status=processing',
                    'icon' => 'fas fa-fw fa-spinner',
                ],
                [
                    'text' => 'Shipped Orders',
                    'url' => 'admin/orders?status=shipped',
                    'icon' => 'fas fa-fw fa-truck',
                ],
                [
                    'text' => 'Completed Orders',
                    'url' => 'admin/orders?status=completed',
                    'icon' => 'fas fa-fw fa-check-double',
                ],
                [
                    'text' => 'Cancelled Orders',
                    'url' => 'admin/orders?status=cancelled',
                    'icon' => 'fas fa-fw fa-ban',
                ],
            ],
        ],
        
        // Customers Section
        [
            'text' => 'Customers',
            'icon' => 'fas fa-fw fa-user-friends',
            'classes' => 'nav-item-customers',
            'submenu' => [
                [
                    'text' => 'Customer List',
                    'url' => 'admin/customers',
                    'icon' => 'fas fa-fw fa-address-book',
                ],
                [
                    'text' => 'Customer Analytics',
                    'url' => 'admin/customers/analytics',
                    'icon' => 'fas fa-fw fa-chart-bar',
                ],
                [
                    'text' => 'Customer Reviews',
                    'url' => 'admin/customer-reviews',
                    'icon' => 'fas fa-fw fa-comment-dots',
                ],
                [
                    'text' => 'Customer Support',
                    'url' => 'admin/customer-support',
                    'icon' => 'fas fa-fw fa-life-ring',
                ],
            ],
        ],
        
        // Sellers Section
        [
            'text' => 'Sellers',
            'icon' => 'fas fa-fw fa-storefront',
            'classes' => 'nav-item-sellers',
            'submenu' => [
                [
                    'text' => 'Add New Seller',
                    'url' => 'admin/sellers/create',
                    'icon' => 'fas fa-fw fa-user-tie',
                ],
                [
                    'text' => 'Seller List',
                    'url' => 'admin/sellers',
                    'icon' => 'fas fa-fw fa-building',
                ],
                [
                    'text' => 'Seller Analytics',
                    'url' => 'admin/sellers/analytics',
                    'icon' => 'fas fa-fw fa-chart-line',
                ],
                [
                    'text' => 'Seller Verification',
                    'icon' => 'far fa-fw fa-check-circle',
                    'can' => 'view seller documents',
                    'submenu' => [
                        [
                            'text' => 'Verification Dashboard',
                            'url' => 'admin/seller-verification',
                            'icon' => 'fas fa-fw fa-tachometer-alt',
                            'can' => 'view seller documents',
                        ],
                        [
                            'text' => 'Pending Verification',
                            'url' => 'admin/seller-verification?verification_status=pending',
                            'icon' => 'fas fa-fw fa-clock',
                            'can' => 'view seller documents',
                        ],
                        [
                            'text' => 'Ready for Approval',
                            'url' => 'admin/seller-verification?verification_status=documents_verified',
                            'icon' => 'fas fa-fw fa-check-circle',
                            'can' => 'approve seller verification',
                        ],
                        [
                            'text' => 'Verified Sellers',
                            'url' => 'admin/seller-verification?verification_status=verified',
                            'icon' => 'fas fa-fw fa-user-shield',
                            'can' => 'view seller documents',
                        ],
                        [
                            'text' => 'Rejected Sellers',
                            'url' => 'admin/seller-verification?verification_status=rejected',
                            'icon' => 'fas fa-fw fa-times-circle',
                            'can' => 'view seller documents',
                        ],
                    ],
                ],
                [
                    'text' => 'Seller Sessions',
                    'icon' => 'fas fa-fw fa-desktop',
                    'can' => 'view seller sessions',
                    'submenu' => [
                        [
                            'text' => 'All Sessions',
                            'url' => 'admin/seller-sessions',
                            'icon' => 'fas fa-fw fa-list',
                            'can' => 'view seller sessions',
                        ],
                        [
                            'text' => 'Active Sessions',
                            'url' => 'admin/seller-sessions?status=active',
                            'icon' => 'fas fa-fw fa-circle text-success',
                            'can' => 'view seller sessions',
                        ],
                        [
                            'text' => 'Session Analytics',
                            'url' => 'admin/seller-sessions/analytics',
                            'icon' => 'fas fa-fw fa-chart-bar',
                            'can' => 'view seller sessions',
                        ],
                    ],
                ],
                [
                    'text' => 'Seller Activities',
                    'icon' => 'fas fa-fw fa-history',
                    'can' => 'view seller activities',
                    'submenu' => [
                        [
                            'text' => 'All Activities',
                            'url' => 'admin/seller-activities',
                            'icon' => 'fas fa-fw fa-clipboard-list',
                            'can' => 'view seller activities',
                        ],
                        [
                            'text' => 'Login Activities',
                            'url' => 'admin/seller-activities?type=login',
                            'icon' => 'fas fa-fw fa-sign-in-alt',
                            'can' => 'view seller activities',
                        ],
                        [
                            'text' => 'Product Activities',
                            'url' => 'admin/seller-activities?type=product',
                            'icon' => 'fas fa-fw fa-box',
                            'can' => 'view seller activities',
                        ],
                        [
                            'text' => 'Order Activities',
                            'url' => 'admin/seller-activities?type=order',
                            'icon' => 'fas fa-fw fa-shopping-cart',
                            'can' => 'view seller activities',
                        ],
                        [
                            'text' => 'Activity Analytics',
                            'url' => 'admin/seller-activities/analytics',
                            'icon' => 'fas fa-fw fa-chart-line',
                            'can' => 'view seller activities',
                        ],
                    ],
                ],
            ],
        ],
        
        // Payments & Finance
        [
            'text' => 'Payments & Finance',
            'icon' => 'fas fa-fw fa-coins',
            'classes' => 'nav-item-payments',
            'submenu' => [
                [
                    'text' => 'All Payments',
                    'url' => 'admin/payments',
                    'icon' => 'fas fa-fw fa-money-check-alt',
                ],
                [
                    'text' => 'Payment Methods',
                    'url' => 'admin/payment-methods',
                    'icon' => 'fas fa-fw fa-credit-card',
                ],
                [
                    'text' => 'Transactions',
                    'url' => 'admin/transactions',
                    'icon' => 'fas fa-fw fa-exchange-alt',
                ],
                [
                    'text' => 'Refunds',
                    'url' => 'admin/refunds',
                    'icon' => 'fas fa-fw fa-hand-holding-usd',
                ],
                [
                    'text' => 'Financial Reports',
                    'url' => 'admin/financial-reports',
                    'icon' => 'fas fa-fw fa-file-invoice-dollar',
                ],
            ],
        ],
        
        ['header' => 'BUSINESS SETTINGS'],
        
        // Business Settings
        [
            'text' => 'Business Settings',
            'icon' => 'fas fa-fw fa-briefcase',
            'classes' => 'nav-item-business-settings',
            'submenu' => [
                [
                    'text' => 'Business Setup',
                    'url' => 'admin/business/setup',
                    'icon' => 'fas fa-fw fa-tools',
                ],
                [
                    'text' => 'SEO Setting',
                    'url' => 'admin/business/seo',
                    'icon' => 'fas fa-fw fa-search-plus',
                ],
                [
                    'text' => 'Priority Setup',
                    'url' => 'admin/business/priority',
                    'icon' => 'fas fa-fw fa-sort-amount-up',
                ],
                [
                    'text' => 'Email Configuration',
                    'url' => 'admin/business/setup/email-settings',
                    'icon' => 'fas fa-fw fa-envelope-open-text',
                ],
                [
                    'text' => 'Pages and Media',
                    'icon' => 'fas fa-fw fa-file-image',
                    'submenu' => [
                        [
                            'text' => 'Business Pages',
                            'url' => 'admin/business/pages',
                            'icon' => 'fas fa-fw fa-file-alt',
                        ],
                        [
                            'text' => 'Social Media Links',
                            'url' => 'admin/business/social-media',
                            'icon' => 'fas fa-fw fa-share-alt',
                        ],
                        [
                            'text' => 'Seller Registration',
                            'url' => 'admin/business/seller-registration',
                            'icon' => 'fas fa-fw fa-user-plus',
                        ],
                    ],
                ],
            ],
        ],
        
        ['header' => 'SYSTEM MANAGEMENT'],
        
        // System Logs
        [
            'text' => 'System Logs',
            'url' => 'admin/logs',
            'icon' => 'fas fa-fw fa-clipboard-check',
            'classes' => 'nav-item-logs',
        ],
        
        // User Management
        [
            'text' => 'User Management',
            'icon' => 'fas fa-fw fa-user-cog',
            'classes' => 'nav-item-users',
            'submenu' => [
                [
                    'text' => 'All Users',
                    'url' => 'admin/users',
                    'icon' => 'fas fa-fw fa-users',
                ],
                [
                    'text' => 'User Sessions',
                    'url' => 'admin/users/sessions',
                    'icon' => 'fas fa-fw fa-tv',
                ],
                [
                    'text' => 'User Activities',
                    'url' => 'admin/users/activities',
                    'icon' => 'fas fa-fw fa-clock',
                ],
                [
                    'text' => 'User Profiles',
                    'url' => 'admin/user-profiles',
                    'icon' => 'fas fa-fw fa-id-card',
                ],
            ],
        ],
        
        // Security & Permissions
        [
            'text' => 'Security & Access',
            'icon' => 'fas fa-fw fa-shield-halved',
            'classes' => 'nav-item-security',
            'submenu' => [
                [
                    'text' => 'Roles & Permissions',
                    'url' => 'admin/roles',
                    'icon' => 'fas fa-fw fa-user-lock',
                ],
                [
                    'text' => 'Access Control',
                    'url' => 'admin/access-control',
                    'icon' => 'fas fa-fw fa-key',
                ],
                [
                    'text' => 'Security Logs',
                    'url' => 'admin/security-logs',
                    'icon' => 'fas fa-fw fa-eye',
                ],
            ],
        ],
        
        // Analytics & Reports
        [
            'text' => 'Analytics & Reports',
            'icon' => 'fas fa-fw fa-chart-area',
            'classes' => 'nav-item-analytics',
            'submenu' => [
                [
                    'text' => 'Sales Analytics',
                    'url' => 'admin/analytics/sales',
                    'icon' => 'fas fa-fw fa-chart-line',
                ],
                [
                    'text' => 'Customer Analytics',
                    'url' => 'admin/analytics/customers',
                    'icon' => 'fas fa-fw fa-users',
                ],
                [
                    'text' => 'Product Analytics',
                    'url' => 'admin/analytics/products',
                    'icon' => 'fas fa-fw fa-box',
                ],
                [
                    'text' => 'Traffic Analytics',
                    'url' => 'admin/analytics/traffic',
                    'icon' => 'fas fa-fw fa-globe',
                ],
                [
                    'text' => 'Custom Reports',
                    'url' => 'admin/reports/custom',
                    'icon' => 'fas fa-fw fa-file-contract',
                ],
            ],
        ],
        
        // System Settings
        [
            'text' => 'System Settings',
            'icon' => 'fas fa-fw fa-cog',
            'classes' => 'nav-item-settings',
            'submenu' => [
                [
                    'text' => 'General Settings',
                    'url' => 'admin/settings',
                    'icon' => 'fas fa-fw fa-sliders-h',
                ],
                [
                    'text' => 'File Storage',
                    'url' => 'admin/settings/file-storage',
                    'icon' => 'fas fa-fw fa-database',
                ],
                [
                    'text' => 'Email Settings',
                    'url' => 'admin/settings/email',
                    'icon' => 'fas fa-fw fa-envelope',
                ],
                [
                    'text' => 'Notification Settings',
                    'url' => 'admin/settings/notifications',
                    'icon' => 'fas fa-fw fa-bell',
                ],
                [
                    'text' => 'Backup & Restore',
                    'url' => 'admin/backup',
                    'icon' => 'fas fa-fw fa-cloud-download-alt',
                ],
            ],
        ],
        
        ['header' => 'ACCOUNT & PROFILE'],
        
        // Profile Management
        [
            'text' => 'My Profile',
            'url' => 'admin/profile',
            'icon' => 'fas fa-fw fa-user',
            'classes' => 'nav-item-profile',
        ],
        
        // Account Security
        [
            'text' => 'Account Security',
            'url' => 'admin/security',
            'icon' => 'fas fa-fw fa-lock',
            'classes' => 'nav-item-account-security',
        ],
        
        // Preferences
        [
            'text' => 'Preferences',
            'url' => 'admin/preferences',
            'icon' => 'fas fa-fw fa-palette',
            'classes' => 'nav-item-preferences',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'AdminSidebar' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/admin-sidebar.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/admin-sidebar.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
