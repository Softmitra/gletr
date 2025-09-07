@extends('layouts.admin')

@section('title', 'User Activities')

@section('page_title', 'User Activities')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Activities</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
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
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['today_activities'] }}</h3>
                    <p>Today's Activities</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['this_week_activities'] }}</h3>
                    <p>This Week</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['this_month_activities'] }}</h3>
                    <p>This Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
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
            <form method="GET" action="{{ route('admin.users.activities', $user) }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="activity_type">Activity Type</label>
                        <select class="form-control" id="activity_type" name="activity_type">
                            <option value="">All Types</option>
                            @foreach($activityTypes as $type)
                                <option value="{{ $type }}" {{ request('activity_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="action">Action</label>
                        <input type="text" class="form-control" id="action" name="action" 
                               value="{{ request('action') }}" placeholder="Action">
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Activities for {{ $user->name }}</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Type</th>
                        <th>Action</th>
                        <th>Resource</th>
                        <th>IP Address</th>
                        <th>URL</th>
                        <th>Method</th>
                        <th>Response Time</th>
                        <th>Status</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
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
                        <td>
                            @if($activity->action)
                                <span class="badge badge-info">{{ ucfirst($activity->action) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($activity->resource_type && $activity->resource_id)
                                <div>{{ ucfirst($activity->resource_type) }}</div>
                                <small class="text-muted">ID: {{ $activity->resource_id }}</small>
                                @if($activity->resource_name)
                                    <br><small class="text-info">{{ $activity->resource_name }}</small>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <code>{{ $activity->ip_address }}</code>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" title="{{ $activity->url }}">
                                {{ $activity->url }}
                            </div>
                        </td>
                        <td>
                            @if($activity->method)
                                <span class="badge badge-secondary">{{ $activity->method }}</span>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
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
        <div class="card-footer">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
