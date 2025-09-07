@extends('layouts.admin')

@section('title', 'Business Setup - Commission Setup')

@section('page_title', 'Business Setup - Commission Setup')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.business.setup') }}">Business Setup</a></li>
    <li class="breadcrumb-item active">Commission Setup</li>
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
                        <a class="nav-link" href="{{ route('admin.business.setup.sellers') }}">
                            <i class="fas fa-users"></i>
                            <span>Sellers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.business.setup.commission-setup') }}">
                            <i class="fas fa-percentage"></i>
                            <span>Commission Setup</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Commission Setup Content -->
            <div id="page-content">
                @include('admin.business.setup.tabs.commission-setup', ['activeTab' => 'commission-setup'])
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    initCommissionSetupPage();
});

function initCommissionSetupPage() {
    // Commission type change handler
    $('#commission_type').on('change', function() {
        const symbol = $(this).val() === 'percentage' ? '%' : '₹';
        $('.commission-symbol').text(symbol);
    });
    
    // Add new category commission row
    $('#add-category-commission').on('click', function() {
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
    $(document).on('click', '.remove-category-commission', function() {
        if ($('#category-commission-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('At least one category commission must be configured.');
        }
    });
}
</script>
@endpush
