@extends('layouts.admin')

@section('title', 'Add New Seller')

@section('page_title', 'Add New Seller')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Seller</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sellers.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Sellers
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.sellers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Personal Information</h5>
                                
                                <div class="form-group">
                                    <label for="f_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('f_name') is-invalid @enderror" 
                                           id="f_name" name="f_name" value="{{ old('f_name') }}" required>
                                    @error('f_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="l_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('l_name') is-invalid @enderror" 
                                           id="l_name" name="l_name" value="{{ old('l_name') }}" required>
                                    @error('l_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country_code">Country Code</label>
                                            <input type="text" class="form-control @error('country_code') is-invalid @enderror" 
                                                   id="country_code" name="country_code" value="{{ old('country_code', '+91') }}" placeholder="+91">
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Business Information</h5>
                                
                                <div class="form-group">
                                    <label for="business_name">Business Name</label>
                                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                           id="business_name" name="business_name" value="{{ old('business_name') }}">
                                    @error('business_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="business_type">Business Type</label>
                                    <select class="form-control @error('business_type') is-invalid @enderror" id="business_type" name="business_type">
                                        <option value="">Select Business Type</option>
                                        <option value="individual" {{ old('business_type') === 'individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="partnership" {{ old('business_type') === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                        <option value="company" {{ old('business_type') === 'company' ? 'selected' : '' }}>Company</option>
                                        <option value="llp" {{ old('business_type') === 'llp' ? 'selected' : '' }}>LLP</option>
                                    </select>
                                    @error('business_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="gst_number">GST Number</label>
                                    <input type="text" class="form-control @error('gst_number') is-invalid @enderror" 
                                           id="gst_number" name="gst_number" value="{{ old('gst_number') }}">
                                    @error('gst_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="pan_number">PAN Number</label>
                                    <input type="text" class="form-control @error('pan_number') is-invalid @enderror" 
                                           id="pan_number" name="pan_number" value="{{ old('pan_number') }}">
                                    @error('pan_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sales_commission_percentage">Commission Rate (%)</label>
                                    <input type="number" class="form-control @error('sales_commission_percentage') is-invalid @enderror" 
                                           id="sales_commission_percentage" name="sales_commission_percentage" 
                                           value="{{ old('sales_commission_percentage', '5') }}" 
                                           min="0" max="100" step="0.01">
                                    @error('sales_commission_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Address Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-3">Address Information</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address_line_1">Address Line 1</label>
                                    <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" 
                                           id="address_line_1" name="address_line_1" value="{{ old('address_line_1') }}">
                                    @error('address_line_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="address_line_2">Address Line 2</label>
                                    <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" 
                                           id="address_line_2" name="address_line_2" value="{{ old('address_line_2') }}">
                                    @error('address_line_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control @error('area') is-invalid @enderror" 
                                           id="area" name="area" value="{{ old('area') }}">
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           id="state" name="state" value="{{ old('state') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                           id="country" name="country" value="{{ old('country', 'India') }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control @error('pincode') is-invalid @enderror" 
                                           id="pincode" name="pincode" value="{{ old('pincode') }}">
                                    @error('pincode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Business Settings -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-3">Business Settings</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="minimum_order_amount">Minimum Order Amount (₹)</label>
                                    <input type="number" class="form-control @error('minimum_order_amount') is-invalid @enderror" 
                                           id="minimum_order_amount" name="minimum_order_amount" 
                                           value="{{ old('minimum_order_amount', '0') }}" 
                                           min="0" step="0.01">
                                    @error('minimum_order_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="free_delivery_over_amount">Free Delivery Over (₹)</label>
                                    <input type="number" class="form-control @error('free_delivery_over_amount') is-invalid @enderror" 
                                           id="free_delivery_over_amount" name="free_delivery_over_amount" 
                                           value="{{ old('free_delivery_over_amount', '500') }}" 
                                           min="0" step="0.01">
                                    @error('free_delivery_over_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="free_delivery_status" 
                                               name="free_delivery_status" value="1" 
                                               {{ old('free_delivery_status', '1') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="free_delivery_status">Enable Free Delivery</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="pos_status" 
                                               name="pos_status" value="1" 
                                               {{ old('pos_status') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="pos_status">Enable POS</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Seller
                        </button>
                        <a href="{{ route('admin.sellers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-format GST number
    $('#gst_number').on('input', function() {
        let value = $(this).val().toUpperCase();
        $(this).val(value);
    });

    // Auto-format PAN number
    $('#pan_number').on('input', function() {
        let value = $(this).val().toUpperCase();
        $(this).val(value);
    });

    // Password confirmation validation
    $('#password_confirmation').on('keyup', function() {
        let password = $('#password').val();
        let confirmPassword = $(this).val();
        
        if (password !== confirmPassword) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Passwords do not match</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
});
</script>
@endpush
