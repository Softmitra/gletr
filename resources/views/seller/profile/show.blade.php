@extends('seller.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">My Profile</h4>
                    <p class="text-muted mb-0">Manage your account information and settings</p>
                </div>
                <a href="{{ route('seller.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Full Name:</strong></td>
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
                                <tr>
                                    <td><strong>Business Name:</strong></td>
                                    <td>{{ $seller->business_name ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Business Type:</strong></td>
                                    <td>{{ $seller->business_type ?? 'Not provided' }}</td>
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
                                    <td><strong>Last Login:</strong></td>
                                    <td>{{ $seller->last_login_at ? $seller->last_login_at->diffForHumans() : 'Never' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Account Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $seller->status === 'active' ? 'success' : ($seller->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($seller->status) }}
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
                </div>
            </div>

            <!-- Address Information -->
            @if($seller->address || $seller->city || $seller->state)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Address Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Address:</strong> {{ $seller->address ?? 'Not provided' }}</p>
                            <p><strong>City:</strong> {{ $seller->city ?? 'Not provided' }}</p>
                            <p><strong>State:</strong> {{ $seller->state ?? 'Not provided' }}</p>
                            <p><strong>Postal Code:</strong> {{ $seller->postal_code ?? 'Not provided' }}</p>
                            <p><strong>Country:</strong> {{ $seller->country ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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

            <!-- Profile Completion -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Profile Completion</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted">Progress</span>
                            <span class="font-weight-bold">{{ $profile_completion }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $profile_completion }}%" 
                                 aria-valuenow="{{ $profile_completion }}" 
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    @if($profile_completion < 100)
                        <small class="text-muted">Complete your profile to improve your seller rating</small>
                    @else
                        <small class="text-success">Your profile is complete!</small>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
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
                        <a href="{{ route('seller.profile.contact.edit') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-address-card"></i> Contact Info
                        </a>
                        <a href="{{ route('seller.verification.status') }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-certificate"></i> Verification Status
                        </a>
                        <a href="{{ route('seller.profile.activity') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-history"></i> Activity Log
                        </a>
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
