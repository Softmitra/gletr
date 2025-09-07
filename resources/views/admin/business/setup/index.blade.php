@extends('layouts.admin')

@section('title', 'Business Setup')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('page_title', 'Business Setup')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Business Setup</li>
@endsection



@section('admin-content')


<div class="container-fluid fade-in">
    <!-- Modern Page Header -->
   

    <div class="row">
        <div class="col-12">
            <!-- Modern Business Setup Tabs with AJAX Navigation -->
            <div class="business-setup-tabs slide-up">
                <ul class="nav nav-pills" id="business-setup-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'general' ? 'active' : '' }}" 
                           href="{{ route('admin.business.setup.general') }}"
                           data-tab="general"
                           data-ajax-nav>
                            <i class="fas fa-cog"></i>
                            <span>General</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'website-setup' ? 'active' : '' }}" 
                           href="{{ route('admin.business.setup.website-setup') }}"
                           data-tab="website-setup"
                           data-ajax-nav>
                            <i class="fas fa-globe"></i>
                            <span>Website Setup</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'sellers' ? 'active' : '' }}" 
                           href="{{ route('admin.business.setup.sellers') }}"
                           data-tab="sellers"
                           data-ajax-nav>
                            <i class="fas fa-users"></i>
                            <span>Sellers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'commission-setup' ? 'active' : '' }}" 
                           href="{{ route('admin.business.setup.commission-setup') }}"
                           data-tab="commission-setup"
                           data-ajax-nav>
                            <i class="fas fa-percentage"></i>
                            <span>Commission Setup</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Dynamic Content Area -->
            <div id="tab-content-area" class="slide-up" style="animation-delay: 0.1s;">
                <div id="loading-indicator" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading content...</p>
                </div>
                
                <div id="tab-content">
                    @if($activeTab === 'general')
                        @include('admin.business.setup.tabs.general')
                    @elseif($activeTab === 'website-setup')
                        @include('admin.business.setup.tabs.website-setup')
                    @elseif($activeTab === 'sellers')
                        @include('admin.business.setup.tabs.sellers')
                    @elseif($activeTab === 'commission-setup')
                        @include('admin.business.setup.tabs.commission-setup')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    /* Modern Color Palette */
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #a5b4fc;
        --secondary-color: #f1f5f9;
        --accent-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --bg-white: #ffffff;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Modern Tab Design */
    .business-setup-tabs {
        background: var(--bg-white);
        border-radius: 16px;
        padding: 8px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }
    
    .business-setup-tabs .nav-pills {
        gap: 4px;
    }
    
    .business-setup-tabs .nav-link {
        background: transparent;
        border: none;
        color: var(--text-secondary);
        font-weight: 600;
        padding: 16px 24px;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        text-decoration: none;
    }
    
    .business-setup-tabs .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 12px;
    }
    
    .business-setup-tabs .nav-link:hover {
        color: var(--primary-color);
        background: var(--secondary-color);
        transform: translateY(-2px);
    }
    
    .business-setup-tabs .nav-link.active {
        color: white;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }
    
    .business-setup-tabs .nav-link.active::before {
        opacity: 1;
    }
    
    .business-setup-tabs .nav-link i {
        font-size: 1.1rem;
        z-index: 1;
        position: relative;
    }
    
    .business-setup-tabs .nav-link span {
        z-index: 1;
        position: relative;
    }
    
    /* Modern Tab Content */
    #tab-content-area {
        background: var(--bg-white);
        border-radius: 20px;
        padding: 0;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }
    
    /* Modern Card Design */
    .modern-card {
        background: var(--bg-white);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .modern-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    
    .modern-card .card-header {
        background: linear-gradient(135deg, var(--bg-light) 0%, var(--secondary-color) 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
        border-radius: 16px 16px 0 0;
    }
    
    .modern-card .card-title {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .modern-card .card-subtitle {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
        font-weight: 400;
    }
    
    .modern-card .card-body {
        padding: 2rem;
    }
    
    /* Modern Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-control {
        border-radius: 12px;
        border: 2px solid var(--border-color);
        padding: 14px 16px;
        transition: all 0.3s ease;
        background: var(--bg-white);
        font-size: 0.95rem;
        color: var(--text-primary);
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        background: var(--bg-white);
        outline: none;
    }
    
    .form-control::placeholder {
        color: var(--text-muted);
    }
    
    /* Modern Input Groups */
    .input-group-text {
        background: var(--secondary-color);
        border: 2px solid var(--border-color);
        border-right: none;
        color: var(--text-secondary);
        font-weight: 500;
        border-radius: 12px 0 0 12px;
        padding: 14px 16px;
    }
    
    .input-group .form-control {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }
    
    .input-group .form-control:focus {
        border-left: 2px solid var(--primary-color);
    }
    
    /* Modern Buttons */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark) 0%, #3730a3 100%);
    }
    
    .btn-primary:active {
        transform: translateY(0);
    }
    
    .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }
    
    /* Modern Maintenance Toggle */
    .maintenance-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 1.5rem 2rem;
        border-radius: 16px;
        border: 1px solid #f59e0b;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
    }
    
    .maintenance-info h5 {
        margin: 0 0 0.5rem 0;
        color: #92400e;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .maintenance-info p {
        margin: 0;
        color: #a16207;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    /* Modern Toggle Switch */
    .modern-switch {
        position: relative;
        display: inline-block;
        width: 64px;
        height: 36px;
    }
    
    .modern-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #cbd5e1;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 36px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .switch-slider:before {
        position: absolute;
        content: "";
        height: 28px;
        width: 28px;
        left: 4px;
        bottom: 4px;
        background: white;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: var(--shadow-md);
    }
    
    input:checked + .switch-slider {
        background: var(--primary-color);
        box-shadow: inset 0 2px 4px rgba(99, 102, 241, 0.2);
    }
    
    input:checked + .switch-slider:before {
        transform: translateX(28px);
        box-shadow: var(--shadow-lg);
    }
    
    /* Modern Select Styling */
    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px 12px;
        padding-right: 40px;
        appearance: none;
    }
    
    /* Modern Checkbox Styling */
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    .form-check-label {
        color: var(--text-primary);
        font-weight: 500;
        margin-left: 0.5rem;
    }
    
    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .slide-up {
        animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Loading indicator */
    #loading-indicator {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 16px;
        padding: 2rem;
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    /* Tab Content Specific Styles */
    .tab-pane {
        background: var(--bg-white);
        border-radius: 0 0 20px 20px;
        padding: 0;
    }

    .tab-pane .p-4 {
        padding: 2rem !important;
    }

    /* Enhanced Form Styling for Tabs */
    .tab-pane .form-group {
        margin-bottom: 1.5rem;
    }

    .tab-pane .form-control {
        border-radius: 12px;
        border: 2px solid var(--border-color);
        padding: 14px 16px;
        transition: all 0.3s ease;
        background: var(--bg-white);
        font-size: 0.95rem;
        color: var(--text-primary);
    }

    .tab-pane .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        background: var(--bg-white);
        outline: none;
    }

    .tab-pane .form-control::placeholder {
        color: var(--text-muted);
    }

    /* Enhanced Table Styling */
    .tab-pane .table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .tab-pane .table thead {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .tab-pane .table thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .tab-pane .table tbody td {
        padding: 1rem;
        border-color: var(--border-color);
        vertical-align: middle;
    }

    .tab-pane .table tbody tr:hover {
        background: var(--secondary-color);
    }

    /* Enhanced Checkbox Styling */
    .tab-pane .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        transition: all 0.2s ease;
        margin-top: 0.1rem;
    }

    .tab-pane .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .tab-pane .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .tab-pane .form-check-label {
        color: var(--text-primary);
        font-weight: 500;
        margin-left: 0.5rem;
        line-height: 1.4;
    }

    /* Enhanced Button Styling */
    .tab-pane .btn {
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tab-pane .btn-sm {
        padding: 8px 16px;
        font-size: 0.85rem;
    }

    .tab-pane .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
    }

    .tab-pane .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .tab-pane .btn-danger {
        background: var(--danger-color);
        border: none;
        color: white;
    }

    .tab-pane .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* Enhanced Card Styling for Tabs */
    .tab-pane .modern-card {
        margin-bottom: 1.5rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .tab-pane .modern-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .tab-pane .modern-card .card-header {
        background: linear-gradient(135deg, var(--bg-light) 0%, var(--secondary-color) 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
        border-radius: 16px 16px 0 0;
    }

    .tab-pane .modern-card .card-title {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tab-pane .modern-card .card-subtitle {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
        font-weight: 400;
    }

    .tab-pane .modern-card .card-body {
        padding: 2rem;
    }

    /* Enhanced Input Group Styling */
    .tab-pane .input-group-text {
        background: var(--secondary-color);
        border: 2px solid var(--border-color);
        border-right: none;
        color: var(--text-secondary);
        font-weight: 500;
        border-radius: 12px 0 0 12px;
        padding: 14px 16px;
    }

    .tab-pane .input-group .form-control {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }

    .tab-pane .input-group .form-control:focus {
        border-left: 2px solid var(--primary-color);
    }

    /* Enhanced Select Styling */
    .tab-pane select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px 12px;
        padding-right: 40px;
        appearance: none;
    }

    /* Enhanced Textarea Styling */
    .tab-pane textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Enhanced Small Text Styling */
    .tab-pane .text-muted {
        color: var(--text-muted) !important;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    /* Enhanced Info Tooltip */
    .tab-pane .info-tooltip {
        position: relative;
        display: inline-block;
        margin-left: 0.5rem;
    }

    .tab-pane .info-tooltip .tooltiptext {
        visibility: hidden;
        width: 200px;
        background-color: var(--text-primary);
        color: white;
        text-align: center;
        border-radius: 8px;
        padding: 8px 12px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -100px;
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 0.8rem;
        box-shadow: var(--shadow-lg);
    }

    .tab-pane .info-tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    /* Enhanced Row and Column Spacing */
    .tab-pane .row {
        margin-left: -0.75rem;
        margin-right: -0.75rem;
    }

    .tab-pane .col-md-6 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    /* Enhanced Maintenance Toggle for General Tab */
    .tab-pane .maintenance-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 1.5rem 2rem;
        border-radius: 16px;
        border: 1px solid #f59e0b;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
    }

    .tab-pane .maintenance-info h5 {
        margin: 0 0 0.5rem 0;
        color: #92400e;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .tab-pane .maintenance-info p {
        margin: 0;
        color: #a16207;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Enhanced Modern Switch for Tabs */
    .tab-pane .modern-switch {
        position: relative;
        display: inline-block;
        width: 64px;
        height: 36px;
    }

    .tab-pane .modern-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .tab-pane .switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #cbd5e1;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 36px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    .tab-pane .switch-slider:before {
        position: absolute;
        content: "";
        height: 28px;
        width: 28px;
        left: 4px;
        bottom: 4px;
        background: white;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: var(--shadow-md);
    }

    .tab-pane input:checked + .switch-slider {
        background: var(--primary-color);
        box-shadow: inset 0 2px 4px rgba(99, 102, 241, 0.2);
    }

    .tab-pane input:checked + .switch-slider:before {
        transform: translateX(28px);
        box-shadow: var(--shadow-lg);
    }
</style>
@endpush
@push('js')
<script>
// Define AJAX routes for JavaScript
const ajaxRoutes = {
    'general': '{{ route("admin.business.setup.ajax", "general") }}',
    'website-setup': '{{ route("admin.business.setup.ajax", "website-setup") }}',
    'sellers': '{{ route("admin.business.setup.ajax", "sellers") }}',
    'commission-setup': '{{ route("admin.business.setup.ajax", "commission-setup") }}'
};

$(document).ready(function() {
    // Initialize AJAX navigation
    initAjaxNavigation();
    
    // Initialize current tab functionality
    initCurrentTabFunctionality();
    
    // Debug: Log available routes
    console.log('Available AJAX routes:', ajaxRoutes);
});

// AJAX Navigation System
function initAjaxNavigation() {
    // Handle AJAX navigation clicks
    $('[data-ajax-nav]').on('click', function(e) {
        e.preventDefault();
        
        const $link = $(this);
        const tab = $link.data('tab');
        const url = $link.attr('href');
        
        // Don't reload if already active
        if ($link.hasClass('active')) {
            return;
        }
        
        loadTabContent(tab, url, $link);
    });
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.tab) {
            const tab = e.state.tab;
            const $link = $(`[data-tab="${tab}"]`);
            if ($link.length) {
                loadTabContent(tab, $link.attr('href'), $link, false);
            }
        }
    });
}

