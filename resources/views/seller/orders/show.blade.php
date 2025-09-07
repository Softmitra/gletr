@extends('seller.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Order Details</h4>
                    <p class="text-muted mb-0">View and manage order information</p>
                </div>
                <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Order Management Coming Soon!</strong><br>
                        The complete order management system will be available in a future update. 
                        This includes order processing, fulfillment, tracking, and customer communication.
                    </div>

                    <!-- Order Summary Placeholder -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Order ID</h6>
                            <p class="mb-3">#ORD-000001</p>
                            
                            <h6 class="text-muted">Customer</h6>
                            <p class="mb-3">Sample Customer</p>
                            
                            <h6 class="text-muted">Order Date</h6>
                            <p class="mb-3">{{ now()->format('M d, Y H:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <span class="badge badge-warning mb-3">Pending</span>
                            
                            <h6 class="text-muted">Total Amount</h6>
                            <p class="mb-3"><strong>₹0.00</strong></p>
                            
                            <h6 class="text-muted">Payment Status</h6>
                            <span class="badge badge-info mb-3">Pending</span>
                        </div>
                    </div>

                    <!-- Order Items Placeholder -->
                    <hr>
                    <h6 class="mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        No order items available
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Order Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Order Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" disabled>
                            <i class="fas fa-edit"></i> Update Status
                        </button>
                        <button class="btn btn-info" disabled>
                            <i class="fas fa-shipping-fast"></i> Add Tracking
                        </button>
                        <button class="btn btn-success" disabled>
                            <i class="fas fa-file-invoice"></i> Generate Invoice
                        </button>
                        <button class="btn btn-warning" disabled>
                            <i class="fas fa-tag"></i> Shipping Label
                        </button>
                        <button class="btn btn-outline-danger" disabled>
                            <i class="fas fa-undo"></i> Process Refund
                        </button>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Customer Information</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-muted">Shipping Address</h6>
                    <p class="mb-3 text-muted">Address information will be displayed here</p>
                    
                    <h6 class="text-muted">Billing Address</h6>
                    <p class="mb-3 text-muted">Billing address will be displayed here</p>
                    
                    <h6 class="text-muted">Contact</h6>
                    <p class="mb-0 text-muted">Contact information will be displayed here</p>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Order Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Order Placed</h6>
                                <p class="text-muted mb-0 small">{{ now()->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    padding-left: 10px;
}

.d-grid {
    display: grid;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endpush
