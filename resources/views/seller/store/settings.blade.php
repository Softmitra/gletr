@extends('seller.layouts.app')

@section('title', 'Store Settings')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Store Settings</h4>
                    <p class="text-muted mb-0">Configure your store preferences and policies</p>
                </div>
                <a href="{{ route('seller.store.show') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Store
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Store Configuration</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.store.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Store Status -->
                        <div class="form-group">
                            <label for="store_status">Store Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('store_status') is-invalid @enderror" 
                                    id="store_status" name="store_status" required>
                                <option value="active" {{ ($settings['store_status'] ?? 'active') === 'active' ? 'selected' : '' }}>
                                    Active - Store is open for business
                                </option>
                                <option value="inactive" {{ ($settings['store_status'] ?? 'active') === 'inactive' ? 'selected' : '' }}>
                                    Inactive - Store is temporarily closed
                                </option>
                                <option value="maintenance" {{ ($settings['store_status'] ?? 'active') === 'maintenance' ? 'selected' : '' }}>
                                    Maintenance - Store is under maintenance
                                </option>
                            </select>
                            @error('store_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Store Preferences -->
                        <h6 class="mb-3">Store Preferences</h6>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="allow_reviews" name="allow_reviews" 
                                       value="1" {{ ($settings['allow_reviews'] ?? true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="allow_reviews">Allow Customer Reviews</label>
                            </div>
                            <small class="text-muted">Allow customers to leave reviews and ratings for your products</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="show_contact_info" name="show_contact_info" 
                                       value="1" {{ ($settings['show_contact_info'] ?? true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="show_contact_info">Show Contact Information</label>
                            </div>
                            <small class="text-muted">Display your contact information on your store page</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="auto_accept_orders" name="auto_accept_orders" 
                                       value="1" {{ ($settings['auto_accept_orders'] ?? false) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="auto_accept_orders">Auto Accept Orders</label>
                            </div>
                            <small class="text-muted">Automatically accept new orders without manual review</small>
                        </div>

                        <!-- Order Settings -->
                        <h6 class="mb-3">Order Settings</h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_order_amount">Minimum Order Amount (₹)</label>
                                    <input type="number" class="form-control @error('min_order_amount') is-invalid @enderror" 
                                           id="min_order_amount" name="min_order_amount" min="0" step="0.01"
                                           value="{{ old('min_order_amount', $settings['min_order_amount'] ?? 0) }}">
                                    @error('min_order_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Set to 0 for no minimum order requirement</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="free_shipping_threshold">Free Shipping Threshold (₹)</label>
                                    <input type="number" class="form-control @error('free_shipping_threshold') is-invalid @enderror" 
                                           id="free_shipping_threshold" name="free_shipping_threshold" min="0" step="0.01"
                                           value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold'] ?? 0) }}">
                                    @error('free_shipping_threshold')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Set to 0 to disable free shipping</small>
                                </div>
                            </div>
                        </div>

                        <!-- Processing & Policies -->
                        <h6 class="mb-3">Processing & Policies</h6>
                        
                        <div class="form-group">
                            <label for="processing_time">Processing Time <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('processing_time') is-invalid @enderror" 
                                   id="processing_time" name="processing_time" 
                                   value="{{ old('processing_time', $settings['processing_time'] ?? '1-2 business days') }}" required>
                            @error('processing_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">How long it takes to process and ship orders</small>
                        </div>

                        <div class="form-group">
                            <label for="return_policy">Return Policy <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('return_policy') is-invalid @enderror" 
                                      id="return_policy" name="return_policy" rows="4" required
                                      placeholder="Describe your return and refund policy...">{{ old('return_policy', $settings['return_policy'] ?? '7 days return policy') }}</textarea>
                            @error('return_policy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Your return and refund policy (max 500 characters)</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                            <a href="{{ route('seller.store.show') }}" class="btn btn-outline-secondary ml-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
