@extends('layouts.admin')

@section('title', 'Seller Management')

@section('page_title', 'Seller Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Sellers</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_sellers'] ?? 0 }}</h3>
                    <p>Total Sellers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-store"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['active_sellers'] ?? 0 }}</h3>
                    <p>Active Sellers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending_sellers'] ?? 0 }}</h3>
                    <p>Pending Approval</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['suspended_sellers'] ?? 0 }}</h3>
                    <p>Suspended</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ban"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['verified_sellers'] ?? 0 }}</h3>
                    <p>Verified</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['new_sellers_today'] ?? 0 }}</h3>
                    <p>New Today</p>
                </div>
                <div class="icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filters & Search</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.sellers.index') }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Name, Email or Business">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="verification_status">Verification</label>
                        <select class="form-control" id="verification_status" name="verification_status">
                            <option value="">All</option>
                            <option value="verified" {{ request('verification_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="pending" {{ request('verification_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ request('verification_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="business_type">Business Type</label>
                        <select class="form-control" id="business_type" name="business_type">
                            <option value="">All Types</option>
                            <option value="individual" {{ request('business_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="partnership" {{ request('business_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="private_limited" {{ request('business_type') == 'private_limited' ? 'selected' : '' }}>Private Limited</option>
                            <option value="public_limited" {{ request('business_type') == 'public_limited' ? 'selected' : '' }}>Public Limited</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_from">From Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sellers Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sellers List</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#bulkActionModal">
                    <i class="fas fa-tasks"></i> Bulk Actions
                </button>
                <a href="{{ route('admin.sellers.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Add Seller
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>Seller</th>
                        <th>Business</th>
                        <th>Status</th>
                        <th>Verification</th>
                        <th>Products</th>
                        <th>Orders</th>
                        <th>Commission</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                    <tr>
                        <td>
                            <input type="checkbox" class="seller-select" value="{{ $seller->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm mr-3">
                                    @if($seller->image)
                                        <img src="{{ asset('storage/' . $seller->image) }}" 
                                             alt="{{ $seller->f_name }}" class="avatar-title rounded-circle">
                                    @else
                                        <div class="avatar-title bg-primary rounded-circle">
                                            {{ strtoupper(substr($seller->f_name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ $seller->f_name }} {{ $seller->l_name }}</div>
                                    <div class="text-muted small">{{ $seller->email }}</div>
                                    <div class="text-muted small">{{ $seller->country_code }}{{ $seller->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="font-weight-bold">{{ $seller->business_type_display }}</div>
                                @if($seller->gst_number)
                                    <div class="text-muted small">GST: {{ $seller->gst_number }}</div>
                                @endif
                                @if($seller->pan_number)
                                    <div class="text-muted small">PAN: {{ $seller->pan_number }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $seller->status == 'active' ? 'success' : ($seller->status == 'pending' ? 'warning' : 'danger') }}">
                                <i class="fas fa-{{ $seller->status == 'active' ? 'check-circle' : ($seller->status == 'pending' ? 'clock' : 'ban') }}"></i>
                                {{ ucfirst($seller->status) }}
                            </span>
                        </td>
                        <td>
                            @if($seller->verification_status)
                                <span class="badge badge-{{ $seller->verification_status == 'verified' ? 'success' : ($seller->verification_status == 'pending' ? 'warning' : 'danger') }}">
                                    <i class="fas fa-{{ $seller->verification_status == 'verified' ? 'shield-alt' : ($seller->verification_status == 'pending' ? 'clock' : 'times') }}"></i>
                                    {{ ucfirst($seller->verification_status) }}
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-minus"></i>
                                    Not Started
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-info">
                                <i class="fas fa-box"></i>
                                {{ $seller->product()->count() }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-primary">
                                <i class="fas fa-shopping-cart"></i>
                                {{ $seller->orders_count }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-secondary">
                                <i class="fas fa-percentage"></i>
                                {{ $seller->sales_commission_percentage ?? 0 }}%
                            </span>
                        </td>
                        <td>
                            <div class="text-muted small">
                                {{ $seller->created_at->format('M d, Y') }}
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.sellers.show', $seller->id) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.sellers.edit', $seller->id) }}" 
                                   class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($seller->status == 'active')
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            onclick="suspendSeller({{ $seller->id }})" title="Suspend">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                @elseif($seller->status == 'suspended')
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="activateSeller({{ $seller->id }})" title="Activate">
                                        <i class="fas fa-play"></i>
                                    </button>
                                @endif
                                @if($seller->status == 'pending')
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="approveSeller({{ $seller->id }})" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-store fa-3x mb-3"></i>
                                <h5>No sellers found</h5>
                                <p>No sellers match your current filters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $sellers->links() }}
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="bulk_action">Select Action</label>
                    <select class="form-control" id="bulk_action">
                        <option value="">Choose an action...</option>
                        <option value="activate">Activate Selected</option>
                        <option value="suspend">Suspend Selected</option>
                        <option value="approve">Approve Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="performBulkAction()">Apply Action</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function() {
    // Select all functionality
    $('#select-all').change(function() {
        $('.seller-select').prop('checked', $(this).is(':checked'));
    });

    // Update select all when individual checkboxes change
    $('.seller-select').change(function() {
        if (!$(this).is(':checked')) {
            $('#select-all').prop('checked', false);
        } else {
            var allChecked = $('.seller-select:checked').length === $('.seller-select').length;
            $('#select-all').prop('checked', allChecked);
        }
    });
});

function suspendSeller(sellerId) {
    if (confirm('Are you sure you want to suspend this seller?')) {
        $.ajax({
            url: `/admin/sellers/${sellerId}/suspend`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error suspending seller');
            }
        });
    }
}

function activateSeller(sellerId) {
    if (confirm('Are you sure you want to activate this seller?')) {
        $.ajax({
            url: `/admin/sellers/${sellerId}/activate`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error activating seller');
            }
        });
    }
}

function approveSeller(sellerId) {
    if (confirm('Are you sure you want to approve this seller?')) {
        $.ajax({
            url: `/admin/sellers/${sellerId}/approve`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error approving seller');
            }
        });
    }
}

function performBulkAction() {
    var action = $('#bulk_action').val();
    var selectedSellers = $('.seller-select:checked').map(function() {
        return $(this).val();
    }).get();

    if (!action) {
        alert('Please select an action');
        return;
    }

    if (selectedSellers.length === 0) {
        alert('Please select at least one seller');
        return;
    }

    if (confirm(`Are you sure you want to ${action} the selected sellers?`)) {
        $.ajax({
            url: '/admin/sellers/bulk-action',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: action,
                sellers: selectedSellers
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error performing bulk action');
            }
        });
    }
}
</script>
@endsection
