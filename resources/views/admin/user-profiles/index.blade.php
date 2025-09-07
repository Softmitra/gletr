@extends('layouts.admin')

@section('title', 'User Profile Management')

@section('page_title', 'User Profile Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active">User Profiles</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_users'] }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['profiles_completed'] }}</h3>
                    <p>Profiles Completed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['profiles_incomplete'] }}</h3>
                    <p>Profiles Incomplete</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['active_users'] }}</h3>
                    <p>Active Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filters & Actions</h3>
            <div class="card-tools">
                <a href="{{ route('admin.user-profiles.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Create New Profile
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.user-profiles.index') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Name, email, phone...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="profile_status">Profile Status</label>
                            <select class="form-control" id="profile_status" name="profile_status">
                                <option value="">All</option>
                                <option value="complete" {{ request('profile_status') === 'complete' ? 'selected' : '' }}>Complete</option>
                                <option value="incomplete" {{ request('profile_status') === 'incomplete' ? 'selected' : '' }}>Incomplete</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role">
                                <option value="">All</option>
                                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="seller_owner" {{ request('role') === 'seller_owner' ? 'selected' : '' }}>Seller Owner</option>
                                <option value="seller_staff" {{ request('role') === 'seller_staff' ? 'selected' : '' }}>Seller Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.user-profiles.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bulk Actions</h3>
        </div>
        <div class="card-body">
            <form id="bulkActionForm" action="{{ route('admin.user-profiles.bulk-action') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bulk_action">Action</label>
                            <select class="form-control" id="bulk_action" name="action" required>
                                <option value="">Select Action</option>
                                <option value="activate">Activate</option>
                                <option value="deactivate">Deactivate</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-warning" id="bulkActionBtn" disabled>
                                    <i class="fas fa-tasks"></i> Apply to Selected
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Profiles</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>User</th>
                        <th>Profile</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Addresses</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm mr-2">
                                    @if($user->profile && $user->profile->profile_picture)
                                        <img src="{{ $user->profile->profile_picture_url }}" 
                                             alt="{{ $user->name }}" 
                                             class="img-circle" 
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="avatar-title bg-primary rounded-circle" style="width: 32px; height: 32px; font-size: 0.875rem; line-height: 32px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->profile)
                                <div class="d-flex align-items-center">
                                    <div class="progress mr-2" style="width: 60px; height: 6px;">
                                        <div class="progress-bar bg-{{ $user->profile->completion_percentage >= 80 ? 'success' : ($user->profile->completion_percentage >= 50 ? 'warning' : 'danger') }}" 
                                             style="width: {{ $user->profile->completion_percentage }}%"></div>
                                    </div>
                                    <small>{{ $user->profile->completion_percentage }}%</small>
                                </div>
                                @if($user->profile->date_of_birth)
                                    <small class="text-muted">{{ $user->profile->age }} years old</small>
                                @endif
                            @else
                                <span class="badge badge-secondary">No Profile</span>
                            @endif
                        </td>
                        <td>
                            @if($user->profile && $user->profile->phone)
                                <div>{{ $user->profile->formatted_phone }}</div>
                            @else
                                <span class="text-muted">No phone</span>
                            @endif
                            @if($user->profile && $user->profile->website)
                                <small><a href="{{ $user->profile->website }}" target="_blank">{{ $user->profile->website }}</a></small>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $user->status_color }}">
                                <i class="{{ $user->status_icon }}"></i>
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ $user->addresses->count() }} addresses</span>
                            @if($user->addresses->where('is_default', true)->count() > 0)
                                <small class="text-success d-block">Has default</small>
                            @endif
                        </td>
                        <td>
                            <div>{{ $user->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.user-profiles.show', $user) }}" class="btn btn-sm btn-outline-primary" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.user-profiles.edit', $user) }}" class="btn btn-sm btn-outline-info" title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-warning" title="Toggle Status" 
                                        onclick="toggleStatus({{ $user->id }})">
                                    <i class="fas fa-toggle-on"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete Profile" 
                                        onclick="deleteProfile({{ $user->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <p>No user profiles found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Toggle Status Form -->
<form id="toggleStatusForm" method="POST" style="display: none;">
    @csrf
</form>

<!-- Delete Profile Form -->
<form id="deleteProfileForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('js')
<script>
// Select all functionality
$('#selectAll').change(function() {
    $('.user-checkbox').prop('checked', $(this).is(':checked'));
    updateBulkActionButton();
});

$('.user-checkbox').change(function() {
    updateBulkActionButton();
    
    // Update select all checkbox
    var totalCheckboxes = $('.user-checkbox').length;
    var checkedCheckboxes = $('.user-checkbox:checked').length;
    
    if (checkedCheckboxes === 0) {
        $('#selectAll').prop('indeterminate', false).prop('checked', false);
    } else if (checkedCheckboxes === totalCheckboxes) {
        $('#selectAll').prop('indeterminate', false).prop('checked', true);
    } else {
        $('#selectAll').prop('indeterminate', true);
    }
});

function updateBulkActionButton() {
    var checkedCount = $('.user-checkbox:checked').length;
    var action = $('#bulk_action').val();
    
    if (checkedCount > 0 && action) {
        $('#bulkActionBtn').prop('disabled', false).text(`Apply to ${checkedCount} selected`);
    } else {
        $('#bulkActionBtn').prop('disabled', true).text('Apply to Selected');
    }
}

$('#bulk_action').change(function() {
    updateBulkActionButton();
});

// Bulk action confirmation
$('#bulkActionForm').submit(function(e) {
    var action = $('#bulk_action').val();
    var checkedCount = $('.user-checkbox:checked').length;
    
    if (action === 'delete') {
        if (!confirm(`Are you sure you want to delete ${checkedCount} user profiles? This action cannot be undone.`)) {
            e.preventDefault();
            return false;
        }
    }
});

function toggleStatus(userId) {
    if (confirm('Are you sure you want to toggle this user\'s status?')) {
        var form = $('#toggleStatusForm');
        form.attr('action', '{{ url("admin/user-profiles") }}/' + userId + '/toggle-status');
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
