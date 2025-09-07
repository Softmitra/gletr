@extends('layouts.admin')

@section('title', 'User Profile Details')

@section('page_title', 'User Profile Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.user-profiles.index') }}">User Profiles</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <!-- User Information -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.user-profiles.edit', $user) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($user->profile && $user->profile->profile_picture)
                            <img src="{{ $user->profile->profile_picture_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="img-circle" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="avatar-title bg-primary rounded-circle mx-auto" style="width: 120px; height: 120px; font-size: 3rem; line-height: 120px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    
                    <div class="mt-3">
                        <span class="badge badge-{{ $user->status_color }} badge-lg">
                            <i class="{{ $user->status_icon }}"></i>
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                    
                    @if($user->profile)
                        <div class="mt-3">
                            <div class="progress mb-2">
                                <div class="progress-bar bg-{{ $user->profile->completion_percentage >= 80 ? 'success' : ($user->profile->completion_percentage >= 50 ? 'warning' : 'danger') }}" 
                                     style="width: {{ $user->profile->completion_percentage }}%"></div>
                            </div>
                            <small class="text-muted">Profile Completion: {{ $user->profile->completion_percentage }}%</small>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group-vertical w-100">
                        <button type="button" class="btn btn-outline-warning mb-2" onclick="toggleStatus({{ $user->id }})">
                            <i class="fas fa-toggle-on"></i> Toggle Status
                        </button>
                        <button type="button" class="btn btn-outline-info mb-2" onclick="resetPassword({{ $user->id }})">
                            <i class="fas fa-key"></i> Reset Password
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteProfile({{ $user->id }})">
                            <i class="fas fa-trash"></i> Delete Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profile Details -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profile Details</h3>
                </div>
                <div class="card-body">
                    @if($user->profile)
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $user->profile->formatted_phone ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date of Birth:</strong></td>
                                        <td>
                                            @if($user->profile->date_of_birth)
                                                {{ $user->profile->date_of_birth->format('M d, Y') }}
                                                <small class="text-muted">({{ $user->profile->age }} years old)</small>
                                            @else
                                                Not provided
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gender:</strong></td>
                                        <td>{{ ucfirst($user->profile->gender) ?? 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Website:</strong></td>
                                        <td>
                                            @if($user->profile->website)
                                                <a href="{{ $user->profile->website }}" target="_blank">{{ $user->profile->website }}</a>
                                            @else
                                                Not provided
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Bio:</strong></td>
                                        <td>{{ $user->profile->bio ?? 'No bio provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Created:</strong></td>
                                        <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Updated:</strong></td>
                                        <td>{{ $user->profile->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Login:</strong></td>
                                        <td>
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->format('M d, Y H:i') }}
                                                <small class="text-muted">({{ $user->last_login_at->diffForHumans() }})</small>
                                            @else
                                                Never
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Social Media Links -->
                        @if($user->profile->social_links && array_filter($user->profile->social_links))
                            <hr>
                            <h5>Social Media Links</h5>
                            <div class="row">
                                @foreach($user->profile->social_links as $platform => $url)
                                    @if($url)
                                        <div class="col-md-3 mb-2">
                                            <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary btn-sm btn-block">
                                                <i class="fab fa-{{ $platform }}"></i> {{ ucfirst($platform) }}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Preferences -->
                        @if($user->profile->preferences)
                            <hr>
                            <h5>Preferences</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               {{ $user->profile->preferences['notifications'] ? 'checked' : 'disabled' }}>
                                        <label class="form-check-label">Email Notifications</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               {{ $user->profile->preferences['marketing'] ? 'checked' : 'disabled' }}>
                                        <label class="form-check-label">Marketing Emails</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               {{ $user->profile->preferences['newsletter'] ? 'checked' : 'disabled' }}>
                                        <label class="form-check-label">Newsletter</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No profile information available</p>
                            <a href="{{ route('admin.user-profiles.edit', $user) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Profile
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Addresses -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Addresses ({{ $user->addresses->count() }})</h3>
                </div>
                <div class="card-body">
                    @if($user->addresses->count() > 0)
                        <div class="row">
                            @foreach($user->addresses as $address)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-{{ $address->type_color }}">
                                        <div class="card-header bg-{{ $address->type_color }} text-white">
                                            <h6 class="mb-0">
                                                <i class="{{ $address->type_icon }}"></i>
                                                {{ ucfirst($address->type) }} Address
                                                @if($address->is_default)
                                                    <span class="badge badge-light ml-2">Default</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @if($address->label)
                                                <strong>{{ $address->label }}</strong><br>
                                            @endif
                                            {{ $address->address_line_1 }}<br>
                                            @if($address->address_line_2)
                                                {{ $address->address_line_2 }}<br>
                                            @endif
                                            {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                                            {{ $address->country }}
                                            @if($address->phone)
                                                <br><small class="text-muted">Phone: {{ $address->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No addresses found</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- User Roles -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Roles</h3>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <span class="badge badge-info badge-lg mr-2">
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </span>
                        @endforeach
                    @else
                        <p class="text-muted">No roles assigned</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Forms -->
<form id="toggleStatusForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="resetPasswordForm" method="POST" style="display: none;">
    @csrf
    @method('PUT')
</form>

<form id="deleteProfileForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('js')
<script>
function toggleStatus(userId) {
    if (confirm('Are you sure you want to toggle this user\'s status?')) {
        var form = $('#toggleStatusForm');
        form.attr('action', '{{ url("admin/user-profiles") }}/' + userId + '/toggle-status');
        form.submit();
    }
}

function resetPassword(userId) {
    if (confirm('Are you sure you want to reset this user\'s password? A new password will be generated and sent to their email.')) {
        var form = $('#resetPasswordForm');
        form.attr('action', '{{ url("admin/user-profiles") }}/' + userId + '/password');
        form.submit();
    }
}

function deleteProfile(userId) {
    if (confirm('Are you sure you want to delete this user profile? This action cannot be undone.')) {
        var form = $('#deleteProfileForm');
        form.attr('action', '{{ url("admin/user-profiles") }}/' + userId);
        form.submit();
    }
}
</script>
@endpush
