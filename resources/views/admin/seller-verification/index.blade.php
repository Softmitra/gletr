@extends('adminlte::page')

@section('title', 'Seller Verification Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Seller Verification Dashboard</h1>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshStats()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>
@stop

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['total_pending'] }}</h3>
                    <p>Pending Verification</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['documents_pending'] }}</h3>
                    <p>Documents to Review</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['ready_for_approval'] }}</h3>
                    <p>Ready for Approval</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['verified_today'] }}</h3>
                    <p>Verified Today</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['rejected'] }}</h3>
                    <p>Rejected</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
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
            <form method="GET" action="{{ route('admin.seller-verification.index') }}" class="row">
                <div class="col-md-3">
                    <label for="verification_status">Verification Status</label>
                    <select name="verification_status" id="verification_status" class="form-control">
                        <option value="all" {{ request('verification_status', 'pending') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('verification_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="documents_verified" {{ request('verification_status') == 'documents_verified' ? 'selected' : '' }}>Documents Verified</option>
                        <option value="verified" {{ request('verification_status') == 'verified' ? 'selected' : '' }}>Fully Verified</option>
                        <option value="rejected" {{ request('verification_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search">Search</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Name, Email, Business..." value="{{ request('search') }}">
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
                    <label>&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.seller-verification.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sellers List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Sellers 
                @if($verificationStatus !== 'all')
                    - {{ ucfirst(str_replace('_', ' ', $verificationStatus)) }}
                @endif
                ({{ $sellers->total() }})
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Seller Info</th>
                        <th>Business Details</th>
                        <th>Registration Date</th>
                        <th>Verification Status</th>
                        <th>Expert Reviewer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        <tr>
                            <td>
                                <div class="user-panel d-flex">
                                    <div class="image">
                                        <img src="{{ $seller->image ? Storage::url($seller->image) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" 
                                             class="img-circle elevation-2" alt="User Image" style="width: 40px; height: 40px;">
                                    </div>
                                    <div class="info">
                                        <strong>{{ $seller->name }}</strong><br>
                                        <small class="text-muted">{{ $seller->email }}</small><br>
                                        <small class="text-muted">{{ $seller->phone }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $seller->business_name }}</strong><br>
                                <small class="text-muted">
                                    {{ $seller->sellerType->name ?? 'N/A' }}<br>
                                    {{ $seller->city }}, {{ $seller->state }}
                                </small>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $seller->created_at->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $seller->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                @php
                                    $statusConfig = [
                                        'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Pending'],
                                        'documents_verified' => ['class' => 'primary', 'icon' => 'check', 'text' => 'Docs Verified'],
                                        'verified' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Verified'],
                                        'rejected' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Rejected'],
                                    ];
                                    $config = $statusConfig[$seller->verification_status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Unknown'];
                                @endphp
                                <span class="badge badge-{{ $config['class'] }}">
                                    <i class="fas fa-{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                </span>
                                @if($seller->verification_completed_at)
                                    <br><small class="text-muted">{{ $seller->verification_completed_at->format('M d, Y') }}</small>
                                @endif
                            </td>
                            <td>
                                @if($seller->expertReviewer)
                                    <span class="badge badge-info">{{ $seller->expertReviewer->name }}</span>
                                @else
                                    <span class="text-muted">Not Assigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.seller-verification.show', $seller) }}" 
                                       class="btn btn-sm btn-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($seller->verification_status === 'documents_verified')
                                        @can('approve seller verification')
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    onclick="approveSeller({{ $seller->id }})" title="Approve Seller">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endcan
                                    @endif
                                    @can('manage verification workflow')
                                        <button type="button" class="btn btn-sm btn-info" 
                                                onclick="assignReviewer({{ $seller->id }})" title="Assign Reviewer">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                No sellers found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sellers->hasPages())
            <div class="card-footer">
                {{ $sellers->links() }}
            </div>
        @endif
    </div>

    <!-- Assign Reviewer Modal -->
    <div class="modal fade" id="assignReviewerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Expert Reviewer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="assignReviewerForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reviewer_id">Select Reviewer</label>
                            <select name="reviewer_id" id="reviewer_id" class="form-control" required>
                                <option value="">Choose a reviewer...</option>
                                @foreach(\App\Models\User::permission('verify seller documents')->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Reviewer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Approve Seller Modal -->
    <div class="modal fade" id="approveSellerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Approve Seller</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="approveSellerForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            This will approve the seller and activate their account. They will be able to start selling immediately.
                        </div>
                        <div class="form-group">
                            <label for="approval_comments">Comments (Optional)</label>
                            <textarea name="comments" id="approval_comments" class="form-control" rows="3" 
                                      placeholder="Add any comments about the approval..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Approve Seller
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
function assignReviewer(sellerId) {
    const form = document.getElementById('assignReviewerForm');
    form.action = `/admin/seller-verification/${sellerId}/assign-reviewer`;
    $('#assignReviewerModal').modal('show');
}

function approveSeller(sellerId) {
    const form = document.getElementById('approveSellerForm');
    form.action = `/admin/seller-verification/${sellerId}/approve`;
    $('#approveSellerModal').modal('show');
}

function refreshStats() {
    // Reload the page to refresh statistics
    window.location.reload();
}

// Auto-submit form when verification status changes
document.getElementById('verification_status').addEventListener('change', function() {
    this.form.submit();
});
</script>
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

.user-panel .info {
    margin-left: 10px;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.875em;
}
</style>
@stop
