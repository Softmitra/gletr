@extends('adminlte::page')

@section('title', 'Gletr Admin Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    @yield('breadcrumbs')
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    @yield('admin-content')
@stop

@section('css')
    <!-- Google Fonts: Spline Sans & Noto Sans -->
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Spline+Sans%3Awght%40400%3B500%3B700" onload="this.rel='stylesheet'" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <!-- Font Awesome - Multiple Sources for Reliability -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" id="fontawesome-local">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" id="fontawesome-cdn">
    <!-- Alternative CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" crossorigin="anonymous" id="fontawesome-cdn2">
    <!-- Font Awesome Webfont Preload -->
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-regular-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    
    {{-- AdminLTE v3 Custom Styles --}}
    <style>
        /* Global Font Family */
        * {
            font-family: "Spline Sans", "Noto Sans", sans-serif !important;
        }
        
        body, html {
            font-family: "Spline Sans", "Noto Sans", sans-serif !important;
        }
        
        /* AdminLTE v3 Custom Enhancements */
        .main-header.navbar {
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
        
        /* AdminLTE Default Sidebar - White Theme */
        .main-sidebar {
            box-shadow: 0 14px 28px rgba(0,0,0,.05), 0 10px 10px rgba(0,0,0,.05);
            background: #ffffff !important;
            border-right: 1px solid #dee2e6;
        }
        
        /* Sidebar Text Colors - White Background Theme */
        .main-sidebar,
        .main-sidebar * {
            color: #495057 !important;
        }
        
        .main-sidebar .nav-sidebar .nav-link,
        .main-sidebar .nav-sidebar .nav-link *,
        .main-sidebar .nav-sidebar .nav-link p,
        .main-sidebar .nav-sidebar .nav-link span,
        .main-sidebar .nav-sidebar .nav-link i,
        .main-sidebar .nav-sidebar .nav-link a {
            color: #495057 !important;
        }
        
        .main-sidebar .nav-sidebar .nav-link:hover,
        .main-sidebar .nav-sidebar .nav-link:hover *,
        .main-sidebar .nav-sidebar .nav-link:hover p,
        .main-sidebar .nav-sidebar .nav-link:hover span,
        .main-sidebar .nav-sidebar .nav-link:hover i {
            color: #212529 !important;
            background-color: rgba(0,0,0,.03) !important;
        }
        
        .main-sidebar .nav-sidebar .nav-link.active,
        .main-sidebar .nav-sidebar .nav-link.active *,
        .main-sidebar .nav-sidebar .nav-link.active p,
        .main-sidebar .nav-sidebar .nav-link.active span,
        .main-sidebar .nav-sidebar .nav-link.active i {
            color: #ffffff !important;
            background-color: #007bff !important;
        }
        
        /* AdminLTE Default Section Headers */
        .main-sidebar .nav-header,
        .main-sidebar .nav-header * {
            color: #939ba2 !important;
            background-color: transparent !important;
            font-weight: 400;
            font-size: .85rem;
            padding: .5rem 1rem .5rem 1.5rem;
            text-transform: uppercase;
            letter-spacing: .03rem;
        }
        
        .main-sidebar .brand-text,
        .main-sidebar .brand-link,
        .main-sidebar .brand-link * {
            color: #2c3e50 !important;
            font-weight: 700;
        }
        
        .main-sidebar .brand-link:hover,
        .main-sidebar .brand-link:hover * {
            color: #007bff !important;
        }
        
        /* AdminLTE Default Submenu Styling */
        .main-sidebar .nav-treeview .nav-link,
        .main-sidebar .nav-treeview .nav-link * {
            color: #6c757d !important;
            font-size: 0.875rem;
            padding-left: 2rem !important;
        }
        
        .main-sidebar .nav-treeview .nav-link:hover,
        .main-sidebar .nav-treeview .nav-link:hover * {
            color: #212529 !important;
            background-color: transparent !important;
        }
        
        .main-sidebar .nav-treeview .nav-link.active,
        .main-sidebar .nav-treeview .nav-link.active * {
            color: #000 !important;
            font-weight: 600;
        }
        
        /* Search box in sidebar */
        .sidebar-search-results .list-group-item {
            background-color: #f8f9fa;
            color: #495057 !important;
            border: 1px solid #e9ecef;
            border-radius: 6px;
        }
        
        .form-control-sidebar {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #495057 !important;
            border-radius: 8px;
        }
        
        .form-control-sidebar::placeholder {
            color: #6c757d !important;
        }
        
        .form-control-sidebar:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .btn-sidebar {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #495057 !important;
            border-radius: 8px;
        }
        
        .btn-sidebar:hover {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff !important;
        }
        
        /* Override any AdminLTE default text colors for white theme */
        .sidebar-light .nav-sidebar .nav-link,
        .sidebar-light .nav-sidebar .nav-link *,
        .sidebar-light .nav-sidebar .nav-link p,
        .sidebar-light .nav-sidebar .nav-link span,
        .sidebar-light .nav-sidebar .nav-link i,
        .sidebar-dark-navy .nav-sidebar .nav-link,
        .sidebar-dark-navy .nav-sidebar .nav-link *,
        .sidebar-dark-navy .nav-sidebar .nav-link p,
        .sidebar-dark-navy .nav-sidebar .nav-link span,
        .sidebar-dark-navy .nav-sidebar .nav-link i {
            color: #495057 !important;
        }
        
        .sidebar-light .nav-header,
        .sidebar-light .nav-header *,
        .sidebar-dark-navy .nav-header,
        .sidebar-dark-navy .nav-header * {
            color: #6c757d !important;
        }
        
        .sidebar-light .brand-text,
        .sidebar-light .brand-link,
        .sidebar-light .brand-link *,
        .sidebar-dark-navy .brand-text,
        .sidebar-dark-navy .brand-link,
        .sidebar-dark-navy .brand-link * {
            color: #2c3e50 !important;
        }
        
        /* AdminLTE Default Icon Styling */
        .nav-icon {
            width: 1.6rem !important;
            text-align: center !important;
            font-size: 1.2rem !important;
            margin-right: .5rem !important;
        }
        
        
        /* Enhanced sidebar styling - no animations */
        .main-sidebar .nav-sidebar {
            padding: 0.5rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        
        /* Disable all sidebar animations to prevent flickering */
        .nav-sidebar .nav-item > .nav-link,
        .nav-sidebar .nav-treeview,
        .nav-sidebar .nav-treeview .nav-item > .nav-link {
            transition: none !important;
            animation: none !important;
        }
        
        /* Prevent accordion animation flickering */
        .nav-treeview {
            display: none;
        }
        
        .nav-item.menu-open > .nav-treeview {
            display: block !important;
        }
        
        /* Menu arrow styling */
        .nav-sidebar .nav-link .right {
            transition: none !important;
        }
        
        .nav-sidebar .nav-item.menu-open > .nav-link .right {
            transform: rotate(90deg);
        }
        
        /* Ensure menu items with submenus are clickable */
        .nav-sidebar .nav-item:has(.nav-treeview) > .nav-link {
            cursor: pointer;
        }
        
        
        /* AdminLTE Default Navigation Menu */
        .main-sidebar .nav-sidebar .nav-link {
            padding: .5rem 1rem;
        }
        
        
        /* AdminLTE Default Brand Section */
        .main-sidebar .brand-link {
            border-bottom: 1px solid #dee2e6;
            padding: .8125rem .5rem;
            height: 57px;
        }
        
        .main-sidebar .brand-text,
        .main-sidebar .brand-link,
        .main-sidebar .brand-link * {
            color: #343a40 !important;
            font-weight: 300;
        }
        
        .main-sidebar .brand-link:hover {
            color: #343a40 !important;
            text-decoration: none;
        }
        
        
        
        .content-wrapper {
            background: #ffffff !important;
            min-height: calc(100vh - 57px);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .card:hover {
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }
        
        .small-box {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .small-box:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .small-box .icon {
            font-size: 70px;
        }
        
        .info-box {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .info-box:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .btn {
            border-radius: 25px;
            font-weight: 500;
        }
        
        .btn:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        /* Dark mode enhancements */
        .dark-mode .content-wrapper {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        }
        
        .dark-mode .card {
            background-color: #343a40;
            color: #fff;
        }
        
        /* Modern Custom Scrollbar */
        .nav-sidebar::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        
        .nav-sidebar::-webkit-scrollbar-track,
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .nav-sidebar::-webkit-scrollbar-thumb,
        .sidebar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 2px;
        }
        
        .nav-sidebar::-webkit-scrollbar-thumb:hover,
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
        
        /* Mobile Optimization */
        @media (max-width: 767.98px) {
            /* Mobile Sidebar */
            .main-sidebar {
                margin-left: -250px !important;
                z-index: 1050;
                box-shadow: 2px 0 15px rgba(0,0,0,0.15);
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
                background-color: rgba(0, 0, 0, 0.4);
                z-index: 1040;
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
            
            /* Mobile Menu Items */
            .nav-sidebar .nav-link {
                padding: 1rem 1.25rem;
                min-height: 48px;
                display: flex;
                align-items: center;
                font-size: 1rem;
                border-radius: 8px;
                margin: 0.25rem 0.75rem;
            }
            
            .nav-treeview .nav-link {
                padding: 0.6rem 0.8rem 0.6rem 1.8rem !important;
                font-size: 0.9rem;
                min-height: 40px;
                margin: 0.1rem 0.5rem 0.1rem 0.5rem;
            }
            
            /* Mobile icons - simple */
            .nav-icon {
                width: 1.5rem !important;
                font-size: 1.1rem !important;
                margin-right: 0.75rem !important;
            }
            
            .nav-treeview .nav-icon {
                width: 1.2rem !important;
                font-size: 0.9rem !important;
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
        
        
        /* Ensure FontAwesome icons are visible */
        .nav-icon {
            width: 1.2rem !important;
            text-align: center !important;
            font-size: 1rem !important;
            margin-right: 0.5rem !important;
            display: inline-block !important;
        }
        
        /* Global FontAwesome icon fix for all admin pages */
        .fas, .far, .fab, .fal, .fad,
        .fa, .nav-icon, 
        i[class*="fa-"],
        .nav-sidebar .nav-link i.nav-icon,
        .nav-sidebar .nav-link .fas,
        .nav-sidebar .nav-link .far,
        .nav-sidebar .nav-link .fab,
        .btn i, .card i, .table i, .badge i {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
            font-weight: 900 !important;
            display: inline-block !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            line-height: 1 !important;
        }
        
        /* Specific weight for regular icons */
        .far {
            font-weight: 400 !important;
        }
        
        /* Ensure icons are visible in all contexts */
        .content-wrapper .fas,
        .content-wrapper .far,
        .content-wrapper .fab,
        .content-wrapper i[class*="fa-"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
            display: inline-block !important;
        }
        
        
        /* Page transitions - no animation */
        .content-wrapper {
            /* No animation */
        }
        
        /* Modern table styling */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            border: none;
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            font-weight: 600;
        }
        
        .table tbody tr:hover {
            background-color: rgba(0,123,255,0.1);
        }
        
        /* Loading spinner - no animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
        }
        
        /* Avatar components */
        .avatar-sm {
            width: 32px;
            height: 32px;
            display: inline-block;
        }
        
        .avatar-lg {
            width: 80px;
            height: 80px;
            display: inline-block;
        }
        
        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            border-radius: 50%;
        }
        
        .avatar-title img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
    @stack('css')
@stop

@section('js')
    {{-- AdminLTE v3 Enhanced JavaScript --}}
    <script>
        $(document).ready(function() {
            console.log("Gletr Admin Panel v3 loaded successfully!");
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Initialize popovers
            $('[data-toggle="popover"]').popover();
            
            // FontAwesome is expected to be loaded via CDN
            console.log("Gletr Admin Panel v3 loaded successfully!");
            
            // Fix sidebar menu expand/collapse without animation to prevent flickering
            $(document).on('click', '.nav-sidebar .nav-link', function(e) {
                var $this = $(this);
                var $parent = $this.parent('.nav-item');
                var $treeview = $parent.find('> .nav-treeview');
                
                // Only handle menu items that have submenus
                if ($treeview.length > 0) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    var isCurrentlyOpen = $parent.hasClass('menu-open');
                    
                    // Close all other open menus first
                    $('.nav-sidebar .nav-item.menu-open').removeClass('menu-open');
                    $('.nav-sidebar .nav-treeview').hide();
                    
                    // Toggle current menu
                    if (!isCurrentlyOpen) {
                        $parent.addClass('menu-open');
                        $treeview.show();
                    }
                    
                    return false;
                }
            });
            
            // Handle submenu clicks (don't close parent menu)
            $(document).on('click', '.nav-treeview .nav-link', function(e) {
                e.stopPropagation();
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
                }
            });
            
            // Auto-refresh dashboard data every 30 seconds
            let refreshInterval;
            
            function startAutoRefresh() {
                refreshInterval = setInterval(function() {
                    // Add AJAX calls here to refresh dashboard data
                    updateDashboardStats();
                }, 30000);
            }
            
            function updateDashboardStats() {
                // Example: Update stats via AJAX
                // $.get('/admin/api/stats', function(data) {
                //     $('.stats-container').html(data);
                // });
            }
            
            // Dark mode toggle functionality
            function toggleDarkMode() {
                $('body').toggleClass('dark-mode');
                localStorage.setItem('darkMode', $('body').hasClass('dark-mode'));
            }
            
            // Load dark mode preference
            if (localStorage.getItem('darkMode') === 'true') {
                $('body').addClass('dark-mode');
            }
            
            // Add dark mode toggle button if not exists
            if ($('.navbar-nav .nav-item .dark-mode-toggle').length === 0) {
                $('.navbar-nav').append(`
                    <li class="nav-item">
                        <a class="nav-link dark-mode-toggle" href="#" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                            <i class="fas fa-moon"></i>
                        </a>
                    </li>
                `);
            }
            
            // Make toggleDarkMode globally available
            window.toggleDarkMode = toggleDarkMode;
            
            // Card hover effects (no animation)
            $('.card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
            
            // Loading states for buttons
            $(document).on('click', '.btn-loading', function() {
                let btn = $(this);
                let originalText = btn.html();
                btn.html('<span class="loading-spinner"></span> Loading...');
                btn.prop('disabled', true);
                
                // Re-enable after 3 seconds (adjust as needed)
                setTimeout(function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }, 3000);
            });
            
            // Start auto-refresh
            startAutoRefresh();
            
            // Cleanup on page unload
            $(window).on('beforeunload', function() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }
            });
        });
        
        // Global notification function
        function showNotification(message, type = 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: type,
                    title: message
                });
            } else {
                // Fallback to browser alert
                alert(message);
            }
        }
        
        // Make it globally available
        window.showNotification = showNotification;
    </script>
    @stack('js')
@stop