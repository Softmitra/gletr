@extends('adminlte::page')

@section('title', 'Seller Session Analytics')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Seller Session Analytics</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.seller-sessions.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Sessions
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Period Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.seller-sessions.analytics') }}" class="d-inline-flex align-items-center">
                        <label for="period" class="mr-2 mb-0">Time Period:</label>
                        <select name="period" id="period" class="form-control mr-2" style="width: auto;">
                            <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="14" {{ $period == 14 ? 'selected' : '' }}>Last 14 Days</option>
                            <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="60" {{ $period == 60 ? 'selected' : '' }}>Last 60 Days</option>
                            <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 Days</option>
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-refresh"></i> Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Sessions Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i> Daily Session Activity
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="dailySessionsChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Device and Browser Analytics -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-mobile-alt"></i> Device Types
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="deviceChart" style="height: 250px;"></canvas>
                    <div class="mt-3">
                        @foreach($deviceStats as $device)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>
                                    <i class="fas fa-{{ $device->device_type == 'mobile' ? 'mobile-alt' : ($device->device_type == 'tablet' ? 'tablet-alt' : 'desktop') }} mr-2"></i>
                                    {{ ucfirst($device->device_type ?? 'Unknown') }}
                                </span>
                                <span class="badge badge-primary">{{ number_format($device->count) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-globe"></i> Top Browsers
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="browserChart" style="height: 250px;"></canvas>
                    <div class="mt-3">
                        @foreach($browserStats->take(5) as $browser)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>
                                    <i class="fab fa-{{ strtolower($browser->browser) }} mr-2"></i>
                                    {{ $browser->browser }}
                                </span>
                                <span class="badge badge-info">{{ number_format($browser->count) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location and Active Sellers -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt"></i> Top Locations
                    </h3>
                </div>
                <div class="card-body">
                    @if($locationStats->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-map-marker-alt fa-3x mb-3"></i><br>
                            No location data available
                        </div>
                    @else
                        @foreach($locationStats as $location)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                                    <strong>{{ $location->location }}</strong>
                                </div>
                                <div>
                                    <span class="badge badge-warning">{{ number_format($location->count) }} sessions</span>
                                </div>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-warning" 
                                     style="width: {{ ($location->count / $locationStats->first()->count) * 100 }}%"></div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> Most Active Sellers
                    </h3>
                </div>
                <div class="card-body">
                    @if($activeSellerStats->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-users fa-3x mb-3"></i><br>
                            No seller activity data
                        </div>
                    @else
                        @foreach($activeSellerStats as $sellerStat)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    @if($sellerStat->seller->image)
                                        <img src="{{ asset('storage/' . $sellerStat->seller->image) }}" 
                                             class="img-circle mr-2" 
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                             style="width: 32px; height: 32px; font-size: 14px; color: white;">
                                            {{ substr($sellerStat->seller->business_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $sellerStat->seller->business_name }}</strong><br>
                                        <small class="text-muted">{{ $sellerStat->seller->email }}</small>
                                    </div>
                                </div>
                                <div>
                                    <span class="badge badge-success">{{ number_format($sellerStat->session_count) }} sessions</span>
                                </div>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ ($sellerStat->session_count / $activeSellerStats->first()->session_count) * 100 }}%"></div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Session Insights -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lightbulb"></i> Session Insights
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Peak Hour</span>
                                    <span class="info-box-number">
                                        {{ $dailySessions->isNotEmpty() ? '10:00 AM' : 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-calendar-day"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Peak Day</span>
                                    <span class="info-box-number">
                                        {{ $dailySessions->isNotEmpty() ? $dailySessions->sortByDesc('total')->first()->date ?? 'N/A' : 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-mobile-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Mobile Usage</span>
                                    <span class="info-box-number">
                                        @php
                                            $totalSessions = $deviceStats->sum('count');
                                            $mobileSessions = $deviceStats->where('device_type', 'mobile')->first()->count ?? 0;
                                            $mobilePercentage = $totalSessions > 0 ? round(($mobileSessions / $totalSessions) * 100) : 0;
                                        @endphp
                                        {{ $mobilePercentage }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Avg Session/Day</span>
                                    <span class="info-box-number">
                                        {{ $dailySessions->isNotEmpty() ? round($dailySessions->avg('total')) : 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
.info-box-number {
    font-weight: bold;
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily Sessions Chart
const dailyCtx = document.getElementById('dailySessionsChart').getContext('2d');
const dailySessionsChart = new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: [
            @foreach($dailySessions as $day)
                '{{ \Carbon\Carbon::parse($day->date)->format('M d') }}',
            @endforeach
        ],
        datasets: [{
            label: 'Total Sessions',
            data: [
                @foreach($dailySessions as $day)
                    {{ $day->total }},
                @endforeach
            ],
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.1
        }, {
            label: 'Active Sessions',
            data: [
                @foreach($dailySessions as $day)
                    {{ $day->active }},
                @endforeach
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Device Chart
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
const deviceChart = new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($deviceStats as $device)
                '{{ ucfirst($device->device_type ?? 'Unknown') }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($deviceStats as $device)
                    {{ $device->count }},
                @endforeach
            ],
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Browser Chart
const browserCtx = document.getElementById('browserChart').getContext('2d');
const browserChart = new Chart(browserCtx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($browserStats->take(5) as $browser)
                '{{ $browser->browser }}',
            @endforeach
        ],
        datasets: [{
            label: 'Sessions',
            data: [
                @foreach($browserStats->take(5) as $browser)
                    {{ $browser->count }},
                @endforeach
            ],
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@stop
