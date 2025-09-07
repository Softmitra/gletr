@extends('adminlte::page')

@section('title', 'Seller Sessions')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Seller Session Management</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.seller-sessions.analytics') }}" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar"></i> Analytics
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
                    <h3>{{ number_format($stats['total_sessions']) }}</h3>
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
                    <h3>{{ number_format($stats['active_sessions']) }}</h3>
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
                    <h3>{{ number_format($stats['sessions_today']) }}</h3>
                    <p>Sessions Today</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['suspicious_activities']) }}</h3>
                    <p>Suspicious Activities</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Unique Sellers</span>
                    <span class="info-box-number">{{ number_format($stats['unique_sellers']) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fas fa-mobile-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Device Types</span>
                    <span class="info-box-number">{{ number_format($stats['unique_devices']) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-map-marker-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Locations</span>
                    <span class="info-box-number">{{ number_format($stats['unique_locations']) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-calendar-week"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">This Week</span>
                    <span class="info-box-number">{{ number_format($stats['sessions_this_week']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i> Filters
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.seller-sessions.index') }}" class="row">
                <div class="col-md-2">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All Sessions</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="seller_id">Seller</label>
                    <select name="seller_id" id="seller_id" class="form-control">
                        <option value="">All Sellers</option>
                        @foreach($sellers as $seller)
                            <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                {{ $seller->business_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="device_type">Device Type</label>
                    <select name="device_type" id="device_type" class="form-control">
                        <option value="">All Devices</option>
                        <option value="desktop" {{ request('device_type') == 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="mobile" {{ request('device_type') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="tablet" {{ request('device_type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to">To Date</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label for="search">Search</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Seller, IP, Location..." value="{{ request('search') }}">
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.seller-sessions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sessions List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i> Sessions ({{ $sessions->total() }})
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Seller</th>
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
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($session->seller->image)
                                        <img src="{{ asset('storage/' . $session->seller->image) }}" 
                                             class="img-circle mr-2" 
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                             style="width: 32px; height: 32px; font-size: 14px; color: white;">
                                            {{ substr($session->seller->business_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $session->seller->business_name }}</strong><br>
                                        <small class="text-muted">{{ $session->seller->email }}</small>
                                    </div>
                                </div>
                            </td>
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
                                    <span class="badge badge-success">
                                        <i class="fas fa-circle"></i> Active
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.seller-sessions.show', $session) }}" 
                                       class="btn btn-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($session->is_active)
                                        <button type="button" class="btn btn-danger" 
                                                onclick="terminateSession({{ $session->id }})" 
                                                title="Terminate Session">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-desktop fa-3x mb-3"></i><br>
                                No sessions found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sessions->hasPages())
            <div class="card-footer">
                {{ $sessions->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@stop

@section('css')
<style>
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

.info-box-number {
    font-weight: bold;
}
</style>
@stop

@section('js')
<script>
function terminateSession(sessionId) {
    if (confirm('Are you sure you want to terminate this session?')) {
        const reason = prompt('Reason for termination (optional):');
        
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/seller-sessions/${sessionId}/terminate`;
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        // Add reason if provided
        if (reason) {
            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'reason';
            reasonInput.value = reason;
            form.appendChild(reasonInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-refresh active sessions every 30 seconds
@if(request('status') === 'active' || request('status', 'all') === 'all')
setInterval(function() {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
}, 30000);
@endif
</script>
@stop
