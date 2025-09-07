@extends('layouts.admin')

@section('title', 'Edit Seller')

@section('page_title', 'Edit Seller')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.show', $seller) }}">{{ $seller->f_name }} {{ $seller->l_name }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Seller Navigation -->
        <div class="col-md-3">
            <x-seller-navigation :seller="$seller" active-route="admin.sellers.edit" />
        </div>
        
        <div class="col-md-9">
            <!-- Seller Info Header -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i> Edit Seller: {{ $seller->f_name }} {{ $seller->l_name }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sellers.show', $seller) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Details
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.sellers.update', $seller) }}" method="POST" enctype="multipart/form-data" id="sellerEditForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs" id="sellerEditTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab">
                                    <i class="fas fa-user"></i> Personal Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="business-tab" data-toggle="tab" href="#business" role="tab">
                                    <i class="fas fa-building"></i> Business Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab">
                                    <i class="fas fa-map-marker-alt"></i> Address
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab">
                                    <i class="fas fa-university"></i> Bank Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab">
                                    <i class="fas fa-cogs"></i> Settings
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="sellerEditTabsContent">
                            <!-- Personal Information Tab -->
                            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-user-circle"></i> Personal Information
                                        </h5>
                                        
                                        <div class="form-group">
                                            <label for="f_name">First Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('f_name') is-invalid @enderror" 
                                                       id="f_name" name="f_name" value="{{ old('f_name', $seller->f_name) }}" required>
                                                @error('f_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="l_name">Last Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('l_name') is-invalid @enderror" 
                                                       id="l_name" name="l_name" value="{{ old('l_name', $seller->l_name) }}" required>
                                                @error('l_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email', $seller->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-phone"></i> Contact Information
                                        </h5>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="country_code">Country Code</label>
                                                    <input type="text" class="form-control @error('country_code') is-invalid @enderror" 
                                                           id="country_code" name="country_code" value="{{ old('country_code', $seller->country_code) }}" placeholder="+91">
                                                    @error('country_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                               id="phone" name="phone" value="{{ old('phone', $seller->phone) }}">
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status Information -->
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                                <option value="active" {{ old('status', $seller->status) === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $seller->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="suspended" {{ old('status', $seller->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="verification_status">Verification Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('verification_status') is-invalid @enderror" id="verification_status" name="verification_status">
                                                <option value="pending" {{ old('verification_status', $seller->verification_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="verified" {{ old('verification_status', $seller->verification_status) === 'verified' ? 'selected' : '' }}>Verified</option>
                                                <option value="rejected" {{ old('verification_status', $seller->verification_status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            @error('verification_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Information Tab -->
                            <div class="tab-pane fade" id="business" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-building"></i> Business Information
                                        </h5>
                                        
                                        <div class="form-group">
                                            <label for="business_name">Business Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-store"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                                       id="business_name" name="business_name" value="{{ old('business_name', $seller->business_name) }}">
                                                @error('business_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="business_type">Business Type</label>
                                            <select class="form-control @error('business_type') is-invalid @enderror" id="business_type" name="business_type">
                                                <option value="">Select Business Type</option>
                                                <option value="individual" {{ old('business_type', $seller->business_type) === 'individual' ? 'selected' : '' }}>Individual</option>
                                                <option value="partnership" {{ old('business_type', $seller->business_type) === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                                <option value="company" {{ old('business_type', $seller->business_type) === 'company' ? 'selected' : '' }}>Company</option>
                                                <option value="llp" {{ old('business_type', $seller->business_type) === 'llp' ? 'selected' : '' }}>LLP</option>
                                            </select>
                                            @error('business_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="sales_commission_percentage">Commission Rate (%)</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('sales_commission_percentage') is-invalid @enderror" 
                                                       id="sales_commission_percentage" name="sales_commission_percentage" 
                                                       value="{{ old('sales_commission_percentage', $seller->sales_commission_percentage) }}" 
                                                       min="0" max="100" step="0.01">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                @error('sales_commission_percentage')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-file-alt"></i> Legal Documents
                                        </h5>

                                        <div class="form-group">
                                            <label for="gst_number">GST Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-receipt"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('gst_number') is-invalid @enderror" 
                                                       id="gst_number" name="gst_number" value="{{ old('gst_number', $seller->gst_number) }}" 
                                                       placeholder="22AAAAA0000A1Z5">
                                                @error('gst_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pan_number">PAN Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('pan_number') is-invalid @enderror" 
                                                       id="pan_number" name="pan_number" value="{{ old('pan_number', $seller->pan_number) }}" 
                                                       placeholder="ABCDE1234F">
                                                @error('pan_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="verification_notes">Verification Notes</label>
                                            <textarea class="form-control @error('verification_notes') is-invalid @enderror" 
                                                      id="verification_notes" name="verification_notes" rows="3" 
                                                      placeholder="Add notes about verification status...">{{ old('verification_notes', $seller->verification_notes) }}</textarea>
                                            @error('verification_notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information Tab -->
                            <div class="tab-pane fade" id="address" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-map-marker-alt"></i> Address Details
                                        </h5>
                                        
                                        <div class="form-group">
                                            <label for="address_line_1">Address Line 1</label>
                                            <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" 
                                                   id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $seller->address_line_1) }}">
                                            @error('address_line_1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address_line_2">Address Line 2</label>
                                            <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" 
                                                   id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $seller->address_line_2) }}">
                                            @error('address_line_2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="area">Area</label>
                                            <input type="text" class="form-control @error('area') is-invalid @enderror" 
                                                   id="area" name="area" value="{{ old('area', $seller->area) }}">
                                            @error('area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                                   id="city" name="city" value="{{ old('city', $seller->city) }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-globe"></i> Location Details
                                        </h5>

                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                                   id="state" name="state" value="{{ old('state', $seller->state) }}">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                                   id="country" name="country" value="{{ old('country', $seller->country) }}">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="pincode">Pincode</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('pincode') is-invalid @enderror" 
                                                       id="pincode" name="pincode" value="{{ old('pincode', $seller->pincode) }}">
                                                @error('pincode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Details Tab -->
                            <div class="tab-pane fade" id="bank" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-university"></i> Bank Information
                                        </h5>
                                        
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                                       id="bank_name" name="bank_name" value="{{ old('bank_name', $seller->bank_name) }}">
                                                @error('bank_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="branch">Branch</label>
                                            <input type="text" class="form-control @error('branch') is-invalid @enderror" 
                                                   id="branch" name="branch" value="{{ old('branch', $seller->branch) }}">
                                            @error('branch')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="ifsc_code">IFSC Code</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" 
                                                       id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code', $seller->ifsc_code) }}" 
                                                       placeholder="ABCD0123456">
                                                @error('ifsc_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-credit-card"></i> Account Details
                                        </h5>

                                        <div class="form-group">
                                            <label for="account_no">Account Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('account_no') is-invalid @enderror" 
                                                       id="account_no" name="account_no" value="{{ old('account_no', $seller->account_no) }}">
                                                @error('account_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="holder_name">Account Holder Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('holder_name') is-invalid @enderror" 
                                                       id="holder_name" name="holder_name" value="{{ old('holder_name', $seller->holder_name) }}">
                                                @error('holder_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Tab -->
                            <div class="tab-pane fade" id="settings" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-cogs"></i> Business Settings
                                        </h5>
                                        
                                        <div class="form-group">
                                            <label for="minimum_order_amount">Minimum Order Amount (₹)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₹</span>
                                                </div>
                                                <input type="number" class="form-control @error('minimum_order_amount') is-invalid @enderror" 
                                                       id="minimum_order_amount" name="minimum_order_amount" 
                                                       value="{{ old('minimum_order_amount', $seller->minimum_order_amount) }}" 
                                                       min="0" step="0.01">
                                                @error('minimum_order_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="free_delivery_over_amount">Free Delivery Over (₹)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₹</span>
                                                </div>
                                                <input type="number" class="form-control @error('free_delivery_over_amount') is-invalid @enderror" 
                                                       id="free_delivery_over_amount" name="free_delivery_over_amount" 
                                                       value="{{ old('free_delivery_over_amount', $seller->free_delivery_over_amount) }}" 
                                                       min="0" step="0.01">
                                                @error('free_delivery_over_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-toggle-on"></i> Feature Settings
                                        </h5>

                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="free_delivery_status" 
                                                       name="free_delivery_status" value="1" 
                                                       {{ old('free_delivery_status', $seller->free_delivery_status) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="free_delivery_status">
                                                    <strong>Enable Free Delivery</strong>
                                                    <br><small class="text-muted">Allow free delivery for orders above threshold</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="pos_status" 
                                                       name="pos_status" value="1" 
                                                       {{ old('pos_status', $seller->pos_status) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="pos_status">
                                                    <strong>Enable POS System</strong>
                                                    <br><small class="text-muted">Allow point of sale transactions</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Update Seller
                                </button>
                                <a href="{{ route('admin.sellers.show', $seller) }}" class="btn btn-secondary btn-lg ml-2">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Last updated: {{ $seller->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
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

    // Auto-format IFSC code
    $('#ifsc_code').on('input', function() {
        let value = $(this).val().toUpperCase();
        $(this).val(value);
    });

    // Form validation
    $('#sellerEditForm').on('submit', function(e) {
        let isValid = true;
        
        // Check required fields
        $('input[required]').each(function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Email validation
        const email = $('#email').val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) {
            $('#email').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            // Show first tab with errors
            $('.nav-tabs .nav-link').each(function() {
                const tabPane = $($(this).attr('href'));
                if (tabPane.find('.is-invalid').length > 0) {
                    $(this).tab('show');
                    return false;
                }
            });
        }
    });

    // Real-time validation
    $('input[required]').on('blur', function() {
        if ($(this).val().trim() === '') {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Tab validation indicators
    function updateTabValidation() {
        $('.nav-tabs .nav-link').each(function() {
            const tabPane = $($(this).attr('href'));
            const hasErrors = tabPane.find('.is-invalid').length > 0;
            
            if (hasErrors) {
                $(this).addClass('text-danger');
                if (!$(this).find('.fa-exclamation-triangle').length) {
                    $(this).append(' <i class="fas fa-exclamation-triangle"></i>');
                }
            } else {
                $(this).removeClass('text-danger');
                $(this).find('.fa-exclamation-triangle').remove();
            }
        });
    }

    // Update tab validation on input change
    $('input, select, textarea').on('input change', function() {
        setTimeout(updateTabValidation, 100);
    });

    // Initial validation check
    updateTabValidation();
});
</script>
@endpush