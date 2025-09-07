@extends('layouts.admin')

@section('title', 'User Details')

@section('page_title', 'User Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- User Information Card -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-lg mx-auto">
                            <div class="avatar-title bg-primary rounded-circle" style="width: 80px; height: 80px; font-size: 2rem; line-height: 80px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <h4 class="mt-2">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>
                    
                    <div class="user-info">
                        <div class="row mb-2">
                            <div class="col-6"><strong>Status:</strong></div>
                            <div class="col-6">
                                <span class="badge badge-{{ $user->status_color }}">
                                    <i class="{{ $user->status_icon }}"></i>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-6"><strong>Roles:</strong></div>
                            <div class="col-6">
                                @foreach($user->roles as $role)
                                    <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-6"><strong>Created:</strong></div>
                            <div class="col-6">{{ $user->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-6"><strong>Last Login:</strong></div>
                            <div class="col-6">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('M d, Y H:i') }}
                                    <br><small class="text-muted">{{ $user->last_login_ip }}</small>
                                @else
                                    <span class="text-muted">Never</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($user->isLocked())
                        <div class="row mb-2">
                            <div class="col-6"><strong>Locked Until:</strong></div>
                            <div class="col-6 text-danger">{{ $user->locked_until->format('M d, Y H:i') }}</div>
                        </div>
                        @endif
                        
                        @if($user->suspended_at)
                        <div class="row mb-2">
                            <div class="col-6"><strong>Suspended:</strong></div>
                            <div class="col-6 text-warning">{{ $user->suspended_at->format('M d, Y H:i') }}</div>
                        </div>
                        @endif
                        
                        @if($user->banned_at)
                        <div class="row mb-2">
                            <div class="col-6"><strong>Banned:</strong></div>
                            <div class="col-6 text-danger">{{ $user->banned_at->format('M d, Y H:i') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Activity Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $activityStats['total_logins'] }}</h3>
                            <p>Total Logins</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $activityStats['total_page_views'] }}</h3>
                            <p>Page Views</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $activityStats['total_actions'] }}</h3>
                            <p>Actions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cog"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $recentSessions->count() }}</h3>
                            <p>Recent Sessions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group">
                        @if($user->isActive())
                            <button type="button" class="btn btn-warning" onclick="suspendUser({{ $user->id }})">
                                <i class="fas fa-pause"></i> Suspend
                            </button>
                        @else
                            <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-play"></i> Activate
                                </button>
                            </form>
                        @endif
                        
                        <button type="button" class="btn btn-danger" onclick="banUser({{ $user->id }})">
                            <i class="fas fa-ban"></i> Ban
                        </button>
                        
                        <button type="button" class="btn btn-info" onclick="resetPassword({{ $user->id }})">
                            <i class="fas fa-key"></i> Reset Password
                        </button>
                        
                        <form action="{{ route('admin.users.terminate-all-sessions', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-sign-out-alt"></i> Terminate All Sessions
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Sessions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Sessions</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.sessions', $user) }}" class="btn btn-sm btn-outline-primary">
                    View All Sessions
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Session ID</th>
                        <th>Device</th>
                        <th>Browser</th>
                        <th>IP Address</th>
                        <th>Login Time</th>
                        <th>Last Activity</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSessions as $session)
                    <tr>
                        <td><code>{{ substr($session->session_id, 0, 8) }}...</code></td>
                        <td>
                            <i class="{{ $session->device_icon }}"></i>
                            {{ ucfirst($session->device_type ?? 'Unknown') }}
                        </td>
                        <td>
                            <i class="{{ $session->browser_icon }}"></i>
                            {{ $session->browser ?? 'Unknown' }}
                        </td>
                        <td><code>{{ $session->ip_address }}</code></td>
                        <td>
                            <div>{{ $session->login_at->format('M d, Y H:i') }}</div>
                            <small class="text-muted">{{ $session->login_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if($session->last_activity_at)
                                <div>{{ $session->last_activity_at->format('M d, Y H:i') }}</div>
                                <small class="text-muted">{{ $session->last_activity_at->diffForHumans() }}</small>
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </td>
                        <td><span class="badge badge-info">{{ $session->formatted_duration }}</span></td>
                        <td>
                            @if($session->is_active)
                                <span class="badge badge-success">
                                    <i class="fas fa-circle"></i> Active
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times-circle"></i> Inactive
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-desktop fa-3x mb-3"></i>
                                <p>No sessions found for this user</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Activities</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.activities', $user) }}" class="btn btn-sm btn-outline-primary">
                    View All Activities
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Type</th>
                        <th>IP Address</th>
                        <th>URL</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivities as $activity)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="{{ $activity->activity_icon }} mr-2"></i>
                                <div>
                                    <div class="font-weight-bold">{{ $activity->human_description }}</div>
                                    @if($activity->description)
                                        <small class="text-muted">{{ $activity->description }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $activity->activity_color }}">
                                {{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}
                            </span>
                        </td>
                        <td><code>{{ $activity->ip_address }}</code></td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" title="{{ $activity->url }}">
                                {{ $activity->url }}
                            </div>
                        </td>
                        <td>
                            <div>{{ $activity->created_at->format('M d, Y H:i:s') }}</div>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-history fa-3x mb-3"></i>
                                <p>No activities found for this user</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
