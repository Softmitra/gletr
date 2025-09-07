@extends('layouts.admin')

@section('title', 'Business Setup - Seller Management')

@section('page_title', 'Business Setup - Seller Management')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.business.setup') }}">Business Setup</a></li>
    <li class="breadcrumb-item active">Seller Management</li>
@endsection

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
    .business-setup-nav {
        background: var(--bg-white);
        border-radius: 16px;
        padding: 8px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }
    
    .business-setup-nav .nav-pills {
        gap: 4px;
    }
    
    .business-setup-nav .nav-link {
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
    
    .business-setup-nav .nav-link::before {
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
    
    .business-setup-nav .nav-link:hover {
        color: var(--primary-color);
        background: var(--secondary-color);
        transform: translateY(-2px);
    }
    
    .business-setup-nav .nav-link.active {
        color: white;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }
    
    .business-setup-nav .nav-link.active::before {
        opacity: 1;
    }
    
    .business-setup-nav .nav-link i {
        font-size: 1.1rem;
        z-index: 1;
        position: relative;
    }
    
    .business-setup-nav .nav-link span {
        z-index: 1;
        position: relative;
    }
    
    /* Modern Tab Content */
    #page-content {
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

    /* Enhanced Form Styling for Page Content */
    #page-content .form-group {
        margin-bottom: 1.5rem;
    }

    #page-content .form-control {
        border-radius: 12px;
        border: 2px solid var(--border-color);
        padding: 14px 16px;
        transition: all 0.3s ease;
        background: var(--bg-white);
        font-size: 0.95rem;
        color: var(--text-primary);
    }

    #page-content .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        background: var(--bg-white);
        outline: none;
    }

    #page-content .form-control::placeholder {
        color: var(--text-muted);
    }

    /* Enhanced Table Styling */
    #page-content .table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    #page-content .table thead {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
    }

    #page-content .table thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    #page-content .table tbody td {
        padding: 1rem;
        border-color: var(--border-color);
        vertical-align: middle;
    }

    #page-content .table tbody tr:hover {
        background: var(--secondary-color);
    }

    /* Enhanced Checkbox Styling */
    #page-content .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        transition: all 0.2s ease;
        margin-top: 0.1rem;
    }

    #page-content .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    #page-content .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    #page-content .form-check-label {
        color: var(--text-primary);
        font-weight: 500;
        margin-left: 0.5rem;
        line-height: 1.4;
    }

    /* Enhanced Button Styling */
    #page-content .btn {
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    #page-content .btn-sm {
        padding: 8px 16px;
        font-size: 0.85rem;
    }

    #page-content .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
    }

    #page-content .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    #page-content .btn-danger {
        background: var(--danger-color);
        border: none;
        color: white;
    }

    #page-content .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* Enhanced Card Styling for Page Content */
    #page-content .modern-card {
        margin-bottom: 1.5rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    #page-content .modern-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    #page-content .modern-card .card-header {
        background: linear-gradient(135deg, var(--bg-light) 0%, var(--secondary-color) 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
        border-radius: 16px 16px 0 0;
    }

    #page-content .modern-card .card-title {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    #page-content .modern-card .card-subtitle {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
        font-weight: 400;
    }

    #page-content .modern-card .card-body {
        padding: 2rem;
    }

    /* Enhanced Input Group Styling */
    #page-content .input-group-text {
        background: var(--secondary-color);
        border: 2px solid var(--border-color);
        border-right: none;
        color: var(--text-secondary);
        font-weight: 500;
        border-radius: 12px 0 0 12px;
        padding: 14px 16px;
    }

    #page-content .input-group .form-control {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }

    #page-content .input-group .form-control:focus {
        border-left: 2px solid var(--primary-color);
    }

    /* Enhanced Select Styling */
    #page-content select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px 12px;
        padding-right: 40px;
        appearance: none;
    }

    /* Enhanced Textarea Styling */
    #page-content textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Enhanced Small Text Styling */
    #page-content .text-muted {
        color: var(--text-muted) !important;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    /* Enhanced Info Tooltip */
    #page-content .info-tooltip {
        position: relative;
        display: inline-block;
        margin-left: 0.5rem;
    }

    #page-content .info-tooltip .tooltiptext {
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

    #page-content .info-tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

         /* Enhanced Row and Column Spacing */
     #page-content .row {
         margin-left: -0.75rem;
         margin-right: -0.75rem;
     }

     #page-content .col-md-6 {
         padding-left: 0.75rem;
         padding-right: 0.75rem;
     }

     /* Page Header Styles */
     .page-header {
         background: linear-gradient(135deg, var(--bg-light) 0%, var(--secondary-color) 100%);
         border-radius: 16px;
         padding: 2rem;
         border: 1px solid var(--border-color);
         margin-bottom: 2rem;
     }

     .page-title {
         color: var(--text-primary);
         font-weight: 700;
         font-size: 2rem;
         margin: 0;
         display: flex;
         align-items: center;
     }

     .page-subtitle {
         font-size: 1.1rem;
         margin-top: 0.5rem;
     }

     .header-actions .btn {
         border-radius: 12px;
         font-weight: 600;
         padding: 12px 24px;
     }

     

     /* Settings Sections */
     .settings-section {
         margin-bottom: 2rem;
     }

     .settings-section-title {
         color: var(--text-primary);
         font-weight: 600;
         font-size: 1.1rem;
         margin-bottom: 1.5rem;
         padding-bottom: 0.5rem;
         border-bottom: 2px solid var(--border-color);
     }

     .settings-items {
         display: flex;
         flex-direction: column;
         gap: 1rem;
     }

     .setting-item {
         background: var(--bg-light);
         border-radius: 12px;
         padding: 1rem;
         border: 1px solid var(--border-color);
         transition: all 0.3s ease;
     }

     .setting-item:hover {
         background: var(--bg-white);
         box-shadow: var(--shadow-sm);
     }

     .setting-item-content {
         display: flex;
         justify-content: space-between;
         align-items: center;
         gap: 1rem;
     }

     .setting-item-info {
         flex: 1;
     }

     .setting-item-title {
         font-weight: 600;
         color: var(--text-primary);
         margin: 0 0 0.25rem 0;
         font-size: 1rem;
     }

     .setting-item-description {
         color: var(--text-secondary);
         margin: 0;
         font-size: 0.9rem;
     }

     .setting-item-control {
         flex-shrink: 0;
     }

     /* Form Switch Styling */
     .form-switch {
         padding-left: 2.5rem;
     }

     .form-switch .form-check-input {
         width: 3rem;
         height: 1.5rem;
         margin-left: -2.5rem;
         background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
         background-position: left center;
         border-radius: 2rem;
         transition: background-position .15s ease-in-out;
     }

     .form-switch .form-check-input:focus {
         border-color: rgba(0, 0, 0, 0.25);
         box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.25);
     }

     .form-switch .form-check-input:checked {
         background-position: right center;
         background-color: var(--primary-color);
     }

     /* Header Badge */
     .header-badge .badge {
         font-size: 0.8rem;
         padding: 0.5rem 1rem;
         border-radius: 20px;
         font-weight: 600;
     }

           /* Verification Overview */
      .verification-overview {
          background: var(--bg-light);
          border-radius: 16px;
          padding: 2rem;
          border: 1px solid var(--border-color);
      }

     .verification-actions {
         text-align: center;
     }

     .action-buttons .btn {
         border-radius: 12px;
         font-weight: 600;
         padding: 12px 24px;
     }

     /* Verification Sidebar */
     .verification-sidebar {
         height: 100%;
     }

     .quick-info-card {
         background: var(--bg-white);
         border-radius: 12px;
         padding: 1.5rem;
         border: 1px solid var(--border-color);
         box-shadow: var(--shadow-sm);
     }

     .quick-info-title {
         color: var(--text-primary);
         font-weight: 600;
         margin-bottom: 1rem;
         font-size: 1rem;
     }

     .quick-info-list {
         list-style: none;
         padding: 0;
         margin: 0;
     }

     .quick-info-list li {
         padding: 0.5rem 0;
         color: var(--text-secondary);
         font-size: 0.9rem;
         display: flex;
         align-items: flex-start;
     }

     

     /* Enhanced Form Labels */
     .form-label {
         font-weight: 600;
         color: var(--text-primary);
         margin-bottom: 0.5rem;
         display: flex;
         align-items: center;
         font-size: 0.9rem;
     }

     .form-text {
         font-size: 0.85rem;
         margin-top: 0.5rem;
     }

     /* Responsive Design */
     @media (max-width: 768px) {
         .page-header {
             padding: 1.5rem;
         }

         .page-title {
             font-size: 1.5rem;
         }

         .header-actions {
             margin-top: 1rem;
             text-align: left;
         }

         .verification-overview {
             padding: 1.5rem;
         }

         .action-buttons .btn {
             margin-bottom: 0.5rem;
             width: 100%;
         }

         .setting-item-content {
             flex-direction: column;
             align-items: flex-start;
             gap: 1rem;
         }

         .setting-item-control {
             align-self: flex-end;
         }
     }
