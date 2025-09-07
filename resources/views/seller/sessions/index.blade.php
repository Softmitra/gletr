@extends('seller.layouts.app')

@section('title', 'Session Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Session Management</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('seller.sessions.activity') }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-history"></i> Activity Log
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
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
                    <i class="fas fa-circle text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['sessions_today'] }}</h3>
                    <p>Sessions Today</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['unique_devices'] }}</h3>
                    <p>Unique Devices</p>
                </div>
                <div class="icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Security Actions</h5>
                            <p class="mb-0">Manage your active sessions for better security</p>
                        </div>
                        <div>
                            @if($stats['active_sessions'] > 1)
                                <form method="POST" action="{{ route('seller.sessions.terminate-all') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('This will terminate all other sessions. Continue?')">
                                        <i class="fas fa-sign-out-alt"></i> Terminate All Other Sessions
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Only one active session</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filters</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('seller.sessions.index') }}" class="row">
                <div class="col-md-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Sessions</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to">To Date</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('seller.sessions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sessions List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Your Sessions ({{ $sessions->total() }})</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Device & Browser</th>
                        <th>Location & IP</th>
                        <th>Login Time</th>
                        <th>Last Activity</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                        <tr class="{{ $session->isCurrentSession() ? 'table-success' : '' }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="{{ $session->device_icon }} fa-lg mr-2 text-muted"></i>
                                    <div>
                                        <strong>{{ ucfirst($session->device_type ?? 'Unknown') }}</strong>
                                        @if($session->browser)
                                            <br><small class="text-muted">
                                                <i class="{{ $session->browser_icon }} mr-1"></i>
                                                {{ $session->browser }}
                                            </small>
                                        @endif
                                        @if($session->platform)
                                            <br><small class="text-muted">
                                                <i class="{{ $session->platform_icon }} mr-1"></i>
                                                {{ $session->platform }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($session->location)
                                    <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                                    {{ $session->location }}<br>
                                @endif
                                <small class="text-muted">{{ $session->ip_address }}</small>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $session->login_at->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $session->login_at->format('H:i:s') }}</small>
                            </td>
                            <td>
                                @if($session->is_active)
                                    <span class="text-success">{{ $session->last_activity->diffForHumans() }}</span>
                                @else
                                    <span class="text-muted">{{ $session->logout_at ? $session->logout_at->diffForHumans() : 'N/A' }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $session->duration }}</span>
                            </td>
                            <td>
                                @if($session->is_active)
                                    @if($session->isCurrentSession())
                                        <span class="badge badge-success">
                                            <i class="fas fa-circle"></i> Current Session
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-circle"></i> Active
                                        </span>
                                    @endif
                                @else
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($session->is_active && !$session->isCurrentSession())
                                    <form method="POST" action="{{ route('seller.sessions.destroy', $session->session_id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Terminate this session?')" title="Terminate Session">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                @elseif($session->isCurrentSession())
                                    <span class="text-muted">Current</span>
                                @else
                                    <span class="text-muted">Ended</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-desktop fa-3x mb-3"></i><br>
                                No sessions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sessions->hasPages())
            <div class="card-footer">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>

    <!-- Security Tips -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-shield-alt"></i> Security Tips
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Keep Your Account Secure</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success mr-2"></i> Regularly review your active sessions</li>
                        <li><i class="fas fa-check text-success mr-2"></i> Terminate unknown or suspicious sessions</li>
                        <li><i class="fas fa-check text-success mr-2"></i> Always logout from public computers</li>
                        <li><i class="fas fa-check text-success mr-2"></i> Use strong, unique passwords</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Suspicious Activity</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-exclamation-triangle text-warning mr-2"></i> Logins from unknown locations</li>
                        <li><i class="fas fa-exclamation-triangle text-warning mr-2"></i> Multiple rapid login attempts</li>
                        <li><i class="fas fa-exclamation-triangle text-warning mr-2"></i> Sessions from unusual devices</li>
                        <li><i class="fas fa-exclamation-triangle text-warning mr-2"></i> Activity during odd hours</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
.table-success {
    background-color: rgba(40, 167, 69, 0.1);
}

.small-box .inner h3 {
    font-size: 2.2rem;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}

.badge {
    font-size: 0.875em;
}
</style>
@stop
