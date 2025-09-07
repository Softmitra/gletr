@extends('seller.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Edit Profile</h4>
                    <p class="text-muted mb-0">Update your account information and settings</p>
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

    <form action="{{ route('seller.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Basic Information -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Basic Information</h5>
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
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_type" class="form-label">Business Type</label>
                                    <select class="form-control @error('business_type') is-invalid @enderror" 
                                            id="business_type" 
                                            name="business_type">
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
                            <div class="col-md-6">
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
                                    <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('pincode') is-invalid @enderror" 
                                           id="pincode" 
                                           name="pincode" 
                                           value="{{ old('pincode', $seller->pincode) }}" 
                                           required>
                                    @error('pincode')
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
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Profile Picture -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Profile Picture</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img src="{{ $seller->image ? asset('storage/' . $seller->image) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" 
                                 alt="Profile Picture" 
                                 class="img-circle elevation-2" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <form action="{{ route('seller.profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                            @csrf
                            <div class="mb-2">
                                <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*" onchange="document.getElementById('avatarForm').submit();">
                                <button type="button" class="btn btn-sm btn-primary" onclick="document.getElementById('avatar').click();">
                                    <i class="fas fa-camera"></i> Change Picture
                                </button>
                            </div>
                            <small class="text-muted">JPG, PNG, GIF up to 2MB</small>
                        </form>
                    </div>
                </div>

                <!-- Password Change -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Change Password</h6>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-outline-warning btn-sm btn-block" data-toggle="modal" data-target="#passwordModal">
                            <i class="fas fa-key"></i> Change Password
                        </a>
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

<!-- Password Change Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('seller.profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password" 
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
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