</style>
@endpush

@section('admin-content')
<div class="container-fluid fade-in">
    <div class="row">
        <div class="col-12">
            <!-- Business Setup Navigation -->
            <div class="business-setup-nav">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.business.setup.general') }}">
                            <i class="fas fa-cog"></i>
                            <span>General</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.business.setup.website-setup') }}">
                            <i class="fas fa-globe"></i>
                            <span>Website Setup</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.business.setup.sellers') }}">
                            <i class="fas fa-users"></i>
                            <span>Sellers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.business.setup.commission-setup') }}">
                            <i class="fas fa-percentage"></i>
                            <span>Commission Setup</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Sellers Content -->
            <div id="page-content">
                @include('admin.business.setup.tabs.sellers', ['activeTab' => 'sellers'])
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    initSellersPage();
});

function initSellersPage() {
    // Form submission
    $('form[data-form-type="sellers"]').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
        
        setTimeout(() => {
            submitBtn.prop('disabled', false).html(originalText);
            alert('Seller settings saved successfully!');
        }, 1500);
    });

    // Document configuration modal
    $('#configure-documents-btn').on('click', function() {
        loadDocumentRequirements();
        $('#documentConfigModal').modal('show');
    });

    // Load document requirements from API
    function loadDocumentRequirements() {
        $.ajax({
            url: '{{ route("admin.document-requirements.index") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#documentRequirementsTable').empty();
                    response.data.forEach(function(requirement) {
                        const row = createDocumentRequirementRow(requirement);
                        $('#documentRequirementsTable').append(row);
                    });
                }
            },
            error: function(xhr) {
                showToast('Error loading document requirements: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
            }
        });
    }

    // Add document requirement form submission
    $('#addDocumentRequirementForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Get form data
        const formData = {
            document_name: $('#document_name').val(),
            document_type: $('#document_type').val(),
            applicable_seller_types: $('#applicable_seller_types').val(),
            description: $('#description').val(),
            is_mandatory: $('#is_mandatory').is(':checked')
        };
        
        // Validate form
        if (!formData.document_name || !formData.document_type || !formData.applicable_seller_types) {
            alert('Please fill in all required fields');
            return;
        }
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Adding...');
        
        // Make API call
        $.ajax({
            url: '{{ route("admin.document-requirements.store") }}',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Add new row to table
                    const newRow = createDocumentRequirementRow(response.data);
                    $('#documentRequirementsTable').append(newRow);
                    
                    // Reset form
                    form[0].reset();
                    
                    showToast('Document requirement added successfully!', 'success');
                } else {
                    showToast('Error adding document requirement', 'error');
                }
            },
            error: function(xhr) {
                showToast('Error adding document requirement: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Delete document requirement
    $(document).on('click', '.delete-document-btn', function() {
        if (confirm('Are you sure you want to delete this document requirement?')) {
            const row = $(this).closest('tr');
            const documentId = row.data('document-id');
            
            $.ajax({
                url: '/admin/document-requirements/' + documentId,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        row.remove();
                        showToast('Document requirement deleted successfully!', 'success');
                    } else {
                        showToast('Error deleting document requirement', 'error');
                    }
                },
                error: function(xhr) {
                    showToast('Error deleting document requirement: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
                }
            });
        }
    });

    // Edit document requirement
    $(document).on('click', '.edit-document-btn', function() {
        const row = $(this).closest('tr');
        const documentName = row.find('td:first strong').text();
        const documentType = row.find('.badge.bg-primary').text();
        
        // Populate form for editing
        $('#document_name').val(documentName);
        $('#document_type').val(getDocumentTypeValue(documentType));
        
        // Show modal
        $('#documentConfigModal').modal('show');
    });
}

// Helper function to create document requirement row
function createDocumentRequirementRow(data) {
    const sellerTypes = data.applicable_seller_types.map(type => 
        `<span class="badge bg-secondary me-1">${getSellerTypeDisplay(type)}</span>`
    ).join('');
    
    const mandatoryBadge = data.is_mandatory ? '<span class="badge bg-warning ms-2">Mandatory</span>' : '';
    
    return `
        <tr data-document-id="${data.id}">
            <td>
                <strong>${data.document_name}</strong>${mandatoryBadge}
                <br><small class="text-muted">${data.description || ''}</small>
            </td>
            <td><span class="badge bg-primary">${getDocumentTypeDisplay(data.document_type)}</span></td>
            <td>${sellerTypes}</td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-primary edit-document-btn">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger delete-document-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
}

// Helper function to get document type display name
function getDocumentTypeDisplay(type) {
    const types = {
        'business_license': 'Business License',
        'gst_certificate': 'GST Certificate',
        'bis_hallmark_license': 'BIS Hallmark License',
        'gold_dealer_license': 'Gold Dealer License',
        'diamond_certification': 'Diamond Certification',
        'import_export_license': 'Import Export License',
        'gemological_certificates': 'Gemological Certificates',
        'identity_proof': 'Identity Proof',
        'address_proof': 'Address Proof',
        'bank_documents': 'Bank Documents'
    };
    return types[type] || type;
}

// Helper function to get document type value
function getDocumentTypeValue(displayName) {
    const types = {
        'Business License': 'business_license',
        'GST Certificate': 'gst_certificate',
        'BIS Hallmark License': 'bis_hallmark_license',
        'Gold Dealer License': 'gold_dealer_license',
        'Diamond Certification': 'diamond_certification',
        'Import Export License': 'import_export_license',
        'Gemological Certificates': 'gemological_certificates',
        'Identity Proof': 'identity_proof',
        'Address Proof': 'address_proof',
        'Bank Documents': 'bank_documents'
    };
    return types[displayName] || '';
}

// Helper function to get seller type display name
function getSellerTypeDisplay(type) {
    const types = {
        'gold_dealer': 'Gold Dealer',
        'diamond_dealer': 'Diamond Dealer',
        'general_jewelry': 'General Jewelry',
        'artisan_craftsman': 'Artisan/Craftsman',
        'platinum_dealer': 'Platinum Dealer',
        'silver_dealer': 'Silver Dealer',
        'gemstone_dealer': 'Gemstone Dealer',
        'watch_dealer': 'Watch Dealer',
        'antique_jewelry': 'Antique Jewelry',
        'costume_jewelry': 'Costume Jewelry'
    };
    return types[type] || type;
}

// Helper function to show toast notification
function showToast(message, type = 'info') {
    // You can implement a proper toast notification system here
    alert(message);
}
</script>
@endpush
