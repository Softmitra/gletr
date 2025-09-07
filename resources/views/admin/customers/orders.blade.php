@extends('layouts.admin')

@section('title', 'Customer Orders - ' . $customer->name)

@section('page_title', 'Customer Orders')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a></li>
    <li class="breadcrumb-item active">Orders</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Customer Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-info">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        @if($customer->profile && $customer->profile->profile_picture)
                            <img src="{{ asset('storage/' . $customer->profile->profile_picture) }}" class="rounded-circle mr-3" width="60" height="60" alt="Profile">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}" class="rounded-circle mr-3" width="60" height="60" alt="Profile">
                        @endif
                        <div>
                            <h3 class="mb-1">{{ $customer->name }}'s Orders</h3>
                            <p class="mb-0">{{ $customer->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-cart mr-2"></i>Order History ({{ $orders->total() }})
                        </h5>
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Customer
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <strong>#{{ $order->id }}</strong>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar text-primary mr-1"></i>
                                                {{ $order->created_at->format('M d, Y') }}
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                @if($order->items->count() > 0)
                                                    <span class="badge badge-info">{{ $order->items->count() }} items</span>
                                                    <br>
                                                    <small class="text-muted">
                                                        @foreach($order->items->take(2) as $item)
                                                            {{ $item->product->name ?? 'Product' }}@if(!$loop->last), @endif
                                                        @endforeach
                                                        @if($order->items->count() > 2)
                                                            <br>+{{ $order->items->count() - 2 }} more
                                                        @endif
                                                    </small>
                                                @else
                                                    <span class="text-muted">No items</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-success">₹{{ number_format($order->grand_total ?? 0, 2) }}</strong>
                                            </td>
                                            <td>
                                                @switch($order->status ?? 'pending')
                                                    @case('pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge badge-info">Confirmed</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge badge-primary">Processing</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="badge badge-secondary">Shipped</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge badge-success">Delivered</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge badge-danger">Cancelled</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-light">Unknown</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($order->payment)
                                                    @switch($order->payment->status ?? 'pending')
                                                        @case('paid')
                                                            <span class="badge badge-success">Paid</span>
                                                            @break
                                                        @case('pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                            @break
                                                        @case('failed')
                                                            <span class="badge badge-danger">Failed</span>
                                                            @break
                                                        @default
                                                            <span class="badge badge-light">Unknown</span>
                                                    @endswitch
                                                    <br>
                                                    <small class="text-muted">{{ ucfirst($order->payment->method ?? 'N/A') }}</small>
                                                @else
                                                    <span class="text-muted">No payment</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info" onclick="viewOrder({{ $order->id }})" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning" onclick="editOrder({{ $order->id }})" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Orders Found</h5>
                            <p class="text-muted">This customer hasn't placed any orders yet.</p>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left mr-1"></i>Back to Customer
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 0 1rem rgba(0, 0, 0, .125);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    margin-right: 5px;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }

    .btn-group {
        display: flex;
        flex-direction: column;
    }

    .btn-group .btn {
        margin-right: 0;
        margin-bottom: 5px;
        border-radius: 5px;
    }
}
</style>
@endpush

@push('js')
<script>
function viewOrder(orderId) {
    // Placeholder for view order functionality
    Swal.fire({
        icon: 'info',
        title: 'Order Details',
        text: 'Order details view will be implemented soon.',
        confirmButtonColor: '#007bff'
    });
}

function editOrder(orderId) {
    // Placeholder for edit order functionality
    Swal.fire({
        icon: 'info',
        title: 'Edit Order',
        text: 'Order editing functionality will be implemented soon.',
        confirmButtonColor: '#007bff'
    });
}
</script>
@endpush