// Load tab content via AJAX
function loadTabContent(tab, url, $clickedLink, updateHistory = true) {
    // Show loading indicator
    showLoadingIndicator();
    
    // Update active tab
    updateActiveTab($clickedLink);
    
    // Make AJAX request
    const ajaxUrl = ajaxRoutes[tab];
    console.log('Loading tab:', tab, 'URL:', ajaxUrl); // Debug log
    
    if (!ajaxUrl) {
        console.error('No AJAX route found for tab:', tab);
        handleAjaxError('Invalid tab specified', url);
        return;
    }
    
    $.ajax({
        url: ajaxUrl,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Update content
                $('#tab-content').html(response.content);
                
                // Update page title
                document.title = `Business Setup - ${response.title} | Admin Dashboard`;
                
                // Update URL without page reload
                if (updateHistory) {
                    window.history.pushState(
                        { tab: tab }, 
                        response.title, 
                        url
                    );
                }
                
                // Initialize tab-specific functionality
                initTabSpecificFunctionality(tab);
                
                // Hide loading indicator with animation
                hideLoadingIndicator();
                
                // Add slide-up animation to new content
                $('#tab-content').addClass('slide-up');
                setTimeout(() => $('#tab-content').removeClass('slide-up'), 500);
                
                // Show success toast
                showModernToast(`${response.title} loaded successfully`, 'success');
                
            } else {
                handleAjaxError('Failed to load content', url);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error, xhr);
            let errorMessage = 'Network error occurred';
            
            if (xhr.status === 404) {
                errorMessage = 'Content not found';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error occurred';
            } else if (xhr.status === 0) {
                errorMessage = 'Connection failed';
            }
            
            handleAjaxError(errorMessage, url);
        }
    });
}

// Show loading indicator
function showLoadingIndicator() {
    $('#loading-indicator').fadeIn(200);
    $('#tab-content').css('opacity', '0.5');
}

// Hide loading indicator
function hideLoadingIndicator() {
    $('#loading-indicator').fadeOut(200);
    $('#tab-content').css('opacity', '1');
}

// Update active tab styling
function updateActiveTab($clickedLink) {
    // Remove active class from all tabs
    $('#business-setup-tabs .nav-link').removeClass('active');
    
    // Add active class to clicked tab
    $clickedLink.addClass('active');
    
    // Add loading state to clicked tab
    $clickedLink.addClass('loading');
    setTimeout(() => $clickedLink.removeClass('loading'), 500);
}

// Handle AJAX errors
function handleAjaxError(message, fallbackUrl = null) {
    hideLoadingIndicator();
    showModernToast(message, 'error');
    
    // Provide fallback to direct page navigation
    if (fallbackUrl) {
        setTimeout(() => {
            if (confirm('Would you like to navigate to the page directly?')) {
                window.location.href = fallbackUrl;
            }
        }, 2000);
    }
}

// Initialize tab-specific functionality after AJAX load
function initTabSpecificFunctionality(tab) {
    switch(tab) {
        case 'general':
            initGeneralTabFunctionality();
            break;
        case 'website-setup':
            initWebsiteSetupTabFunctionality();
            break;
        case 'sellers':
            initSellersTabFunctionality();
            break;
        case 'commission-setup':
            initCommissionSetupTabFunctionality();
            break;
    }
    
    // Re-initialize common functionality
    initCommonTabFunctionality();
}

// Initialize current tab functionality (for initial page load)
function initCurrentTabFunctionality() {
    const activeTab = $('.nav-link.active').data('tab');
    if (activeTab) {
        initTabSpecificFunctionality(activeTab);
    }
}

// Common functionality for all tabs
function initCommonTabFunctionality() {
    // Form interactions
    $('.form-control').off('focus blur').on('focus', function() {
        $(this).closest('.form-group').addClass('form-group-focused');
    }).on('blur', function() {
        $(this).closest('.form-group').removeClass('form-group-focused');
    });
    
    // Checkbox interactions
    $('.form-check-input').off('change').on('change', function() {
        const label = $(this).next('.form-check-label');
        if ($(this).is(':checked')) {
            label.addClass('checked-label');
        } else {
            label.removeClass('checked-label');
        }
    });
    
    // Form submissions
    $('form[data-form-type]').off('submit').on('submit', function(e) {
        e.preventDefault();
        handleFormSubmission($(this));
    });
}

// Tab-specific functionality
function initGeneralTabFunctionality() {
    // Maintenance mode toggle
    $('#maintenance-mode').off('change').on('change', function() {
        const isEnabled = $(this).is(':checked');
        const toggle = $(this);
        
        if (isEnabled) {
            Swal.fire({
                title: '<i class="fas fa-tools text-warning mb-3" style="font-size: 3rem;"></i><br>Enable Maintenance Mode?',
                html: '<p class="text-muted">This will temporarily disable your website for visitors while you perform maintenance.</p>',
                icon: null,
                showCancelButton: true,
                confirmButtonColor: 'var(--warning-color)',
                cancelButtonColor: 'var(--text-muted)',
                confirmButtonText: '<i class="fas fa-check me-2"></i>Yes, enable it!',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel'
            }).then((result) => {
                if (!result.isConfirmed) {
                    toggle.prop('checked', false);
                } else {
                    showModernToast('Maintenance mode enabled', 'warning');
                }
            });
        } else {
            showModernToast('Maintenance mode disabled', 'success');
        }
    });
}

