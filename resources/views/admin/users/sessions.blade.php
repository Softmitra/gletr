@extends('layouts.admin')

@section('title', 'User Sessions')

@section('page_title', 'User Sessions')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Sessions</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
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
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['active_sessions'] }}</h3>
                    <p>Active Sessions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-circle text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ gmdate('H:i:s', $stats['total_duration']) }}</h3>
                    <p>Total Duration</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ gmdate('H:i:s', $stats['avg_duration']) }}</h3>
                    <p>Avg Duration</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sessions Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sessions for {{ $user->name }}</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Session ID</th>
                        <th>Device</th>
                        <th>Browser</th>
                        <th>Platform</th>
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
                            <code>{{ substr($session->session_id, 0, 8) }}...</code>
                        </td>
                        <td>
                            <i class="{{ $session->device_icon }}"></i>
                            {{ ucfirst($session->device_type ?? 'Unknown') }}
                        </td>
                        <td>
                            <i class="{{ $session->browser_icon }}"></i>
                            {{ $session->browser ?? 'Unknown' }}
                        </td>
                        <td>
                            <i class="{{ $session->platform_icon }}"></i>
                            {{ $session->platform ?? 'Unknown' }}
                        </td>
                        <td>
                            <code>{{ $session->ip_address }}</code>
                        </td>
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
                        <td>
                            <span class="badge badge-info">{{ $session->formatted_duration }}</span>
                        </td>
                        <td>
                            @if($session->is_active)
                                <span class="badge badge-success">
                                    <i class="fas fa-circle"></i> Active
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times-circle"></i> Inactive
                                </span>
                                @if($session->logout_reason)
                                    <br><small class="text-muted">{{ ucfirst($session->logout_reason) }}</small>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($session->is_active)
                                <form action="{{ route('admin.users.terminate-session', $session) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to terminate this session?')">
                                        <i class="fas fa-times"></i> Terminate
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
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
        <div class="card-footer">
            {{ $sessions->links() }}
        </div>
    </div>
</div>
@endsection
