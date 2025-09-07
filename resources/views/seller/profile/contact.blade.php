@extends('seller.layouts.app')

@section('title', 'Contact Information')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Contact Information</h4>
                    <p class="text-muted mb-0">Manage your contact details and communication preferences</p>
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

    <form action="{{ route('seller.profile.contact.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Primary Contact Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $seller->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $seller->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Primary Phone <span class="text-danger">*</span></label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $seller->phone) }}" 
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alternate_phone" class="form-label">Alternate Phone</label>
                                    <input type="tel" 
                                           class="form-control @error('alternate_phone') is-invalid @enderror" 
                                           id="alternate_phone" 
                                           name="alternate_phone" 
                                           value="{{ old('alternate_phone', $seller->alternate_phone ?? '') }}"
                                           placeholder="Optional">
                                    @error('alternate_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Address Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3" 
                                      required>{{ old('address', $seller->address_line_1) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('city') is-invalid @enderror" 
                                           id="city" 
                                           name="city" 
                                           value="{{ old('city', $seller->city) }}" 
                                           required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('state') is-invalid @enderror" 
                                           id="state" 
                                           name="state" 
                                           value="{{ old('state', $seller->state) }}" 
                                           required>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('postal_code') is-invalid @enderror" 
                                           id="postal_code" 
                                           name="postal_code" 
                                           value="{{ old('postal_code', $seller->pincode) }}" 
                                           required>
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('country') is-invalid @enderror" 
                                   id="country" 
                                   name="country" 
                                   value="{{ old('country', $seller->country) }}" 
                                   required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Communication Preferences -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Communication Preferences</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="email_notifications" 
                                               name="email_notifications" 
                                               value="1" 
                                               {{ old('email_notifications', $seller->email_notifications ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">
                                            Email Notifications
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Receive important updates via email</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="sms_notifications" 
                                               name="sms_notifications" 
                                               value="1" 
                                               {{ old('sms_notifications', $seller->sms_notifications ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sms_notifications">
                                            SMS Notifications
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Receive urgent updates via SMS</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="marketing_emails" 
                                               name="marketing_emails" 
                                               value="1" 
                                               {{ old('marketing_emails', $seller->marketing_emails ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="marketing_emails">
                                            Marketing Emails
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Receive promotional offers and updates</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="order_notifications" 
                                               name="order_notifications" 
                                               value="1" 
                                               {{ old('order_notifications', $seller->order_notifications ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="order_notifications">
                                            Order Notifications
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Get notified about new orders</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Contact Status -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Contact Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Email Status:</strong>
                            <div class="mt-1">
                                @if($seller->email_verified_at)
                                    <span class="badge badge-success">Verified</span>
                                @else
                                    <span class="badge badge-warning">Unverified</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Phone Status:</strong>
                            <div class="mt-1">
                                <span class="badge badge-success">Active</span>
                            </div>
                        </div>
                        <div class="mb-0">
                            <strong>Last Updated:</strong>
                            <div class="mt-1">
                                {{ $seller->updated_at->format('M d, Y') }}
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
                            <a href="{{ route('seller.profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                            <a href="{{ route('seller.profile.business.edit') }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-building"></i> Business Info
                            </a>
                            <a href="{{ route('seller.profile.settings') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-cog"></i> Settings
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

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
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
