@extends('seller.layouts.app')

@section('title', 'Business Information')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Business Information</h4>
                    <p class="text-muted mb-0">Manage your business details and registration information</p>
                </div>
                <a href="{{ route('seller.profile.show') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>
    </div>

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
            <i class="fas fa-exclamation-triangle"></i> Please correct the following errors:
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

    <form action="{{ route('seller.profile.business.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Business Information -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Business Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_name" class="form-label">Business Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('business_name') is-invalid @enderror" 
                                           id="business_name" 
                                           name="business_name" 
                                           value="{{ old('business_name', $seller->business_name) }}" 
                                           required>
                                    @error('business_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_type" class="form-label">Business Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('business_type') is-invalid @enderror" 
                                            id="business_type" 
                                            name="business_type" 
                                            required>
                                        <option value="">Select Business Type</option>
                                        <option value="individual" {{ old('business_type', $seller->business_type) == 'individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="partnership" {{ old('business_type', $seller->business_type) == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                        <option value="private_limited" {{ old('business_type', $seller->business_type) == 'private_limited' ? 'selected' : '' }}>Private Limited</option>
                                        <option value="public_limited" {{ old('business_type', $seller->business_type) == 'public_limited' ? 'selected' : '' }}>Public Limited</option>
                                        <option value="llp" {{ old('business_type', $seller->business_type) == 'llp' ? 'selected' : '' }}>LLP</option>
                                        <option value="sole_proprietorship" {{ old('business_type', $seller->business_type) == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                    </select>
                                    @error('business_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_registration_number" class="form-label">Registration Number</label>
                                    <input type="text" 
                                           class="form-control @error('business_registration_number') is-invalid @enderror" 
                                           id="business_registration_number" 
                                           name="business_registration_number" 
                                           value="{{ old('business_registration_number', $seller->business_registration_number ?? '') }}"
                                           placeholder="e.g., U72900MH2010PTC123456">
                                    @error('business_registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tax_id" class="form-label">Tax ID</label>
                                    <input type="text" 
                                           class="form-control @error('tax_id') is-invalid @enderror" 
                                           id="tax_id" 
                                           name="tax_id" 
                                           value="{{ old('tax_id', $seller->tax_id ?? '') }}"
                                           placeholder="e.g., TAX123456789">
                                    @error('tax_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gst_number" class="form-label">GST Number</label>
                            <input type="text" 
                                   class="form-control @error('gst_number') is-invalid @enderror" 
                                   id="gst_number" 
                                   name="gst_number" 
                                   value="{{ old('gst_number', $seller->gst_number) }}"
                                   placeholder="e.g., 22AAAAA0000A1Z5">
                            @error('gst_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Business Address -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Business Address</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="business_address" class="form-label">Business Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('business_address') is-invalid @enderror" 
                                      id="business_address" 
                                      name="business_address" 
                                      rows="3" 
                                      required>{{ old('business_address', $seller->address_line_1) }}</textarea>
                            @error('business_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="business_city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('business_city') is-invalid @enderror" 
                                           id="business_city" 
                                           name="business_city" 
                                           value="{{ old('business_city', $seller->city) }}" 
                                           required>
                                    @error('business_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="business_state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('business_state') is-invalid @enderror" 
                                           id="business_state" 
                                           name="business_state" 
                                           value="{{ old('business_state', $seller->state) }}" 
                                           required>
                                    @error('business_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="business_postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('business_postal_code') is-invalid @enderror" 
                                           id="business_postal_code" 
                                           name="business_postal_code" 
                                           value="{{ old('business_postal_code', $seller->pincode) }}" 
                                           required>
                                    @error('business_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="business_country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('business_country') is-invalid @enderror" 
                                   id="business_country" 
                                   name="business_country" 
                                   value="{{ old('business_country', $seller->country) }}" 
                                   required>
                            @error('business_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Business Status -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Business Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Verification Status:</strong>
                            <div class="mt-1">
                                @if($seller->isFullyVerified())
                                    <span class="badge badge-success">Verified</span>
                                @elseif($seller->hasDocumentsVerified())
                                    <span class="badge badge-primary">Documents Verified</span>
                                @elseif($seller->isPendingVerification())
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Account Status:</strong>
                            <div class="mt-1">
                                <span class="badge badge-{{ $seller->status === 'active' ? 'success' : ($seller->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($seller->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-0">
                            <strong>Registration Date:</strong>
                            <div class="mt-1">
                                {{ $seller->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('seller.verification.status') }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-certificate"></i> Verification Status
                            </a>
                            <a href="{{ route('seller.verification.documents') }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-file-upload"></i> Upload Documents
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="{{ route('seller.profile.show') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.text-danger {
    color: #dc3545 !important;
}

.card {
    border-radius: 0.5rem;
}

.btn-block {
    width: 100%;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush
