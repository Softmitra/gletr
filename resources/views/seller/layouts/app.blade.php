<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Seller Dashboard') - {{ config('app.name') }}</title>

    <!-- Google Fonts: Spline Sans & Noto Sans -->
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Spline+Sans%3Awght%40400%3B500%3B700" onload="this.rel='stylesheet'" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <!-- Font Awesome - Primary -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Font Awesome CDN Fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Font Awesome Webfont Preload -->
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-regular-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('css')
    
    <style>
        /* Global Font Family */
        * {
            font-family: "Spline Sans", "Noto Sans", sans-serif !important;
        }
        
        body, html {
            font-family: "Spline Sans", "Noto Sans", sans-serif !important;
        }
        
        /* Sidebar Styles */
        .main-sidebar {
            background: white !important;
            border-right: 1px solid #e3e6f0;
            transition: all 0.3s ease-in-out;
        }
        
        /* Hamburger Menu Icon */
        .navbar-nav .nav-link[data-widget="pushmenu"] {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .navbar-nav .nav-link[data-widget="pushmenu"]:hover {
            background-color: #f8f9fa !important;
        }
        
        .navbar-nav .nav-link[data-widget="pushmenu"] i {
            font-size: 18px !important;
            color: #495057 !important;
            font-weight: 900 !important;
        }
        
        /* Ensure FontAwesome is loaded */
        .navbar-nav .nav-link[data-widget="pushmenu"] i.fas.fa-bars:before {
            content: "\f0c9" !important;
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }
        
        /* Fallback hamburger icon */
        .hamburger-fallback {
            font-size: 18px !important;
            color: #495057 !important;
            font-weight: bold !important;
            line-height: 1 !important;
        }
        
        /* Show fallback if FontAwesome fails */
        .navbar-nav .nav-link[data-widget="pushmenu"] i:empty + .hamburger-fallback {
            display: inline-block !important;
        }
        
        /* Ensure FontAwesome icons are visible */
        .nav-icon {
            width: 1.2rem !important;
            text-align: center !important;
            font-size: 1rem !important;
            margin-right: 0.5rem !important;
        }
        
        /* Fix sidebar icons in collapsed state */
        body.sidebar-collapse .nav-sidebar .nav-icon {
            margin-right: 0 !important;
            width: 100% !important;
        }
        
        /* Emoji fallback icons */
        .emoji-icon {
            font-family: "Apple Color Emoji", "Segoe UI Emoji", "Noto Color Emoji", sans-serif !important;
            font-size: 1.1rem !important;
            line-height: 1 !important;
        }
        
        /* Menu expand/collapse arrows */
        .nav-sidebar .nav-link .right {
            transition: transform 0.3s ease-in-out;
        }
        
        .nav-sidebar .nav-item.menu-open > .nav-link .right {
            transform: rotate(180deg);
        }
        
        /* Submenu styling */
        .nav-treeview {
            padding-left: 1rem;
        }
        
        .nav-treeview .nav-link {
            padding-left: 2rem !important;
        }
        
        .nav-treeview .nav-icon {
            font-size: 0.9rem !important;
        }
        
        /* Fix AdminLTE Sidebar */
        .main-sidebar, .main-sidebar::before {
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }
        
        /* Sidebar Collapse State */
        body.sidebar-collapse .main-sidebar {
            margin-left: -250px !important;
        }
        
        @media (min-width: 768px) {
            body.sidebar-collapse .main-sidebar {
                margin-left: 0 !important;
            }
            
            body.sidebar-collapse .main-sidebar,
            body.sidebar-collapse .main-sidebar::before {
                width: 4.6rem !important;
            }
            
            body.sidebar-collapse .content-wrapper,
            body.sidebar-collapse .main-footer,
            body.sidebar-collapse .main-header {
                margin-left: 4.6rem !important;
            }
            
            body.sidebar-collapse .brand-link {
                width: 4.6rem !important;
            }
            
            body.sidebar-collapse .brand-text {
                display: none !important;
            }
            
            body.sidebar-collapse .sidebar .user-panel .info,
            body.sidebar-collapse .sidebar .nav-link p,
            body.sidebar-collapse .sidebar .brand-text {
                display: none !important;
                opacity: 0;
            }
            
            body.sidebar-collapse .sidebar .nav-link {
                text-align: center;
            }
            
            body.sidebar-collapse .sidebar .nav-icon {
                margin-right: 0 !important;
                text-align: center;
                width: 100%;
            }
            
            body.sidebar-collapse .seller-verification-status {
                display: none !important;
            }
            
            body.sidebar-collapse .verification-notice {
                display: none !important;
            }
            
            body.sidebar-collapse .nav-sidebar .nav-treeview {
                display: none !important;
            }
        }
        
        /* Mobile Optimization */
        @media (max-width: 767.98px) {
            /* Mobile Sidebar */
            .main-sidebar {
                margin-left: -250px !important;
                transition: margin-left 0.3s ease-in-out;
                z-index: 1050;
            }
            
            .sidebar-open .main-sidebar {
                margin-left: 0 !important;
            }
            
            /* Mobile Sidebar Overlay */
            .sidebar-open::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                transition: opacity 0.3s ease-in-out;
            }
            
            /* Mobile Content */
            .content-wrapper {
                margin-left: 0 !important;
            }
            
            .main-footer {
                margin-left: 0 !important;
            }
            
            /* Mobile Navbar */
            .main-header {
                margin-left: 0 !important;
            }
            
            /* Hide verification status on mobile */
            .seller-verification-status {
                font-size: 0.8rem;
                padding: 8px;
                margin: 8px;
            }
            
            .verification-notice {
                font-size: 0.7rem;
                padding: 8px;
            }
            
            /* Mobile Menu Items */
            .nav-sidebar .nav-link {
                padding: 0.75rem 1rem;
            }
            
            .nav-treeview .nav-link {
                padding-left: 2.5rem !important;
                font-size: 0.9rem;
            }
            
            /* Mobile Brand */
            .brand-link {
                padding: 0.8rem 1rem;
            }
            
            .brand-text {
                font-size: 1rem;
            }
            
            /* Mobile Navbar Icons */
            .navbar-nav .nav-link {
                padding: 0.5rem;
            }
            
            /* Mobile Dropdown */
            .dropdown-menu {
                font-size: 0.9rem;
            }
            
            /* Mobile Content Padding */
            .content-wrapper .content {
                padding: 1rem;
            }
            
            .content-header {
                padding: 1rem;
            }
        }
        
        /* Tablet Optimization */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .brand-text {
                font-size: 1.1rem;
            }
            
            .nav-sidebar .nav-link {
                font-size: 0.9rem;
            }
        }
        
        /* Mobile Touch Improvements */
        @media (hover: none) and (pointer: coarse) {
            .nav-sidebar .nav-link {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
            
            .dropdown-item {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
        }
        .nav-sidebar .nav-link {
            color: #6b7280 !important;
        }
        .nav-sidebar .nav-link:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        .nav-sidebar .nav-link.active {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        .brand-link {
            background-color: white !important;
            color: #111827 !important;
            border-bottom: 1px solid #e3e6f0;
        }
        .user-panel .info a {
            color: #111827 !important;
        }
        .user-panel .info small {
            color: #6b7280 !important;
        }
        .sidebar-dark-primary .nav-treeview > .nav-item > .nav-link {
            color: #6b7280 !important;
        }
        .sidebar-dark-primary .nav-treeview > .nav-item > .nav-link:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        .sidebar-dark-primary .nav-treeview > .nav-item > .nav-link.active {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        
        /* Additional white theme overrides */
        .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link {
            color: #6b7280 !important;
        }
        .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        .sidebar-light-primary .nav-treeview > .nav-item > .nav-link {
            color: #6b7280 !important;
        }
        .sidebar-light-primary .nav-treeview > .nav-item > .nav-link:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        .sidebar-light-primary .nav-treeview > .nav-item > .nav-link.active {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        
        /* Ensure icons are properly colored */
        .nav-sidebar .nav-icon {
            color: inherit !important;
        }
        
        /* Disabled menu items */
        .nav-link.disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }
        
        .nav-link.disabled:hover {
            background-color: transparent !important;
            color: #6b7280 !important;
        }
        
        .verification-notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 12px;
            margin: 16px;
            color: #92400e;
            font-size: 12px;
            text-align: center;
        }
        .seller-verification-status {
            margin: 10px 15px;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
        }
        .verification-pending {
            background-color: rgba(255, 193, 7, 0.2);
            border: 1px solid rgba(255, 193, 7, 0.5);
            color: #856404;
        }
        .verification-approved {
            background-color: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: #155724;
        }
        .verification-rejected {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #721c24;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" id="seller-body">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                    <!-- Fallback hamburger icon if FontAwesome fails -->
                    <span class="hamburger-fallback" style="display: none;">☰</span>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('seller.dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('seller.store.show') }}" class="nav-link">
                    <i class="fas fa-store mr-1"></i>My Store
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Quick Actions (Mobile Visible) -->
            <li class="nav-item d-sm-none">
                <a class="nav-link" href="{{ route('seller.products.create') }}" title="Add Product">
                    <i class="fas fa-plus"></i>
                </a>
            </li>
            <li class="nav-item d-sm-none">
                <a class="nav-link" href="{{ route('seller.orders.index') }}" title="Orders">
                    <i class="fas fa-shopping-bag"></i>
                </a>
            </li>
            
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" title="Notifications">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">
                        <i class="fas fa-bell mr-2"></i>0 Notifications
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">
                        <i class="fas fa-eye mr-2"></i>See All Notifications
                    </a>
                </div>
            </li>
            
            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                    <span class="d-none d-md-inline">{{ Auth::guard('seller')->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('seller.profile.show') }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('seller.settings.index') }}" class="dropdown-item">
                        <i class="fas fa-cogs mr-2"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('seller.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('seller.dashboard') }}" class="brand-link">
            <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name') }} Seller</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
           

            <!-- Verification Status -->
            @php $seller = Auth::guard('seller')->user(); @endphp
            <div class="seller-verification-status 
                @if($seller->isFullyVerified()) verification-approved
                @elseif($seller->isVerificationRejected()) verification-rejected
                @else verification-pending @endif">
                <div class="d-flex align-items-center">
                    <i class="fas 
                        @if($seller->isFullyVerified()) fa-check-circle
                        @elseif($seller->isVerificationRejected()) fa-times-circle
                        @else fa-clock @endif mr-2"></i>
                    <div>
                        <strong>
                            @if($seller->isFullyVerified()) Verified Seller
                            @elseif($seller->isVerificationRejected()) Verification Rejected
                            @else Verification Pending @endif
                        </strong>
                        @if(!$seller->isFullyVerified())
                            <br><a href="{{ route('seller.verification.status') }}" class="text-decoration-none">
                                <small>View Status</small>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ $seller->isFullyVerified() ? route('seller.dashboard') : '#' }}" 
                           class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                           @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Store Management -->
                    <li class="nav-item {{ request()->routeIs('seller.store.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('seller.store.*') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                           @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                My Store
                                @if($seller->isFullyVerified())<i class="fas fa-angle-down right"></i>@endif
                            </p>
                        </a>
                        @if($seller->isFullyVerified())
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('seller.store.show') }}" class="nav-link {{ request()->routeIs('seller.store.show') ? 'active' : '' }}">
                                    <i class="fas fa-eye nav-icon"></i>
                                    <p>Store Overview</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.store.edit') }}" class="nav-link {{ request()->routeIs('seller.store.edit') ? 'active' : '' }}">
                                    <i class="fas fa-edit nav-icon"></i>
                                    <p>Store Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.store.branding') }}" class="nav-link {{ request()->routeIs('seller.store.branding') ? 'active' : '' }}">
                                    <i class="fas fa-palette nav-icon"></i>
                                    <p>Branding</p>
                                </a>
                            </li>
                        </ul>
                        @endif
                    </li>

                    <!-- Product Management -->
                    <li class="nav-item {{ request()->routeIs('seller.products.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                           @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                            <i class="nav-icon fas fa-gem"></i>
                            <p>
                                Products
                                @if($seller->isFullyVerified())<i class="fas fa-angle-down right"></i>@endif
                            </p>
                        </a>
                        @if($seller->isFullyVerified())
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('seller.products.index') }}" class="nav-link {{ request()->routeIs('seller.products.index') ? 'active' : '' }}">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>All Products</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.products.create') }}" class="nav-link {{ request()->routeIs('seller.products.create') ? 'active' : '' }}">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Add Product</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.products.import') }}" class="nav-link {{ request()->routeIs('seller.products.import') ? 'active' : '' }}">
                                    <i class="fas fa-upload nav-icon"></i>
                                    <p>Import Products</p>
                                </a>
                            </li>
                        </ul>
                        @endif
                    </li>

                    <!-- Order Management -->
                    <li class="nav-item {{ request()->routeIs('seller.orders.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                           @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>
                                Orders
                                @if($seller->isFullyVerified())<i class="fas fa-angle-down right"></i>@endif
                            </p>
                        </a>
                        @if($seller->isFullyVerified())
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('seller.orders.index') }}" class="nav-link {{ request()->routeIs('seller.orders.index') ? 'active' : '' }}">
                                    <i class="fas fa-list-alt nav-icon"></i>
                                    <p>All Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}" class="nav-link">
                                    <i class="fas fa-clock nav-icon text-warning"></i>
                                    <p>Pending Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.orders.index', ['status' => 'processing']) }}" class="nav-link">
                                    <i class="fas fa-cog nav-icon text-info"></i>
                                    <p>Processing</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.orders.index', ['status' => 'shipped']) }}" class="nav-link">
                                    <i class="fas fa-shipping-fast nav-icon text-success"></i>
                                    <p>Shipped</p>
                                </a>
                            </li>
                        </ul>
                        @endif
                    </li>

                    <!-- Analytics -->
                    <li class="nav-item {{ request()->routeIs('seller.analytics.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('seller.analytics.*') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                           @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Analytics
                                @if($seller->isFullyVerified())<i class="fas fa-angle-down right"></i>@endif
                            </p>
                        </a>
                        @if($seller->isFullyVerified())
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->routeIs('seller.analytics.index') ? 'active' : '' }}">
                                    <i class="fas fa-chart-pie nav-icon"></i>
                                    <p>Overview</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->routeIs('seller.analytics.sales') ? 'active' : '' }}">
                                    <i class="fas fa-chart-line nav-icon"></i>
                                    <p>Sales Analytics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->routeIs('seller.analytics.products') ? 'active' : '' }}">
                                    <i class="fas fa-chart-area nav-icon"></i>
                                    <p>Product Performance</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link {{ request()->routeIs('seller.analytics.financial') ? 'active' : '' }}">
                                    <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                    <p>Financial Reports</p>
                                </a>
                            </li>
                        </ul>
                        @endif
                    </li>

                    <!-- Profile & Settings -->
                    <li class="nav-item {{ request()->routeIs('seller.profile.*', 'seller.settings.*', 'seller.verification.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('seller.profile.*', 'seller.settings.*', 'seller.verification.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                Account
                                <i class="fas fa-angle-down right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ $seller->isFullyVerified() ? route('seller.profile.show') : '#' }}" 
                                   class="nav-link {{ request()->routeIs('seller.profile.show') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                                   @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                                    <i class="fas fa-user nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seller.verification.status') }}" class="nav-link {{ request()->routeIs('seller.verification.*') ? 'active' : '' }}">
                                    <i class="fas fa-shield-alt nav-icon"></i>
                                    <p>Verification Status</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ $seller->isFullyVerified() ? route('seller.settings.index') : '#' }}" 
                                   class="nav-link {{ request()->routeIs('seller.settings.*') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                                   @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                                    <i class="fas fa-cogs nav-icon"></i>
                                    <p>Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ $seller->isFullyVerified() ? route('seller.sessions.index') : '#' }}" 
                                   class="nav-link {{ request()->routeIs('seller.sessions.*') ? 'active' : '' }} {{ !$seller->isFullyVerified() ? 'disabled' : '' }}"
                                   @if(!$seller->isFullyVerified()) onclick="showVerificationAlert(); return false;" @endif>
                                    <i class="fas fa-history nav-icon"></i>
                                    <p>Sessions</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            
            <!-- Verification Notice for Non-Verified Sellers -->
            @if(!$seller->isFullyVerified())
            <div class="verification-notice">
                <i class="fas fa-exclamation-triangle mb-2"></i><br>
                <strong>Complete Verification</strong><br>
                <small>Complete your verification to access all features</small>
            </div>
            @endif
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @yield('content_header')
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-check"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-ban"></i> {{ session('error') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-exclamation-triangle"></i> {{ session('warning') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-info"></i> {{ session('info') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>

<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

@yield('js')

<script>
// Ensure jQuery is loaded before executing
if (typeof jQuery === 'undefined') {
    console.error('jQuery is not loaded!');
} else {
    console.log('jQuery version:', jQuery.fn.jquery);
}

// Check AdminLTE
if (typeof $.fn.Layout === 'undefined' || typeof $.fn.PushMenu === 'undefined') {
    console.error('AdminLTE components not fully loaded!');
} else {
    console.log('AdminLTE loaded successfully');
}
</script>

<script>
$(document).ready(function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Restore sidebar state from localStorage
    if (localStorage.getItem('sidebar-collapse') === 'true') {
        $('body').addClass('sidebar-collapse');
    }
    
    // Override AdminLTE's pushmenu to add localStorage
    $(document).on('collapsed.lte.pushmenu shown.lte.pushmenu', function() {
        if ($('body').hasClass('sidebar-collapse')) {
            localStorage.setItem('sidebar-collapse', 'true');
        } else {
            localStorage.setItem('sidebar-collapse', 'false');
        }
    });
    
    // Mobile sidebar handling
    function isMobile() {
        return window.innerWidth <= 767;
    }
    
    // Handle mobile sidebar toggle
    if (isMobile()) {
        $('body').removeClass('sidebar-collapse').addClass('sidebar-closed');
        
        $('[data-widget="pushmenu"]').off('click').on('click', function(e) {
            e.preventDefault();
            if ($('body').hasClass('sidebar-open')) {
                $('body').removeClass('sidebar-open');
            } else {
                $('body').addClass('sidebar-open');
            }
        });
        
        // Close sidebar when clicking outside on mobile
        $(document).on('click', function(e) {
            if (isMobile() && $('body').hasClass('sidebar-open')) {
                if (!$(e.target).closest('.main-sidebar, [data-widget="pushmenu"]').length) {
                    $('body').removeClass('sidebar-open');
                }
            }
        });
    }
    
    // Handle window resize
    $(window).on('resize', function() {
        if (isMobile()) {
            $('body').removeClass('sidebar-collapse').addClass('sidebar-closed');
        } else {
            $('body').removeClass('sidebar-closed sidebar-open');
            // Restore desktop sidebar state
            if (localStorage.getItem('sidebar-collapse') === 'true') {
                $('body').addClass('sidebar-collapse');
            }
        }
    });
    
    // Ensure hamburger icon is visible and working
    var $hamburgerBtn = $('[data-widget="pushmenu"]');
    var $hamburgerIcon = $hamburgerBtn.find('i');
    
    // Make sure icon has correct classes
    if ($hamburgerIcon.length === 0) {
        $hamburgerBtn.html('<i class="fas fa-bars"></i>');
        $hamburgerIcon = $hamburgerBtn.find('i');
    }
    
    // Check if FontAwesome loaded
    setTimeout(function() {
        if ($hamburgerIcon.css('font-family').indexOf('Font Awesome') === -1) {
            console.log('FontAwesome not loaded, using fallback');
            $hamburgerBtn.html('<span style="font-size: 18px; font-weight: bold;">☰</span>');
        }
        
        // Check if FontAwesome is loaded by testing a known icon
        var testIcon = $('<i class="fas fa-home" style="position: absolute; left: -9999px;"></i>').appendTo('body');
        var isFontAwesomeLoaded = testIcon.css('font-family').indexOf('Font Awesome') !== -1;
        testIcon.remove();
        
        console.log('Seller FontAwesome loaded:', isFontAwesomeLoaded);
        
        // Only apply fallbacks if FontAwesome is NOT loaded
        if (!isFontAwesomeLoaded) {
            $('.nav-sidebar .nav-icon, .navbar-nav .nav-link i, .fas, .far, .fab, .fal, .fad, [class*="fa-"]').each(function() {
                var $icon = $(this);
                
                // Skip if already processed
                if ($icon.hasClass('emoji-icon') || $icon.data('processed')) {
                    return;
                }
                
                // Mark as processed
                $icon.data('processed', true);
                // Add fallback based on icon class
                if ($icon.hasClass('fa-tachometer-alt')) {
                    $icon.html('📊');
                } else if ($icon.hasClass('fa-store')) {
                    $icon.html('🏪');
                } else if ($icon.hasClass('fa-gem')) {
                    $icon.html('💎');
                } else if ($icon.hasClass('fa-shopping-bag')) {
                    $icon.html('🛍️');
                } else if ($icon.hasClass('fa-chart-bar')) {
                    $icon.html('📈');
                } else if ($icon.hasClass('fa-user-cog')) {
                    $icon.html('⚙️');
                } else if ($icon.hasClass('fa-plus')) {
                    $icon.html('➕');
                } else if ($icon.hasClass('fa-upload')) {
                    $icon.html('⬆️');
                } else if ($icon.hasClass('fa-clock')) {
                    $icon.html('⏰');
                } else if ($icon.hasClass('fa-cog')) {
                    $icon.html('⚙️');
                } else if ($icon.hasClass('fa-shipping-fast')) {
                    $icon.html('🚚');
                } else if ($icon.hasClass('fa-chart-pie')) {
                    $icon.html('📊');
                } else if ($icon.hasClass('fa-chart-line')) {
                    $icon.html('📈');
                } else if ($icon.hasClass('fa-chart-area')) {
                    $icon.html('📊');
                } else if ($icon.hasClass('fa-file-invoice-dollar')) {
                    $icon.html('💰');
                } else if ($icon.hasClass('fa-user')) {
                    $icon.html('👤');
                } else if ($icon.hasClass('fa-shield-alt')) {
                    $icon.html('🛡️');
                } else if ($icon.hasClass('fa-cogs')) {
                    $icon.html('⚙️');
                } else if ($icon.hasClass('fa-history')) {
                    $icon.html('🕒');
                } else if ($icon.hasClass('fa-eye')) {
                    $icon.html('👁️');
                } else if ($icon.hasClass('fa-edit')) {
                    $icon.html('✏️');
                } else if ($icon.hasClass('fa-palette')) {
                    $icon.html('🎨');
                } else if ($icon.hasClass('fa-list')) {
                    $icon.html('📋');
                } else if ($icon.hasClass('fa-list-alt')) {
                    $icon.html('📝');
                } else if ($icon.hasClass('fa-bell')) {
                    $icon.html('🔔');
                } else if ($icon.hasClass('fa-user')) {
                    $icon.html('👤');
                } else if ($icon.hasClass('fa-sign-out-alt')) {
                    $icon.html('🚪');
                } else {
                    $icon.html('•');
                }
                $icon.removeClass().addClass('nav-icon emoji-icon');
            });
        } else {
            console.log('Seller FontAwesome is loaded properly, no fallbacks needed');
        }
    }, 2000); // Give FontAwesome more time to load
    
    // Debug: Check if AdminLTE is loaded
    if (typeof $.fn.PushMenu === 'undefined') {
        console.error('AdminLTE PushMenu plugin not loaded!');
        
        // Fallback sidebar toggle
        $hamburgerBtn.on('click', function(e) {
            e.preventDefault();
            $('body').toggleClass('sidebar-collapse');
            localStorage.setItem('sidebar-collapse', $('body').hasClass('sidebar-collapse') ? 'true' : 'false');
        });
    }
    
    // Handle menu expand/collapse arrows
    $('.nav-sidebar .nav-link').on('click', function(e) {
        var $this = $(this);
        var $parent = $this.parent('.nav-item');
        var $treeview = $parent.find('.nav-treeview');
        
        if ($treeview.length > 0) {
            // This is a parent menu item with submenu
            if ($parent.hasClass('menu-open')) {
                $parent.removeClass('menu-open');
                $treeview.slideUp(300);
            } else {
                // Close other open menus
                $('.nav-sidebar .nav-item.menu-open').removeClass('menu-open').find('.nav-treeview').slideUp(300);
                // Open this menu
                $parent.addClass('menu-open');
                $treeview.slideDown(300);
            }
            e.preventDefault();
            return false;
        }
    });
});

// Show verification alert for disabled menu items
function showVerificationAlert() {
    Swal.fire({
        icon: 'warning',
        title: 'Verification Required',
        html: '<p>You need to complete your account verification to access this feature.</p><p><strong>Please complete your verification process first.</strong></p>',
        showCancelButton: true,
        confirmButtonText: 'Go to Verification',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6b7280',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route("seller.verification.status") }}';
        }
    });
}
</script>
</body>
</html>
