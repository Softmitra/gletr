@extends('layouts.admin')

@section('title', 'Seller Products')

@section('page_title', 'Products - ' . $seller->f_name . ' ' . $seller->l_name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.show', $seller) }}">{{ $seller->f_name }} {{ $seller->l_name }}</a></li>
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <!-- Seller Navigation -->
        <div class="col-md-3">
            <x-seller-navigation :seller="$seller" active-route="admin.sellers.products" />
        </div>
        
        <!-- Products Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-box"></i> Products
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">{{ $products->total() }} Total Products</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    @if($product->thumbnail)
                                                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->sku ?? 'N/A' }}</td>
                                        <td>
                                            @if($product->category)
                                                <span class="badge badge-secondary">{{ $product->category->name }}</span>
                                            @else
                                                <span class="text-muted">Uncategorized</span>
                                            @endif
                                        </td>
                                        <td>₹{{ number_format($product->price, 2) }}</td>
                                        <td>
                                            @if($product->status === 'active')
                                                <span class="badge badge-success">Active</span>
                                            @elseif($product->status === 'inactive')
                                                <span class="badge badge-secondary">Inactive</span>
                                            @else
                                                <span class="badge badge-warning">{{ ucfirst($product->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($products->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $products->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Products</h5>
                            <p class="text-muted">This seller hasn't added any products yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
