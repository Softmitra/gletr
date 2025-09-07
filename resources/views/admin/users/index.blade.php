@extends('layouts.admin')

@section('title', 'User Management')

@section('page_title', 'User Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6">
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
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['active_users'] }}</h3>
                    <p>Active Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['suspended_users'] }}</h3>
                    <p>Suspended</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['banned_users'] }}</h3>
                    <p>Banned</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['online_users'] }}</h3>
                    <p>Online Now</p>
                </div>
                <div class="icon">
                    <i class="fas fa-circle text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['today_logins'] }}</h3>
                    <p>Today's Logins</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filters & Search</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Name or Email">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_from">From Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_to">To Date</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users List</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#bulkActionModal">
                    <i class="fas fa-tasks"></i> Bulk Actions
                </button>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Roles</th>
                        <th>Last Login</th>
                        <th>Sessions</th>
                        <th>Activities</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox" class="user-select" value="{{ $user->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm mr-3">
                                    <div class="avatar-title bg-primary rounded-circle">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $user->status_color }}">
                                <i class="{{ $user->status_icon }}"></i>
                                {{ ucfirst($user->status) }}
                            </span>
                            @if($user->isLocked())
                                <br><small class="text-danger">Account Locked</small>
                            @endif
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($user->last_login_at)
                                <div>{{ $user->last_login_at->format('M d, Y H:i') }}</div>
                                <small class="text-muted">{{ $user->last_login_ip }}</small>
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-secondary">{{ $user->sessions_count }}</span>
                                @if($user->activeSessions()->count() > 0)
                                    <span class="badge badge-success ml-1">{{ $user->activeSessions()->count() }} active</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $user->activities_count }}</span>
                        </td>
                        <td>
                            <div>{{ $user->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.sessions', $user) }}" class="btn btn-sm btn-warning" title="View Sessions">
                                    <i class="fas fa-desktop"></i>
                                </a>
                                <a href="{{ route('admin.users.activities', $user) }}" class="btn btn-sm btn-secondary" title="View Activities">
                                    <i class="fas fa-history"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    @if($user->isActive())
                                        <button type="button" class="dropdown-item text-warning" onclick="suspendUser({{ $user->id }})">
                                            <i class="fas fa-pause"></i> Suspend
                                        </button>
                                    @else
                                        <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-success">
                                                <i class="fas fa-play"></i> Activate
                                            </button>
                                        </form>
                                    @endif
                                    <button type="button" class="dropdown-item text-danger" onclick="banUser({{ $user->id }})">
                                        <i class="fas fa-ban"></i> Ban
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item" onclick="resetPassword({{ $user->id }})">
                                        <i class="fas fa-key"></i> Reset Password
                                    </button>
                                    <form action="{{ route('admin.users.terminate-all-sessions', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-warning">
                                            <i class="fas fa-sign-out-alt"></i> Terminate All Sessions
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <p>No users found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.bulk-action') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulk_action">Action</label>
                        <select class="form-control" id="bulk_action" name="action" required>
                            <option value="">Select Action</option>
                            <option value="suspend">Suspend Users</option>
                            <option value="activate">Activate Users</option>
                            <option value="ban">Ban Users</option>
                            <option value="terminate_sessions">Terminate All Sessions</option>
                        </select>
                    </div>
                    <div id="selected-users-count" class="alert alert-info" style="display: none;">
                        <span id="count-text">0</span> users selected
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Action</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Suspend User Modal -->
<div class="modal fade" id="suspendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suspend User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="suspendForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="suspend_reason">Reason for Suspension</label>
                        <textarea class="form-control" id="suspend_reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Suspend User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ban User Modal -->
<div class="modal fade" id="banModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ban User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="banForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ban_reason">Reason for Ban</label>
                        <textarea class="form-control" id="ban_reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Ban User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset User Password</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="resetPasswordForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Select all functionality
    $('#select-all').change(function() {
        $('.user-select').prop('checked', $(this).prop('checked'));
        updateSelectedCount();
    });

    $('.user-select').change(function() {
        updateSelectedCount();
    });

    function updateSelectedCount() {
        const count = $('.user-select:checked').length;
        if (count > 0) {
            $('#selected-users-count').show();
            $('#count-text').text(count);
            
            // Add selected user IDs to bulk action form
            const selectedIds = $('.user-select:checked').map(function() {
                return $(this).val();
            }).get();
            
            // Remove existing hidden inputs
            $('input[name="user_ids[]"]').remove();
            
            // Add new hidden inputs
            selectedIds.forEach(function(id) {
                $('#bulkActionModal form').append('<input type="hidden" name="user_ids[]" value="' + id + '">');
            });
        } else {
            $('#selected-users-count').hide();
        }
    }
});

function suspendUser(userId) {
    $('#suspendForm').attr('action', '{{ url("admin/users") }}/' + userId + '/suspend');
    $('#suspendModal').modal('show');
}

function banUser(userId) {
    $('#banForm').attr('action', '{{ url("admin/users") }}/' + userId + '/ban');
    $('#banModal').modal('show');
}

function resetPassword(userId) {
    $('#resetPasswordForm').attr('action', '{{ url("admin/users") }}/' + userId + '/reset-password');
    $('#resetPasswordModal').modal('show');
}
</script>
@endpush
