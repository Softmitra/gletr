@extends('layouts.admin')

@section('title', 'All User Sessions')

@section('page_title', 'All User Sessions')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">All Sessions</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_sessions'] }}</h3>
                    <p>Total Sessions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-desktop"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['active_sessions'] }}</h3>
                    <p>Active Sessions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['total_users'] }}</h3>
                    <p>Unique Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['today_sessions'] }}</h3>
                    <p>Today's Sessions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filters</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.all-sessions') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="text" class="form-control" id="user" name="user" value="{{ request('user') }}" placeholder="Search by name or email">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="device">Device</label>
                            <select class="form-control" id="device" name="device">
                                <option value="">All</option>
                                <option value="desktop" {{ request('device') === 'desktop' ? 'selected' : '' }}>Desktop</option>
                                <option value="mobile" {{ request('device') === 'mobile' ? 'selected' : '' }}>Mobile</option>
                                <option value="tablet" {{ request('device') === 'tablet' ? 'selected' : '' }}>Tablet</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="browser">Browser</label>
                            <input type="text" class="form-control" id="browser" name="browser" value="{{ request('browser') }}" placeholder="Browser name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">Date From</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.users.all-sessions') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sessions Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All User Sessions</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Session ID</th>
                        <th>Device</th>
                        <th>Browser</th>
                        <th>IP Address</th>
                        <th>Login Time</th>
                        <th>Last Activity</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm mr-2">
                                    <div class="avatar-title bg-primary rounded-circle" style="width: 32px; height: 32px; font-size: 0.875rem; line-height: 32px;">
                                        {{ strtoupper(substr($session->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ $session->user->name }}</div>
                                    <small class="text-muted">{{ $session->user->email }}</small>
                                </div>
                            </div>
                        </td>
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
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.show', $session->user) }}" class="btn btn-sm btn-outline-primary" title="View User">
                                    <i class="fas fa-user"></i>
                                </a>
                                @if($session->is_active)
                                    <form action="{{ route('admin.users.terminate-session', $session) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Terminate Session" onclick="return confirm('Are you sure you want to terminate this session?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-desktop fa-3x mb-3"></i>
                                <p>No sessions found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $sessions->links() }}
        </div>
    </div>
</div>
@endsection
