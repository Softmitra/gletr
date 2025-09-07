@extends('seller.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Modern Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white rounded-lg shadow-sm p-4">
                <div>
                    <h2 class="mb-1 font-weight-bold text-dark">Good {{ now()->format('H') < 12 ? 'Morning' : (now()->format('H') < 17 ? 'Afternoon' : 'Evening') }}, {{ $seller->name }}! 👋</h2>
                    <p class="text-muted mb-0">Here's what's happening with your jewelry store today</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="refreshStats()">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                    <a href="{{ route('seller.products.create') }}" class="btn btn-primary btn-sm rounded-pill">
                        <i class="fas fa-plus me-1"></i> Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Alert -->
    @if(!$seller->isFullyVerified())
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning border-0 rounded-lg shadow-sm" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                <div class="d-flex align-items-center">
                    <div class="alert-icon me-3">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1">Complete Your Verification</h5>
                        <p class="mb-2">Unlock all features and start selling by completing your account verification.</p>
                        <a href="{{ route('seller.verification.status') }}" class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-check-circle me-1"></i> Complete Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modern Stats Cards -->
    <div class="row mb-4">
        <!-- Total Revenue -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Revenue</p>
                            <h3 class="mb-0 font-weight-bold">₹{{ number_format($stats['total_revenue'] ?? 0, 0) }}</h3>
                            <small class="opacity-75">
                                <i class="fas fa-arrow-up me-1"></i> +12% from last month
                            </small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-rupee-sign fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Products</p>
                            <h3 class="mb-0 font-weight-bold">{{ $stats['total_products'] ?? 0 }}</h3>
                            <small class="opacity-75">
                                <i class="fas fa-gem me-1"></i> {{ $stats['active_products'] ?? 0 }} active
                            </small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-gem fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Orders</p>
                            <h3 class="mb-0 font-weight-bold">{{ $stats['total_orders'] ?? 0 }}</h3>
                            <small class="opacity-75">
                                <i class="fas fa-clock me-1"></i> {{ $stats['pending_orders'] ?? 0 }} pending
                            </small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">This Month</p>
                            <h3 class="mb-0 font-weight-bold">₹{{ number_format($stats['this_month_revenue'] ?? 0, 0) }}</h3>
                            <small class="opacity-75">
                                <i class="fas fa-calendar me-1"></i> {{ now()->format('M Y') }}
                            </small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-chart-line fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jewelry Business Widgets -->
    <div class="row mb-4">
        <!-- Live Rates -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-coins text-warning me-2"></i>Live Precious Metal Rates
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="rate-item">
                                    <h4 class="text-warning mb-1">₹5,850</h4>
                                    <p class="text-muted mb-1">24K Gold/gm</p>
                                    <span class="badge bg-success rounded-pill">
                                        <i class="fas fa-arrow-up"></i> +2.3%
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rate-item">
                                <h4 class="text-secondary mb-1">₹68,500</h4>
                                <p class="text-muted mb-1">Silver/kg</p>
                                <span class="badge bg-warning rounded-pill">
                                    <i class="fas fa-minus"></i> 0.0%
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Last updated: {{ now()->format('H:i A') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-primary me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('seller.products.create') }}" class="btn btn-outline-primary rounded-pill">
                            <i class="fas fa-plus me-2"></i>Add New Jewelry
                        </a>
                        <a href="{{ route('seller.orders.index') }}?status=pending" class="btn btn-outline-warning rounded-pill">
                            <i class="fas fa-clock me-2"></i>Process Orders ({{ $stats['pending_orders'] ?? 0 }})
                        </a>
                        <a href="{{ route('seller.store.show') }}" class="btn btn-outline-info rounded-pill">
                            <i class="fas fa-store me-2"></i>Manage Store
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Alerts -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card border-0 rounded-lg shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Inventory Alerts
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0 rounded-lg mb-2 py-2">
                        <i class="fas fa-gem me-2"></i>
                        <small>3 Diamond items running low</small>
                    </div>
                    <div class="alert alert-info border-0 rounded-lg mb-2 py-2">
                        <i class="fas fa-ring me-2"></i>
                        <small>Wedding season - High demand</small>
                    </div>
                    <div class="alert alert-success border-0 rounded-lg mb-0 py-2">
                        <i class="fas fa-certificate me-2"></i>
                        <small>All certificates up to date</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 rounded-lg shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shopping-bag text-primary me-2"></i>Recent Orders
                    </h5>
                    <a href="{{ route('seller.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-4">Order</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0">Product</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Amount</th>
                                    <th class="border-0 pe-4">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('seller.orders.show', $order) }}" class="text-decoration-none fw-bold">
                                            #{{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title bg-primary text-white rounded-circle">
                                                    {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <span>{{ $order->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->items->count() > 0)
                                            <span class="fw-medium">{{ Str::limit($order->items->first()->product->name ?? 'N/A', 20) }}</span>
                                            @if($order->items->count() > 1)
                                                <br><small class="text-muted">+{{ $order->items->count() - 1 }} more items</small>
                                            @endif
                                        @else
                                            <span class="text-muted">No items</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'pending' => ['class' => 'warning', 'icon' => 'clock'],
                                                'confirmed' => ['class' => 'info', 'icon' => 'check'],
                                                'processing' => ['class' => 'primary', 'icon' => 'cog'],
                                                'shipped' => ['class' => 'secondary', 'icon' => 'truck'],
                                                'delivered' => ['class' => 'success', 'icon' => 'check-circle'],
                                                'cancelled' => ['class' => 'danger', 'icon' => 'times']
                                            ];
                                            $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                        @endphp
                                        <span class="badge bg-{{ $config['class'] }} rounded-pill">
                                            <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">₹{{ number_format($order->grand_total, 2) }}</td>
                                    <td class="pe-4 text-muted">{{ $order->created_at->format('M d') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">No orders yet</h6>
                                            <p class="text-muted">Start promoting your jewelry to get your first order!</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics & Categories -->
        <div class="col-lg-4">
            <!-- Top Categories -->
            <div class="card border-0 rounded-lg shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i>Top Categories
                    </h5>
                </div>
                <div class="card-body">
                    <div class="category-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-medium">💍 Rings</span>
                            <span class="text-muted">45%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary rounded" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="category-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-medium">📿 Necklaces</span>
                            <span class="text-muted">28%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success rounded" style="width: 28%"></div>
                        </div>
                    </div>
                    <div class="category-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-medium">👂 Earrings</span>
                            <span class="text-muted">35%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning rounded" style="width: 35%"></div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-medium">📿 Bracelets</span>
                            <span class="text-muted">12%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info rounded" style="width: 12%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="card border-0 rounded-lg shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line text-info me-2"></i>Performance
                    </h5>
                </div>
                <div class="card-body">
                    <div class="metric-item d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted">Avg. Order Value</span>
                            <h6 class="mb-0">₹{{ number_format(($stats['total_revenue'] ?? 0) / max(($stats['total_orders'] ?? 1), 1), 0) }}</h6>
                        </div>
                        <i class="fas fa-arrow-up text-success"></i>
                    </div>
                    <div class="metric-item d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted">Conversion Rate</span>
                            <h6 class="mb-0">3.2%</h6>
                        </div>
                        <i class="fas fa-arrow-up text-success"></i>
                    </div>
                    <div class="metric-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">Customer Rating</span>
                            <h6 class="mb-0">4.8 ⭐</h6>
                        </div>
                        <i class="fas fa-arrow-up text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
/* Modern Dashboard Styles */
* {
    font-family: "Spline Sans", "Noto Sans", sans-serif !important;
}

.rounded-lg {
    border-radius: 1rem !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.stats-icon {
    opacity: 0.3;
}

.avatar-sm {
    width: 2rem;
    height: 2rem;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.rate-item h4 {
    font-weight: 700;
}

.category-item .progress {
    border-radius: 1rem;
}

.metric-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.metric-item:last-child {
    border-bottom: none;
}

.empty-state {
    padding: 2rem;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.2s ease-in-out;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.alert {
    border-radius: 0.75rem !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
    }
    
    .btn-sm {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@push('js')
<script>
function refreshStats() {
    const btn = event.target.closest('button');
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Refreshing...';
    btn.disabled = true;
    
    // Simulate refresh
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Auto-refresh every 5 minutes
setInterval(() => {
    console.log('Auto-refreshing stats...');
}, 300000);

// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on load
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush