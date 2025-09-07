@extends('layouts.admin')

@section('title', 'Customer List')

@section('page_title', 'Customer List')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.customers.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['active']) }}</h3>
                    <p>Active Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="{{ route('admin.customers.index', ['status' => 'active']) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['new_this_month']) }}</h3>
                    <p>New This Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ route('admin.customers.index', ['date_from' => now()->startOfMonth()->format('Y-m-d')]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['suspended'] + $stats['banned']) }}</h3>
                    <p>Inactive Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <a href="{{ route('admin.customers.index', ['status' => 'suspended']) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-2"></i>Customer Management
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-refresh mr-1"></i>Refresh
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Name, email, phone...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control status-dropdown">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times mr-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Customer Table -->
                        <div class="table-responsive">
                            <table class="table table-hover modern-table">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Last Login</th>
                                        <th>Orders</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $customer)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($customer->profile && $customer->profile->profile_picture)
                                                        <img src="{{ asset('storage/' . $customer->profile->profile_picture) }}" class="rounded-circle mr-2" width="40" height="40" alt="Profile">
                                                    @else
                                                        <img src="{{ asset('images/default-avatar.svg') }}" class="rounded-circle mr-2" width="40" height="40" alt="Profile">
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-dark font-weight-bold">
                                                            {{ $customer->name }}
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">{{ $customer->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($customer->profile && $customer->profile->phone)
                                                    <i class="fas fa-phone text-info mr-1"></i>{{ $customer->profile->phone }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($customer->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @elseif($customer->status == 'inactive')
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @elseif($customer->status == 'suspended')
                                                    <span class="badge badge-warning">Suspended</span>
                                                @elseif($customer->status == 'banned')
                                                    <span class="badge badge-danger">Banned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar text-primary mr-1"></i>
                                                {{ $customer->created_at->format('M d, Y') }}
                                            </td>
                                            <td>
                                                @if($customer->last_login_at)
                                                    <i class="fas fa-clock text-success mr-1"></i>
                                                    {{ $customer->last_login_at->diffForHumans() }}
                                                @else
                                                    <span class="text-muted">Never</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $customer->orders()->count() ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.customers.show', $customer) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       data-toggle="tooltip" 
                                                       data-placement="top" 
                                                       title="View Customer Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.customers.edit', $customer) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       data-toggle="tooltip" 
                                                       data-placement="top" 
                                                       title="Edit Customer">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="deleteCustomer({{ $customer->id }}, '{{ addslashes($customer->name) }}')" 
                                                            data-toggle="tooltip" 
                                                            data-placement="top" 
                                                            title="Delete Customer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No customers found</h5>
                                                    <p class="text-muted">Try adjusting your search criteria or check back later</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($customers->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $customers->appends(request()->query())->links() }}
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Customer</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteCustomerName"></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
/* Statistics Cards */
.small-box {
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, .1);
    transition: all .3s ease;
    border: none;
    overflow: hidden;
    position: relative;
}

.small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, .15);
}

.small-box .inner {
    padding: 20px;
}

.small-box .inner h3 {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.small-box .inner p {
    font-size: 1rem;
    font-weight: 500;
    opacity: 0.9;
}

.small-box .icon {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 3rem;
    opacity: 0.3;
}

.small-box-footer {
    background: rgba(0, 0, 0, .1);
    color: rgba(255, 255, 255, .8);
    text-decoration: none;
    padding: 10px 20px;
    display: block;
    transition: all .3s ease;
}

.small-box-footer:hover {
    background: rgba(0, 0, 0, .2);
    color: white;
    text-decoration: none;
}

/* Card Improvements */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
    padding: 20px;
}

.card-header h3 {
    margin: 0;
    font-weight: 600;
}

.card-body {
    padding: 25px;
}

/* Modern Table */
.modern-table {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
}

.modern-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.modern-table thead th {
    border: none;
    font-weight: 600;
    color: #ffffff !important;
    padding: 15px;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table tbody tr {
    border-bottom: 1px solid #f1f3f4;
    transition: all .2s ease;
}

.modern-table tbody tr:hover {
    background-color: #f8f9ff;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
}

.modern-table tbody td {
    padding: 15px;
    vertical-align: middle;
    border: none;
}

/* Profile Images */
.rounded-circle {
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
}

/* Badges */
.badge {
    padding: 8px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action Buttons */
.btn-group .btn {
    margin-right: 3px;
    border-radius: 8px;
    padding: 8px 12px;
    font-weight: 500;
    transition: all .2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
}

/* Form Controls */
.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 12px 15px;
    transition: all .3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, .25);
}

/* Status Dropdown Fix */
.status-dropdown {
    min-width: 140px;
    white-space: nowrap;
    overflow: visible;
}

.status-dropdown option {
    padding: 8px 12px;
    white-space: nowrap;
}

/* Filter Buttons */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    padding: 12px 25px;
    font-weight: 600;
    transition: all .3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, .4);
}

.btn-secondary {
    background: #6c757d;
    border: none;
    border-radius: 10px;
    padding: 12px 25px;
    font-weight: 600;
    transition: all .3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    padding: 40px 20px;
}

.empty-state i {
    opacity: 0.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .small-box .inner h3 {
        font-size: 1.8rem;
    }
    
    .small-box .icon {
        font-size: 2.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }

    .btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .btn-group .btn {
        margin-right: 0;
        flex: 1;
        min-width: auto;
    }
    
    .card-body {
        padding: 15px;
    }
    
    .status-dropdown {
        min-width: 120px;
    }
}

@media (max-width: 576px) {
    .col-lg-3 {
        margin-bottom: 15px;
    }
    
    .modern-table tbody td {
        padding: 10px 8px;
        font-size: 0.8rem;
    }
}
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Add loading state to buttons
    $('.btn').on('click', function() {
        const $btn = $(this);
        if (!$btn.hasClass('btn-secondary') && !$btn.hasClass('btn-danger')) {
            $btn.addClass('loading');
        }
    });
});

function deleteCustomer(id, name) {
    $('#deleteCustomerName').text(name);
    $('#deleteForm').attr('action', '{{ route("admin.customers.index") }}/' + id);
    $('#deleteModal').modal('show');
}

// Auto-submit form on filter change for better UX
$('select[name="status"]').on('change', function() {
    $(this).closest('form').submit();
});

// Enhanced search with debounce
let searchTimeout;
$('input[name="search"]').on('input', function() {
    clearTimeout(searchTimeout);
    const $form = $(this).closest('form');
    
    searchTimeout = setTimeout(function() {
        $form.submit();
    }, 500);
});

// Smooth animations for table rows
$(document).ready(function() {
    $('.modern-table tbody tr').each(function(index) {
        $(this).css('animation-delay', (index * 50) + 'ms');
        $(this).addClass('fade-in');
    });
});
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.loading {
    position: relative;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 16px;
    height: 16px;
    margin: -8px 0 0 -8px;
    border: 2px solid transparent;
    border-top: 2px solid #fff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush
