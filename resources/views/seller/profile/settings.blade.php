@extends('seller.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Settings</h4>
                    <p class="text-muted mb-0">Manage your account preferences and security</p>
                </div>
                <a href="{{ route('seller.profile.show') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Settings Menu -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Settings Menu</h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#profile" class="list-group-item list-group-item-action active" data-toggle="tab">
                        <i class="fas fa-user"></i> Profile Settings
                    </a>
                    <a href="#security" class="list-group-item list-group-item-action" data-toggle="tab">
                        <i class="fas fa-shield-alt"></i> Security
                    </a>
                    <a href="#notifications" class="list-group-item list-group-item-action" data-toggle="tab">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                    <a href="#preferences" class="list-group-item list-group-item-action" data-toggle="tab">
                        <i class="fas fa-cog"></i> Preferences
                    </a>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Profile Settings -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Profile Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Basic Information</h6>
                                    <p class="text-muted">Manage your basic profile information</p>
                                    <a href="{{ route('seller.profile.edit') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit Profile
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6>Business Information</h6>
                                    <p class="text-muted">Update your business details</p>
                                    <a href="{{ route('seller.profile.business.edit') }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-building"></i> Edit Business Info
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Contact Information</h6>
                                    <p class="text-muted">Update your contact details</p>
                                    <a href="{{ route('seller.profile.contact.edit') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-address-card"></i> Edit Contact Info
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <h6>Verification Status</h6>
                                    <p class="text-muted">Check your account verification</p>
                                    <a href="{{ route('seller.verification.status') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-certificate"></i> View Status
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="tab-pane fade" id="security">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Security Settings</h5>
                        </div>
                        <div class="card-body">
                            <!-- Password Change -->
                            <div class="mb-4">
                                <h6>Change Password</h6>
                                <p class="text-muted">Update your account password for better security</p>
                                <form action="{{ route('seller.profile.password.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="current_password">Current Password</label>
                                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-key"></i> Update Password
                                    </button>
                                </form>
                            </div>

                            <hr>

                            <!-- Session Management -->
                            <div class="mb-4">
                                <h6>Active Sessions</h6>
                                <p class="text-muted">Manage your active login sessions</p>
                                <a href="{{ route('seller.sessions.index') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-desktop"></i> Manage Sessions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Notification Preferences</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Notification settings will be available in a future update.
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="email_notifications" checked disabled>
                                    <label class="custom-control-label" for="email_notifications">Email Notifications</label>
                                </div>
                                <small class="text-muted">Receive important updates via email</small>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="order_notifications" checked disabled>
                                    <label class="custom-control-label" for="order_notifications">Order Notifications</label>
                                </div>
                                <small class="text-muted">Get notified about new orders</small>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="verification_notifications" checked disabled>
                                    <label class="custom-control-label" for="verification_notifications">Verification Updates</label>
                                </div>
                                <small class="text-muted">Receive verification status updates</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="tab-pane fade" id="preferences">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Account Preferences</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Additional preferences will be available in a future update.
                            </div>

                            <div class="form-group">
                                <label for="timezone">Timezone</label>
                                <select class="form-control" id="timezone" disabled>
                                    <option>Asia/Kolkata (UTC+05:30)</option>
                                </select>
                                <small class="text-muted">Your current timezone setting</small>
                            </div>

                            <div class="form-group">
                                <label for="language">Language</label>
                                <select class="form-control" id="language" disabled>
                                    <option>English</option>
                                </select>
                                <small class="text-muted">Your preferred language</small>
                            </div>

                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select class="form-control" id="currency" disabled>
                                    <option>INR (₹)</option>
                                </select>
                                <small class="text-muted">Your preferred currency</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
