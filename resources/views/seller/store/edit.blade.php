@extends('seller.layouts.app')

@section('title', 'Edit Store')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Edit Store Information</h4>
                    <p class="text-muted mb-0">Update your store details and business information</p>
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
                    <h5 class="mb-0">Store Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.store.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Business Name -->
                        <div class="form-group">
                            <label for="business_name">Business Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                   id="business_name" name="business_name" 
                                   value="{{ old('business_name', $seller->business_name) }}" required>
                            @error('business_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Business Description -->
                        <div class="form-group">
                            <label for="business_description">Business Description</label>
                            <textarea class="form-control @error('business_description') is-invalid @enderror" 
                                      id="business_description" name="business_description" rows="4"
                                      placeholder="Describe your business, products, and services...">{{ old('business_description', $seller->business_description) }}</textarea>
                            @error('business_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">This will be displayed on your store page (max 1000 characters)</small>
                        </div>

                        <!-- Business Address -->
                        <h6 class="mb-3">Business Address</h6>
                        
                        <div class="form-group">
                            <label for="business_address">Street Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('business_address') is-invalid @enderror" 
                                      id="business_address" name="business_address" rows="3" required
                                      placeholder="Enter your complete business address">{{ old('business_address', $seller->business_address) }}</textarea>
                            @error('business_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_city">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('business_city') is-invalid @enderror" 
                                           id="business_city" name="business_city" 
                                           value="{{ old('business_city', $seller->business_city) }}" required>
                                    @error('business_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_state">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('business_state') is-invalid @enderror" 
                                           id="business_state" name="business_state" 
                                           value="{{ old('business_state', $seller->business_state) }}" required>
                                    @error('business_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_postal_code">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('business_postal_code') is-invalid @enderror" 
                                           id="business_postal_code" name="business_postal_code" 
                                           value="{{ old('business_postal_code', $seller->business_postal_code) }}" required>
                                    @error('business_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_country">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('business_country') is-invalid @enderror" 
                                           id="business_country" name="business_country" 
                                           value="{{ old('business_country', $seller->business_country ?? 'India') }}" required>
                                    @error('business_country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Store Information
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
