@props(['seller', 'activeRoute' => null])

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-store me-2"></i> Seller Navigation
        </h3>
    </div>
    <div class="card-body p-2">
        <nav class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <!-- Seller Info -->
            <div class="nav-item mb-3 p-3 bg-light">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm me-3">
                        <div class="avatar-title bg-primary text-white rounded-circle">
                            {{ strtoupper(substr($seller->f_name, 0, 1) . substr($seller->l_name, 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $seller->f_name }} {{ $seller->l_name }}</h6>
                        <small class="text-muted">{{ $seller->business_name ?? 'Individual Seller' }}</small>
                    </div>
                </div>
            </div>

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.show', $seller) }}" 
                   class="nav-link {{ $activeRoute === 'admin.sellers.show' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Products -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.products', $seller) }}" 
                   class="nav-link {{ str_contains($activeRoute ?? '', 'products') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-box"></i>
                    <p>
                                                 Products
                         <span class="badge badge-info right">{{ $seller->product()->count() }}</span>
                    </p>
                </a>
            </li>

            <!-- Orders -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.orders', $seller) }}" 
                   class="nav-link {{ str_contains($activeRoute ?? '', 'orders') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Orders
                        <span class="badge badge-success right">{{ $seller->orders_count }}</span>
                    </p>
                </a>
            </li>

            <!-- Team Management -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.team', $seller) }}" 
                   class="nav-link {{ str_contains($activeRoute ?? '', 'team') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Team Members
                        <span class="badge badge-primary right">{{ $seller->activeTeamMembers()->count() }}</span>
                    </p>
                </a>
            </li>

            <!-- Analytics -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.analytics', $seller) }}" 
                   class="nav-link {{ str_contains($activeRoute ?? '', 'analytics') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Analytics</p>
                </a>
            </li>

            <!-- Payments -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.payments', $seller) }}" 
                   class="nav-link {{ str_contains($activeRoute ?? '', 'payments') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-credit-card"></i>
                    <p>Payments</p>
                </a>
            </li>

            <!-- Reviews -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.reviews', $seller) }}" 
                   class="nav-link {{ str_contains($activeRoute ?? '', 'reviews') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-star"></i>
                    <p>Reviews</p>
                </a>
            </li>

            <!-- Settings -->
            <li class="nav-item">
                <a href="{{ route('admin.sellers.settings', $seller) }}" 
                   class="nav-link {{ str_contains($activeRoute ?? '', 'settings') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>Settings</p>
                </a>
            </li>

            <!-- Divider -->
            <hr class="my-2">

            <!-- Admin Actions -->
            <li class="nav-header">ADMIN ACTIONS</li>
            
            <li class="nav-item">
                <a href="{{ route('admin.sellers.edit', $seller) }}" 
                   class="nav-link {{ $activeRoute === 'admin.sellers.edit' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>Edit Seller</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.sellers.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-arrow-left"></i>
                    <p>Back to Sellers</p>
                </a>
            </li>

            <!-- Status Actions -->
            <li class="nav-item">
                @if($seller->status === 'active')
                    <a href="#" onclick="suspendSeller({{ $seller->id }})" class="nav-link text-warning">
                        <i class="nav-icon fas fa-pause"></i>
                        <p>Suspend Seller</p>
                    </a>
                @else
                    <a href="#" onclick="activateSeller({{ $seller->id }})" class="nav-link text-success">
                        <i class="nav-icon fas fa-play"></i>
                        <p>Activate Seller</p>
                    </a>
                @endif
            </li>

            @if($seller->verification_status === 'pending')
            <li class="nav-item">
                <a href="#" onclick="approveSeller({{ $seller->id }})" class="nav-link text-info">
                    <i class="nav-icon fas fa-check"></i>
                    <p>Approve Seller</p>
                </a>
            </li>
            @endif
        </nav>
    </div>
</div>

<style>
.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
}

.nav-sidebar .nav-link {
    padding: 0.75rem 1rem;
    margin-bottom: 0.25rem;
    border-radius: 0.375rem;
    color: #374151 !important;
    text-decoration: none;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.nav-sidebar .nav-link:hover {
    background-color: #e5e7eb;
    color: #1f2937 !important;
    transform: translateX(2px);
}

.nav-sidebar .nav-link.active {
    background-color: #3b82f6;
    color: white !important;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

.nav-sidebar .nav-link.active .nav-icon {
    color: white !important;
}

.nav-sidebar .nav-link.active p {
    color: white !important;
}

.nav-sidebar .nav-link p {
    margin: 0;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.nav-sidebar .nav-link .nav-icon {
    color: #6b7280;
    width: 1.25rem;
    text-align: center;
}

.nav-sidebar .nav-link:hover .nav-icon {
    color: #374151;
}

.nav-sidebar .nav-link.active .nav-icon {
    color: white !important;
}

.nav-sidebar .nav-link .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-weight: 600;
}

.nav-sidebar .nav-link.active .badge {
    background-color: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
}

.nav-header {
    padding: 0.75rem 1rem 0.5rem 1rem;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 0.5rem;
}

.nav-sidebar .nav-link.text-warning {
    color: #d97706 !important;
}

.nav-sidebar .nav-link.text-warning:hover {
    background-color: #fef3c7;
    color: #92400e !important;
}

.nav-sidebar .nav-link.text-success {
    color: #059669 !important;
}

.nav-sidebar .nav-link.text-success:hover {
    background-color: #d1fae5;
    color: #065f46 !important;
}

.nav-sidebar .nav-link.text-info {
    color: #0891b2 !important;
}

.nav-sidebar .nav-link.text-info:hover {
    background-color: #cffafe;
    color: #0e7490 !important;
}

/* Seller info section styling */
.nav-item.mb-3.p-3.bg-light {
    background-color: #f9fafb !important;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    margin: 0 0.5rem 1rem 0.5rem;
}

.nav-item.mb-3.p-3.bg-light h6 {
    color: #1f2937;
    font-weight: 600;
}

.nav-item.mb-3.p-3.bg-light small {
    color: #6b7280;
}

/* Divider styling */
hr.my-2 {
    border-color: #e5e7eb;
    margin: 1rem 0.5rem;
}
</style>
