@extends('seller.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Orders</h4>
                    <p class="text-muted mb-0">Manage your customer orders</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('seller.orders.export') }}" class="btn btn-outline-success">
                        <i class="fas fa-download"></i> Export Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_orders'] }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('seller.orders.index') }}" class="small-box-footer">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending_orders'] }}</h3>
                    <p>Pending Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}" class="small-box-footer">
                    View Pending <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['processing_orders'] }}</h3>
                    <p>Processing</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <a href="{{ route('seller.orders.index', ['status' => 'processing']) }}" class="small-box-footer">
                    View Processing <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>₹{{ number_format($stats['total_revenue'], 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <a href="{{ route('seller.orders.analytics') }}" class="small-box-footer">
                    View Analytics <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('seller.orders.index') }}" class="row align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search Orders</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Order ID, customer name...">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-secondary ml-2">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Order List</h5>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="bulk-actions-btn" style="display: none;">
                                <i class="fas fa-tasks"></i> Bulk Actions
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="select-all">
                                                <label class="custom-control-label" for="select-all"></label>
                                            </div>
                                        </th>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- TODO: Loop through orders when Order model is available -->
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">No orders found</h6>
                                            <p class="text-muted mb-3">Orders will appear here when customers place them.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="card-footer bg-white border-top" id="bulk-actions" style="display: none;">
                            <form method="POST" action="{{ route('seller.orders.bulk-action') }}" id="bulk-form">
                                @csrf
                                <div class="d-flex align-items-center">
                                    <span class="mr-3">With selected orders:</span>
                                    <select name="action" class="form-control form-control-sm mr-2" style="width: auto;">
                                        <option value="">Choose Action</option>
                                        <option value="mark_processing">Mark as Processing</option>
                                        <option value="mark_shipped">Mark as Shipped</option>
                                        <option value="mark_delivered">Mark as Delivered</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                                </div>
                            </form>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="card-footer bg-white border-top">
                            {{ $orders->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted mb-3">No orders yet</h5>
                            <p class="text-muted mb-4">Orders from customers will appear here. Make sure your products are active and visible.</p>
                            <a href="{{ route('seller.products.index') }}" class="btn btn-primary">
                                <i class="fas fa-boxes"></i> Manage Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAll = document.getElementById('select-all');
    const orderCheckboxes = document.querySelectorAll('input[name="order_ids[]"]');
    const bulkActions = document.getElementById('bulk-actions');
    const bulkActionsBtn = document.getElementById('bulk-actions-btn');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });
    }

    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });

    function toggleBulkActions() {
        const checkedBoxes = document.querySelectorAll('input[name="order_ids[]"]:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'block';
            bulkActionsBtn.style.display = 'inline-block';
        } else {
            bulkActions.style.display = 'none';
            bulkActionsBtn.style.display = 'none';
        }
    }

    // Bulk form submission
    const bulkForm = document.getElementById('bulk-form');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const action = this.querySelector('select[name="action"]').value;
            const checkedBoxes = document.querySelectorAll('input[name="order_ids[]"]:checked');
            
            if (!action) {
                e.preventDefault();
                alert('Please select an action');
                return;
            }

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one order');
                return;
            }

            // Add selected order IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });

            if (!confirm(`Are you sure you want to ${action.replace('mark_', '').replace('_', ' ')} the selected orders?`)) {
                e.preventDefault();
            }
        });
    }

    // Auto-refresh orders every 30 seconds (optional)
    // setInterval(function() {
    //     if (!document.hidden) {
    //         window.location.reload();
    //     }
    // }, 30000);
});
</script>
@endpush