function initWebsiteSetupTabFunctionality() {
    // Website setup specific functionality
    console.log('Website Setup tab functionality initialized');
}

function initSellersTabFunctionality() {
    // Sellers specific functionality
    console.log('Sellers tab functionality initialized');
}

function initCommissionSetupTabFunctionality() {
    // Commission setup specific functionality
    
    // Commission type change handler
    $('#commission_type').off('change').on('change', function() {
        const symbol = $(this).val() === 'percentage' ? '%' : '₹';
        $('.commission-symbol').text(symbol);
    });
    
    // Add new category commission row
    $('#add-category-commission').off('click').on('click', function() {
        const rowCount = $('#category-commission-table tbody tr').length;
        const newRow = `
            <tr>
                <td>
                    <select class="form-control" name="category_commissions[${rowCount}][category_id]">
                        <option value="1">Electronics</option>
                        <option value="2">Fashion</option>
                        <option value="3">Home & Garden</option>
                        <option value="4">Sports & Outdoors</option>
                        <option value="5">Books</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" name="category_commissions[${rowCount}][rate]" value="10" min="0" step="0.01">
                </td>
                <td>
                    <select class="form-control" name="category_commissions[${rowCount}][type]">
                        <option value="percentage" selected>Percentage</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-category-commission">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#category-commission-table tbody').append(newRow);
    });
    
    // Remove category commission row
    $(document).off('click', '.remove-category-commission').on('click', '.remove-category-commission', function() {
        if ($('#category-commission-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            showModernToast('At least one category commission must be configured.', 'error');
        }
    });
}

// Handle form submissions
function handleFormSubmission($form) {
    const formType = $form.data('form-type');
    const submitBtn = $form.find('button[type="submit"]');
    const originalText = submitBtn.html();
    
    // Modern loading state
    submitBtn.prop('disabled', true)
             .html('<div class="d-flex align-items-center"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Saving...</div>')
             .addClass('btn-loading');
    
    // Add subtle form animation
    $form.addClass('form-submitting');
    
    // Simulate form submission
    setTimeout(() => {
        submitBtn.prop('disabled', false)
                 .html(originalText)
                 .removeClass('btn-loading');
        
        $form.removeClass('form-submitting');
        
        // Show success message
        const messages = {
            'general': 'General settings updated successfully!',
            'website-setup': 'Website configuration saved successfully!',
            'sellers': 'Seller settings updated successfully!',
            'commission-setup': 'Commission structure saved successfully!'
        };
        
        const message = messages[formType] || 'Settings updated successfully!';
        showModernToast(message, 'success');
        
        // Add success animation to form
        $form.addClass('form-success');
        setTimeout(() => $form.removeClass('form-success'), 1000);
        
    }, Math.random() * 1000 + 1500);
}
    
    // Enhanced form validation and submission with modern feedback
    $('form[data-form-type]').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const formType = form.data('form-type');
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Modern loading state
        submitBtn.prop('disabled', true)
                 .html('<div class="d-flex align-items-center"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Saving...</div>')
                 .addClass('btn-loading');
        
        // Add subtle form animation
        form.addClass('form-submitting');
        
        // Simulate form submission with realistic timing
        setTimeout(() => {
            submitBtn.prop('disabled', false)
                     .html(originalText)
                     .removeClass('btn-loading');
            
            form.removeClass('form-submitting');
            
            // Modern success notification
            showModernSuccess(formType);
            
            // Add success animation to form
            form.addClass('form-success');
            setTimeout(() => form.removeClass('form-success'), 1000);
            
        }, Math.random() * 1000 + 1500); // Random delay between 1.5-2.5s for realism
    });
    
    // Modern toast notification system
    function showModernToast(message, type = 'success') {
        const toastId = 'toast-' + Date.now();
        const iconMap = {
            success: 'fas fa-check-circle text-success',
            warning: 'fas fa-exclamation-triangle text-warning',
            error: 'fas fa-times-circle text-danger',
            info: 'fas fa-info-circle text-info'
        };
        
        const toast = `
            <div id="${toastId}" class="modern-toast toast-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-radius: 12px;
                padding: 16px 20px;
                box-shadow: var(--shadow-lg);
                border-left: 4px solid var(--${type === 'success' ? 'accent' : type}-color);
                z-index: 9999;
                transform: translateX(400px);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                max-width: 350px;
            ">
                <div class="d-flex align-items-center">
                    <i class="${iconMap[type]} me-3" style="font-size: 1.2rem;"></i>
                    <span style="color: var(--text-primary); font-weight: 500;">${message}</span>
                    <button onclick="closeToast('${toastId}')" style="
                        background: none;
                        border: none;
                        margin-left: auto;
                        color: var(--text-muted);
                        font-size: 1.1rem;
                        cursor: pointer;
                        padding: 0 0 0 10px;
                    ">×</button>
                </div>
            </div>
        `;
        
        $('body').append(toast);
        
        // Animate in
        setTimeout(() => {
            $(`#${toastId}`).css('transform', 'translateX(0)');
        }, 100);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            closeToast(toastId);
        }, 4000);
    }
    
    // Modern success notification with specific messages
    function showModernSuccess(formType) {
        const messages = {
            'general': 'General settings updated successfully!',
            'website-setup': 'Website configuration saved successfully!',
            'sellers': 'Seller settings updated successfully!',
            'commission-setup': 'Commission structure saved successfully!'
        };
        
        const message = messages[formType] || 'Settings updated successfully!';
        showModernToast(message, 'success');
    }
    
    // Enhanced form interactions
    $('.form-control').on('focus', function() {
        $(this).closest('.form-group').addClass('form-group-focused');
    }).on('blur', function() {
        $(this).closest('.form-group').removeClass('form-group-focused');
    });
    
    // Modern checkbox and radio interactions
    $('.form-check-input').on('change', function() {
        const label = $(this).next('.form-check-label');
        if ($(this).is(':checked')) {
            label.addClass('checked-label');
        } else {
            label.removeClass('checked-label');
        }
    });
    
    // Smooth scroll to top when switching tabs
    $('#business-setup-tabs button[data-bs-toggle="pill"]').on('click', function() {
        $('html, body').animate({
            scrollTop: $('.business-setup-tabs').offset().top - 20
        }, 300);
    });
    
    // Initialize modern interactions
    initModernInteractions();
});

// Close toast function
function closeToast(toastId) {
    const toast = $(`#${toastId}`);
    toast.css('transform', 'translateX(400px)');
    setTimeout(() => toast.remove(), 400);
}

// Initialize modern interactions
function initModernInteractions() {
    // Add hover effects to cards
    $('.modern-card').hover(
        function() { $(this).addClass('card-hover'); },
        function() { $(this).removeClass('card-hover'); }
    );
    
    // Initialize tooltips with modern styling
    $('[data-bs-toggle="tooltip"]').tooltip({
        customClass: 'modern-tooltip'
    });
    
    // Add ripple effect to buttons
    $('.btn').on('click', function(e) {
        const button = $(this);
        const ripple = $('<span class="btn-ripple"></span>');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.css({
            width: size + 'px',
            height: size + 'px',
            left: x + 'px',
            top: y + 'px'
        });
        
        button.append(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    });
}

// Add modern CSS for dynamic elements
const modernStyles = `
    <style>
        .form-group-focused .form-control {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md) !important;
        }
        
        .checked-label {
            color: var(--primary-color) !important;
            font-weight: 600 !important;
        }
        
        .card-hover {
            transform: translateY(-4px) !important;
            box-shadow: var(--shadow-xl) !important;
        }
        
        .form-submitting {
            opacity: 0.8;
            pointer-events: none;
        }
        
        .form-success {
            animation: formSuccess 0.6s ease;
        }
        
        @keyframes formSuccess {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .btn-loading {
            position: relative;
            overflow: hidden;
        }
        
        .btn-ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
        
        .modern-swal-popup {
            border-radius: 16px !important;
            box-shadow: var(--shadow-xl) !important;
        }
        
        .modern-swal-confirm {
            border-radius: 8px !important;
            font-weight: 600 !important;
        }
        
        .modern-swal-cancel {
            border-radius: 8px !important;
            font-weight: 600 !important;
        }
    </style>
`;

$('head').append(modernStyles);

// Enhanced tab-specific functionality
function initTabSpecificEnhancements() {
    // Add smooth transitions to all form elements
    $('.tab-pane .form-control').on('focus', function() {
        $(this).closest('.form-group').addClass('form-group-focused');
    }).on('blur', function() {
        $(this).closest('.form-group').removeClass('form-group-focused');
    });

    // Enhanced checkbox interactions
    $('.tab-pane .form-check-input').on('change', function() {
        const label = $(this).next('.form-check-label');
        if ($(this).is(':checked')) {
            label.addClass('checked-label');
        } else {
            label.removeClass('checked-label');
        }
    });

    // Enhanced table interactions
    $('.tab-pane .table tbody tr').hover(
        function() {
            $(this).addClass('table-row-hover');
        },
        function() {
            $(this).removeClass('table-row-hover');
        }
    );

    // Enhanced button interactions
    $('.tab-pane .btn').on('click', function(e) {
        const button = $(this);
        const ripple = $('<span class="btn-ripple"></span>');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.css({
            width: size + 'px',
            height: size + 'px',
            left: x + 'px',
            top: y + 'px'
        });
        
        button.append(ripple);
        setTimeout(() => ripple.remove(), 600);
    });

    // Enhanced select interactions
    $('.tab-pane select.form-control').on('change', function() {
        $(this).addClass('select-changed');
        setTimeout(() => $(this).removeClass('select-changed'), 300);
    });

    // Enhanced textarea interactions
    $('.tab-pane textarea.form-control').on('input', function() {
        const textarea = $(this);
        const charCount = textarea.val().length;
        const maxLength = textarea.attr('maxlength');
        
        if (maxLength) {
            const remaining = maxLength - charCount;
            if (remaining < 50) {
                textarea.addClass('textarea-warning');
            } else {
                textarea.removeClass('textarea-warning');
            }
        }
    });
}

// Initialize tab enhancements when content loads
initTabSpecificEnhancements();

// Re-initialize when AJAX content loads
$(document).on('ajaxContentLoaded', function() {
    initTabSpecificEnhancements();
});
</script>
@endpush

@endsection
