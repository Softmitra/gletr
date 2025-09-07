@extends('seller.layouts.app')

@section('title', 'My Store')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">My Store</h4>
                    <p class="text-muted mb-0">Manage your store information and settings</p>
                </div>
                <a href="{{ route('seller.store.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Store
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Store Information -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Store Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Business Name:</strong></td>
                                    <td>{{ $seller->business_name ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Business Type:</strong></td>
                                    <td>{{ $seller->business_type ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Owner Name:</strong></td>
                                    <td>{{ $seller->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $seller->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $seller->phone ?? 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Seller Type:</strong></td>
                                    <td>{{ $seller->sellerType->name ?? 'Not assigned' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Registration Date:</strong></td>
                                    <td>{{ $seller->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Store Status:</strong></td>
                                    <td>
                                        @php
                                            $storeStatus = $store_settings['store_status'] ?? 'active';
                                        @endphp
                                        <span class="badge badge-{{ $storeStatus === 'active' ? 'success' : ($storeStatus === 'inactive' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($storeStatus) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Verification Status:</strong></td>
                                    <td>
                                        @if($seller->isFullyVerified())
                                            <span class="badge badge-success">Verified</span>
                                        @elseif($seller->hasDocumentsVerified())
                                            <span class="badge badge-primary">Documents Verified</span>
                                        @elseif($seller->isPendingVerification())
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($seller->business_description)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6>Business Description</h6>
                            <p class="text-muted">{{ $seller->business_description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Store Statistics -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Store Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="text-primary">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <h4 class="mb-0">{{ $store_stats['total_products'] }}</h4>
                                <small class="text-muted">Total Products</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-success">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <h4 class="mb-0">{{ $store_stats['active_products'] }}</h4>
                                <small class="text-muted">Active Products</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-warning">
                                <i class="fas fa-edit fa-2x mb-2"></i>
                                <h4 class="mb-0">{{ $store_stats['draft_products'] }}</h4>
                                <small class="text-muted">Draft Products</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-danger">
                                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                <h4 class="mb-0">{{ $store_stats['out_of_stock'] }}</h4>
                                <small class="text-muted">Out of Stock</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Store Management</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('seller.store.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit Store Info
                        </a>
                        <a href="{{ route('seller.store.settings') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-cog"></i> Store Settings
                        </a>
                        <a href="{{ route('seller.store.branding') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-palette"></i> Store Branding
                        </a>
                        <hr class="my-2">
                        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="alert('Product management coming soon!')">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="alert('Product management coming soon!')">
                            <i class="fas fa-boxes"></i> Manage Products
                        </a>
                    </div>
                </div>
            </div>

            <!-- Store Settings Summary -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Current Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Store Status:</small><br>
                        <strong>{{ ucfirst($store_settings['store_status'] ?? 'Active') }}</strong>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Reviews:</small><br>
                        <strong>{{ ($store_settings['allow_reviews'] ?? true) ? 'Enabled' : 'Disabled' }}</strong>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Auto Accept Orders:</small><br>
                        <strong>{{ ($store_settings['auto_accept_orders'] ?? false) ? 'Yes' : 'No' }}</strong>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Processing Time:</small><br>
                        <strong>{{ $store_settings['processing_time'] ?? '1-2 business days' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.d-grid {
    display: grid;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endpush
