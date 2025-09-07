@extends('seller.layouts.app')

@section('title', 'Activity Timeline')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Activity Timeline</h4>
                    <p class="text-muted mb-0">Track your account activity and recent actions</p>
                </div>
                <a href="{{ route('seller.profile.show') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Activity Timeline -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Activity</h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active" data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-filter="login">Login</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-filter="profile">Profile</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-filter="order">Orders</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($activities) && $activities->count() > 0)
                        <div class="timeline">
                            @foreach($activities as $activity)
                                <div class="timeline-item" data-type="{{ $activity->activity_type }}">
                                    <div class="timeline-marker">
                                        @switch($activity->activity_type)
                                            @case('login')
                                                <i class="fas fa-sign-in-alt text-success"></i>
                                                @break
                                            @case('logout')
                                                <i class="fas fa-sign-out-alt text-warning"></i>
                                                @break
                                            @case('profile_update')
                                                <i class="fas fa-user-edit text-info"></i>
                                                @break
                                            @case('order_created')
                                                <i class="fas fa-shopping-cart text-primary"></i>
                                                @break
                                            @case('document_upload')
                                                <i class="fas fa-file-upload text-secondary"></i>
                                                @break
                                            @default
                                                <i class="fas fa-circle text-muted"></i>
                                        @endswitch
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <h6 class="mb-1">{{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</h6>
                                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($activity->description)
                                            <p class="mb-1">{{ $activity->description }}</p>
                                        @endif
                                        @if($activity->action)
                                            <small class="text-muted">Action: {{ $activity->action }}</small>
                                        @endif
                                        @if($activity->ip_address)
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    <i class="fas fa-globe"></i> {{ $activity->ip_address }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Activity Found</h5>
                            <p class="text-muted">Your activity timeline will appear here once you start using your account.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Account Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Account Summary</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Member Since:</strong>
                        <div class="mt-1">
                            {{ auth()->guard('seller')->user()->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Last Login:</strong>
                        <div class="mt-1">
                            {{ auth()->guard('seller')->user()->last_login_at ? auth()->guard('seller')->user()->last_login_at->diffForHumans() : 'Never' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Total Logins:</strong>
                        <div class="mt-1">
                            {{ auth()->guard('seller')->user()->login_count ?? 0 }}
                        </div>
                    </div>
                    <div class="mb-0">
                        <strong>Account Status:</strong>
                        <div class="mt-1">
                            <span class="badge badge-{{ auth()->guard('seller')->user()->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst(auth()->guard('seller')->user()->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Security</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Email Verification:</strong>
                        <div class="mt-1">
                            @if(auth()->guard('seller')->user()->email_verified_at)
                                <span class="badge badge-success">Verified</span>
                            @else
                                <span class="badge badge-warning">Unverified</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Password Last Changed:</strong>
                        <div class="mt-1">
                            {{ auth()->guard('seller')->user()->updated_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="mb-0">
                        <a href="{{ route('seller.profile.edit') }}" class="btn btn-outline-primary btn-sm btn-block">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                    </div>
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
                            <i class="fas fa-certificate"></i> Verification
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
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 40px;
    height: 40px;
    background: #fff;
    border: 2px solid #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-header {
    display: flex;
    justify-content: between;
    align-items: flex-start;
    margin-bottom: 8px;
}

.timeline-header h6 {
    margin: 0;
    flex: 1;
}

.timeline-header small {
    margin-left: auto;
}

.d-grid {
    display: grid;
}

.gap-2 {
    gap: 0.5rem;
}

.btn-block {
    width: 100%;
}

.card {
    border-radius: 0.5rem;
}

.timeline-item[data-type="login"] .timeline-content {
    border-left-color: #28a745;
}

.timeline-item[data-type="logout"] .timeline-content {
    border-left-color: #ffc107;
}

.timeline-item[data-type="profile_update"] .timeline-content {
    border-left-color: #17a2b8;
}

.timeline-item[data-type="order_created"] .timeline-content {
    border-left-color: #007bff;
}

.timeline-item[data-type="document_upload"] .timeline-content {
    border-left-color: #6c757d;
}

/* Filter functionality */
.timeline-item.hidden {
    display: none;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Activity filter functionality
    $('[data-filter]').on('click', function() {
        var filter = $(this).data('filter');
        
        // Update active button
        $('[data-filter]').removeClass('active');
        $(this).addClass('active');
        
        // Show/hide timeline items
        $('.timeline-item').each(function() {
            var type = $(this).data('type');
            if (filter === 'all' || type === filter) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });
    });
});
</script>
@endpush
