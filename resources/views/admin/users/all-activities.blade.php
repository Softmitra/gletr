@extends('layouts.admin')

@section('title', 'All User Activities')

@section('page_title', 'All User Activities')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">All Activities</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_activities'] }}</h3>
                    <p>Total Activities</p>
                </div>
                <div class="icon">
                    <i class="fas fa-history"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['total_logins'] }}</h3>
                    <p>Total Logins</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['total_page_views'] }}</h3>
                    <p>Page Views</p>
                </div>
                <div class="icon">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['today_activities'] }}</h3>
                    <p>Today's Activities</p>
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
            <form method="GET" action="{{ route('admin.users.all-activities') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="text" class="form-control" id="user" name="user" value="{{ request('user') }}" placeholder="Search by name or email">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="activity_type">Activity Type</label>
                            <select class="form-control" id="activity_type" name="activity_type">
                                <option value="">All</option>
                                <option value="login" {{ request('activity_type') === 'login' ? 'selected' : '' }}>Login</option>
                                <option value="logout" {{ request('activity_type') === 'logout' ? 'selected' : '' }}>Logout</option>
                                <option value="page_view" {{ request('activity_type') === 'page_view' ? 'selected' : '' }}>Page View</option>
                                <option value="action" {{ request('activity_type') === 'action' ? 'selected' : '' }}>Action</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="action">Action</label>
                            <input type="text" class="form-control" id="action" name="action" value="{{ request('action') }}" placeholder="Action name">
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
                        <a href="{{ route('admin.users.all-activities') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All User Activities</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Activity</th>
                        <th>Type</th>
                        <th>IP Address</th>
                        <th>URL</th>
                        <th>Method</th>
                        <th>Response Time</th>
                        <th>Status</th>
                        <th>Timestamp</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm mr-2">
                                    <div class="avatar-title bg-primary rounded-circle" style="width: 32px; height: 32px; font-size: 0.875rem; line-height: 32px;">
                                        {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ $activity->user->name }}</div>
                                    <small class="text-muted">{{ $activity->user->email }}</small>
                                </div>
                            </div>
                        </td>
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
                            @if($activity->method)
                                <span class="badge badge-{{ $activity->method === 'GET' ? 'success' : ($activity->method === 'POST' ? 'warning' : 'info') }}">
                                    {{ $activity->method }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($activity->response_time)
                                <span class="badge badge-info">{{ $activity->formatted_response_time }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($activity->status_code)
                                <span class="badge badge-{{ $activity->status_code_color }}">
                                    {{ $activity->status_code }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $activity->created_at->format('M d, Y H:i:s') }}</div>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.show', $activity->user) }}" class="btn btn-sm btn-outline-primary" title="View User">
                                    <i class="fas fa-user"></i>
                                </a>
                                @if($activity->session)
                                    <a href="{{ route('admin.users.sessions', $activity->user) }}" class="btn btn-sm btn-outline-info" title="View Sessions">
                                        <i class="fas fa-desktop"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-history fa-3x mb-3"></i>
                                <p>No activities found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
