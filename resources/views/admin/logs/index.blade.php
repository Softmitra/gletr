@extends('layouts.admin')

@section('page_title', 'System Logs')

@section('breadcrumbs')
    <li class="breadcrumb-item active">System Logs</li>
@stop

@push('css')
<style>
    /* Modern Log Viewer Styles */
    .logs-container {
        background: white;
        min-height: calc(100vh - 120px);
        padding: 2rem;
        margin: -1rem;
    }
    
    .logs-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
        overflow: hidden;
    }
    
    .logs-header {
        background: white;
        color: #333;
        padding: 2rem;
        position: relative;
        border-bottom: 1px solid #e9ecef;
    }
    
    .logs-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .logs-title {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 0;
    }
    
    .logs-title i {
        font-size: 2rem;
        color: #667eea;
    }
    
    .logs-title h5 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: #333;
    }
    
    .logs-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .btn-modern {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-modern:hover::before {
        left: 100%;
    }
    
    .btn-refresh {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .btn-download {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    
    .btn-clear {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }
    
    .logs-controls {
        padding: 2rem;
        background: white;
        border-bottom: 1px solid #e9ecef;
    }
    
    .controls-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }
    
    .control-group {
        position: relative;
    }
    
    .control-label {
        display: block;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .control-label i {
        color: #667eea;
        margin-right: 0.5rem;
    }
    
    .form-control-modern {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-box i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    
    .logs-stats {
        padding: 1.5rem 2rem;
        background: white;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .stats-info {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .stats-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .stat-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #495057;
    }
    
    .logs-content {
        padding: 2rem;
    }
    
    .logs-table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .logs-table {
        width: 100%;
        margin: 0;
    }
    
    .logs-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .logs-table thead th {
        padding: 1.25rem 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        border: none;
    }
    
    .logs-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .logs-table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .logs-table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border: none;
    }
    
    .log-level {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .level-error {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
    }
    
    .level-warning {
        background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
        color: #333;
    }
    
    .level-info {
        background: linear-gradient(135deg, #48cae4 0%, #0096c7 100%);
        color: white;
    }
    
    .level-debug {
        background: linear-gradient(135deg, #a8e6cf 0%, #88d8a3 100%);
        color: #333;
    }
    
    .log-timestamp {
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .log-message {
        font-size: 0.9rem;
        line-height: 1.5;
        max-width: 500px;
        word-break: break-word;
    }
    
    .message-preview {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .show-more-btn {
        color: #667eea;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.8rem;
    }
    
    .show-more-btn:hover {
        text-decoration: underline;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    /* Pagination Styles */
    .pagination-container {
        padding: 2rem;
        background: white;
        border-top: 1px solid #e9ecef;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .pagination-info-left {
        font-size: 0.9rem;
    }
    
    .pagination-nav .pagination {
        margin: 0;
    }
    
    .pagination .page-link {
        color: #667eea;
        border: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        margin: 0 0.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        min-width: 45px;
        text-align: center;
    }
    
    .pagination .page-link:hover {
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .pagination .page-item.active .page-link {
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .per-page-selector .form-select {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.5rem 2rem 0.5rem 0.75rem;
        font-size: 0.9rem;
        background-color: white;
        transition: all 0.3s ease;
    }
    
    .per-page-selector .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .pagination-info {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .logs-container {
            padding: 1rem;
            margin: -0.5rem;
        }
        
        .logs-header {
            padding: 1.5rem;
        }
        
        .logs-title h5 {
            font-size: 1.3rem;
        }
        
        .logs-title i {
            font-size: 1.5rem;
        }
        
        .controls-grid {
            grid-template-columns: 1fr;
        }
        
        .logs-table-container {
            overflow-x: auto;
        }
        
        .logs-table {
            min-width: 600px;
        }
        
        .pagination-wrapper {
            flex-direction: column;
            gap: 1.5rem;
            text-align: center;
        }
        
        .pagination-info-left {
            order: 3;
        }
        
        .pagination-nav {
            order: 1;
        }
        
        .per-page-selector {
            order: 2;
            justify-content: center;
        }
        
        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            min-width: 40px;
        }
    }
    
    /* Loading Animation */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('admin-content')
<div class="logs-container">
    <div class="logs-card">
        <!-- Header -->
        <div class="logs-header">
            <div class="logs-header-content">
                <div class="logs-title">
                    <i class="fas fa-file-alt"></i>
                    <h5>System Logs</h5>
                </div>
                <div class="logs-actions">
                    <button class="btn btn-modern btn-refresh" onclick="refreshLogs()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn btn-modern btn-download" onclick="downloadCurrentLog()">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <button class="btn btn-modern btn-clear" onclick="clearAllLogs()">
                        <i class="fas fa-trash"></i> Clear All
                    </button>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="logs-controls">
            <form id="logFilterForm" method="GET">
                <div class="controls-grid">
                    <div class="control-group">
                        <label class="control-label">
                            <i class="fas fa-file"></i> Log File
                        </label>
                        <select name="file" class="form-control-modern" onchange="this.form.submit()">
                            @foreach($files as $file)
                                <option value="{{ $file['name'] }}" {{ $selectedFile === $file['name'] ? 'selected' : '' }}>
                                    {{ $file['name'] }} ({{ $file['size'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">
                            <i class="fas fa-sort"></i> Sort Order
                        </label>
                        <select name="sort" class="form-control-modern" onchange="this.form.submit()">
                            <option value="desc" {{ request('sort', 'desc') === 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">
                            <i class="fas fa-filter"></i> Log Level
                        </label>
                        <select name="level" class="form-control-modern" onchange="this.form.submit()">
                            <option value="">All Levels</option>
                            <option value="error" {{ request('level') === 'error' ? 'selected' : '' }}>Error</option>
                            <option value="warning" {{ request('level') === 'warning' ? 'selected' : '' }}>Warning</option>
                            <option value="info" {{ request('level') === 'info' ? 'selected' : '' }}>Info</option>
                            <option value="debug" {{ request('level') === 'debug' ? 'selected' : '' }}>Debug</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">
                            <i class="fas fa-search"></i> Search Message
                        </label>
                        <div class="search-box">
                            <input type="text" name="search" class="form-control-modern" 
                                   placeholder="Search in log messages..." 
                                   value="{{ request('search') }}"
                                   onkeypress="if(event.key==='Enter') this.form.submit()">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Statistics -->
        @if(isset($logs) && is_array($logs) && isset($logs['data']) && count($logs['data']) > 0)
        <div class="logs-stats">
            <div class="stats-info">
                Showing {{ count($logs['data']) }} of {{ $logs['total'] ?? count($logs['data']) }} log entries from {{ $selectedFile }}
            </div>
            <div class="stats-badges">
                @if(isset($stats) && is_array($stats))
                    @if($stats['error'] > 0)
                        <span class="stat-badge">Errors: {{ $stats['error'] }}</span>
                    @endif
                    @if($stats['warning'] > 0)
                        <span class="stat-badge">Warnings: {{ $stats['warning'] }}</span>
                    @endif
                    @if($stats['info'] > 0)
                        <span class="stat-badge">Info: {{ $stats['info'] }}</span>
                    @endif
                    @if($stats['debug'] > 0)
                        <span class="stat-badge">Debug: {{ $stats['debug'] }}</span>
                    @endif
                @else
                    @php
                        $errorCount = collect($logs['data'])->where('level', 'ERROR')->count();
                        $warningCount = collect($logs['data'])->where('level', 'WARNING')->count();
                        $infoCount = collect($logs['data'])->where('level', 'INFO')->count();
                        $debugCount = collect($logs['data'])->where('level', 'DEBUG')->count();
                    @endphp
                    @if($errorCount > 0)
                        <span class="stat-badge">Errors: {{ $errorCount }}</span>
                    @endif
                    @if($warningCount > 0)
                        <span class="stat-badge">Warnings: {{ $warningCount }}</span>
                    @endif
                    @if($infoCount > 0)
                        <span class="stat-badge">Info: {{ $infoCount }}</span>
                    @endif
                    @if($debugCount > 0)
                        <span class="stat-badge">Debug: {{ $debugCount }}</span>
                    @endif
                @endif
            </div>
        </div>
        @endif

        <!-- Log Entries -->
        <div class="logs-content">
            @if(isset($logs) && is_array($logs) && isset($logs['data']) && count($logs['data']) > 0)
                <div class="logs-table-container">
                    <table class="logs-table">
                        <thead>
                            <tr>
                                <th width="150">Timestamp</th>
                                <th width="100">Level</th>
                                <th width="100">Environment</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs['data'] as $log)
                                <tr>
                                    <td class="log-timestamp">
                                        {{ $log['formatted_time'] ?? \Carbon\Carbon::parse($log['timestamp'])->format('M d, Y H:i:s') }}
                                    </td>
                                    <td>
                                        <span class="log-level level-{{ strtolower($log['level']) }}">
                                            {{ $log['level'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $log['environment'] ?? 'local' }}</span>
                                    </td>
                                    <td class="log-message">
                                        <div class="message-preview" id="message-{{ $loop->index }}">
                                            {{ Str::limit($log['message'], 150) }}
                                        </div>
                                        @if(strlen($log['message']) > 150)
                                            <a href="#" class="show-more-btn" onclick="toggleMessage({{ $loop->index }}); return false;">
                                                Show More
                                            </a>
                                            <div class="full-message" id="full-message-{{ $loop->index }}" style="display: none;">
                                                {{ $log['message'] }}
                                                <br>
                                                <a href="#" class="show-more-btn" onclick="toggleMessage({{ $loop->index }}); return false;">
                                                    Show Less
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if(isset($logs['last_page']) && $logs['last_page'] > 1)
                <div class="pagination-container">
                    <div class="pagination-wrapper">
                        <!-- Pagination Info -->
                        <div class="pagination-info-left">
                            <span class="text-muted">
                                Showing <strong>{{ (($logs['current_page'] - 1) * $logs['per_page']) + 1 }}</strong> to 
                                <strong>{{ min($logs['current_page'] * $logs['per_page'], $logs['total']) }}</strong> of 
                                <strong>{{ $logs['total'] }}</strong> entries
                            </span>
                        </div>
                        
                        <!-- Pagination Controls -->
                        <nav aria-label="Log pagination" class="pagination-nav">
                            <ul class="pagination mb-0">
                                <!-- First Page -->
                                @if($logs['current_page'] > 3)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" title="First Page">
                                            <i class="fas fa-angle-double-left"></i>
                                        </a>
                                    </li>
                                @endif
                                
                                <!-- Previous Page -->
                                @if($logs['current_page'] > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $logs['current_page'] - 1]) }}" title="Previous Page">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif
                                
                                <!-- Page Numbers -->
                                @for($i = max(1, $logs['current_page'] - 2); $i <= min($logs['last_page'], $logs['current_page'] + 2); $i++)
                                    <li class="page-item {{ $i == $logs['current_page'] ? 'active' : '' }}">
                                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                
                                <!-- Next Page -->
                                @if($logs['current_page'] < $logs['last_page'])
                                    <li class="page-item">
                                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $logs['current_page'] + 1]) }}" title="Next Page">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @endif
                                
                                <!-- Last Page -->
                                @if($logs['current_page'] < $logs['last_page'] - 2)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $logs['last_page']]) }}" title="Last Page">
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                        
                        <!-- Per Page Selector -->
                        <div class="per-page-selector">
                            <form method="GET" class="d-inline-flex align-items-center">
                                @foreach(request()->query() as $key => $value)
                                    @if($key !== 'per_page' && $key !== 'page')
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                                <label class="me-2 text-muted small">Show:</label>
                                <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                                    <option value="25" {{ request('per_page', 50) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page', 50) == 100 ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ request('per_page', 50) == 200 ? 'selected' : '' }}>200</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Simple Pagination Info (when only one page) -->
                @if(isset($logs) && is_array($logs) && isset($logs['data']) && count($logs['data']) > 0 && (!isset($logs['last_page']) || $logs['last_page'] <= 1))
                <div class="pagination-container">
                    <div class="pagination-wrapper">
                        <div class="pagination-info-left">
                            <span class="text-muted">
                                Showing <strong>{{ count($logs['data']) }}</strong> log entries from {{ $selectedFile }}
                            </span>
                        </div>
                        
                        <!-- Per Page Selector -->
                        <div class="per-page-selector">
                            <form method="GET" class="d-inline-flex align-items-center">
                                @foreach(request()->query() as $key => $value)
                                    @if($key !== 'per_page' && $key !== 'page')
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                                <label class="me-2 text-muted small">Show:</label>
                                <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                                    <option value="25" {{ request('per_page', 50) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page', 50) == 100 ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ request('per_page', 50) == 200 ? 'selected' : '' }}>200</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-file-alt"></i>
                    <h3>No Log Entries Found</h3>
                    <p>No log entries match your current filters, or the selected log file is empty.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay" style="display: none;">
    <div class="loading-spinner"></div>
</div>
@endsection

@push('js')
<script>
function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

function refreshLogs() {
    showLoading();
    window.location.reload();
}

function downloadCurrentLog() {
    const selectedFile = document.querySelector('select[name="file"]').value;
    if (selectedFile) {
        showLoading();
        window.location.href = `{{ url('admin/logs/download') }}?file=${selectedFile}`;
        setTimeout(hideLoading, 2000);
    }
}

function clearAllLogs() {
    if (confirm('Are you sure you want to clear all log files? This action cannot be undone.')) {
        showLoading();
        fetch('{{ url("admin/logs/clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                alert('All logs cleared successfully!');
                window.location.reload();
            } else {
                alert('Error clearing logs: ' + data.message);
            }
        })
        .catch(error => {
            hideLoading();
            alert('Error clearing logs: ' + error.message);
        });
    }
}

function toggleMessage(index) {
    const preview = document.getElementById(`message-${index}`);
    const full = document.getElementById(`full-message-${index}`);
    
    if (full.style.display === 'none') {
        preview.style.display = 'none';
        full.style.display = 'block';
    } else {
        preview.style.display = 'block';
        full.style.display = 'none';
    }
}

// Auto-refresh every 30 seconds
setInterval(function() {
    if (!document.hidden) {
        refreshLogs();
    }
}, 30000);

// Hide loading on page load
document.addEventListener('DOMContentLoaded', function() {
    hideLoading();
});
</script>
@endpush