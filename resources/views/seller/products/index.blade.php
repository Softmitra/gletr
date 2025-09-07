@extends('seller.layouts.app')

@section('title', 'Products')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Products</h4>
                    <p class="text-muted mb-0">Manage your product inventory</p>
                </div>
                <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Product
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_products'] }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['active_products'] }}</h3>
                    <p>Active Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['draft_products'] }}</h3>
                    <p>Draft Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['out_of_stock'] }}</h3>
                    <p>Out of Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('seller.products.index') }}" class="row align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search Products</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Product name, SKU...">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">All Categories</option>
                                <!-- TODO: Load categories when available -->
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort" class="form-label">Sort By</label>
                            <select class="form-control" id="sort" name="sort">
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date Created</option>
                                <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Price</option>
                                <option value="stock" {{ request('sort') === 'stock' ? 'selected' : '' }}>Stock</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary ml-2">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Product List</h5>
                        <div class="btn-group">
                            <a href="{{ route('seller.products.import') }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-upload"></i> Import
                            </a>
                            <a href="{{ route('seller.products.export') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-download"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($products->count() > 0)
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
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- TODO: Loop through products when Product model is available -->
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">No products found</h6>
                                            <p class="text-muted mb-3">Start by adding your first product to your store.</p>
                                            <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add Your First Product
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="card-footer bg-white border-top" id="bulk-actions" style="display: none;">
                            <form method="POST" action="{{ route('seller.products.bulk-action') }}" id="bulk-form">
                                @csrf
                                <div class="d-flex align-items-center">
                                    <span class="mr-3">With selected:</span>
                                    <select name="action" class="form-control form-control-sm mr-2" style="width: auto;">
                                        <option value="">Choose Action</option>
                                        <option value="activate">Activate</option>
                                        <option value="deactivate">Deactivate</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                                </div>
                            </form>
                        </div>

                        <!-- Pagination -->
                        @if($products->hasPages())
                        <div class="card-footer bg-white border-top">
                            {{ $products->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted mb-3">No products yet</h5>
                            <p class="text-muted mb-4">You haven't added any products to your store yet. Start by creating your first product.</p>
                            <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Your First Product
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
    const productCheckboxes = document.querySelectorAll('input[name="product_ids[]"]');
    const bulkActions = document.getElementById('bulk-actions');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });
    }

    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });

    function toggleBulkActions() {
        const checkedBoxes = document.querySelectorAll('input[name="product_ids[]"]:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'block';
        } else {
            bulkActions.style.display = 'none';
        }
    }

    // Bulk form submission
    const bulkForm = document.getElementById('bulk-form');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const action = this.querySelector('select[name="action"]').value;
            const checkedBoxes = document.querySelectorAll('input[name="product_ids[]"]:checked');
            
            if (!action) {
                e.preventDefault();
                alert('Please select an action');
                return;
            }

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one product');
                return;
            }

            // Add selected product IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'product_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });

            if (action === 'delete') {
                if (!confirm('Are you sure you want to delete the selected products? This action cannot be undone.')) {
                    e.preventDefault();
                }
            }
        });
    }
});
</script>
@endpush