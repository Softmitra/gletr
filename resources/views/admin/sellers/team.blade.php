@extends('layouts.admin')

@section('title', 'Seller Team Management')

@section('page_title', 'Team Management - ' . $seller->f_name . ' ' . $seller->l_name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.show', $seller) }}">{{ $seller->f_name }} {{ $seller->l_name }}</a></li>
    <li class="breadcrumb-item active">Team Management</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <!-- Seller Navigation -->
        <div class="col-md-3">
            <x-seller-navigation :seller="$seller" active-route="admin.sellers.team" />
        </div>
        
        <!-- Team Management Content -->
        <div class="col-md-9">
            <!-- Business Owner Section -->
            <div class="card">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-crown"></i> Business Owner Account
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light">Primary Account</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg me-4">
                            <div class="avatar-title bg-gradient-primary text-white rounded-circle" style="width: 60px; height: 60px; font-size: 24px; display: flex; align-items: center; justify-content: center;">
                                {{ strtoupper(substr($seller->f_name, 0, 1) . substr($seller->l_name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <h4 class="mb-0 me-3">{{ $seller->f_name }} {{ $seller->l_name }}</h4>
                                <span class="badge badge-success me-2">
                                    <i class="fas fa-crown"></i> Owner
                                </span>
                                <span class="badge badge-{{ $seller->status === 'active' ? 'success' : ($seller->status === 'suspended' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($seller->status) }}
                                </span>
                            </div>
                            <div class="text-muted mb-2">
                                <i class="fas fa-envelope me-1"></i> {{ $seller->email }}
                                @if($seller->phone)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-phone me-1"></i> {{ $seller->country_code }} {{ $seller->phone }}
                                @endif
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i> Full Administrative Access
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar me-1"></i> Joined: {{ $seller->created_at->format('M d, Y') }}
                                @if($seller->verification_status)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-check-circle me-1"></i> {{ ucfirst($seller->verification_status) }}
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.sellers.edit', $seller) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Members Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> Team Members
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">{{ $teamMembers->total() + 1 }} Total Members</span>
                        <span class="badge badge-info ml-1">{{ $teamMembers->total() }} Staff</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($teamMembers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Joining Date</th>
                                        <th>Last Login</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teamMembers as $member)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title bg-secondary text-white rounded-circle">
                                                        {{ strtoupper(substr($member->f_name, 0, 1) . substr($member->l_name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $member->full_name }}</h6>
                                                    <small class="text-muted">{{ $member->email }}</small>
                                                    @if($member->employee_id)
                                                        <br><small class="text-info">ID: {{ $member->employee_id }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $member->role_display }}</span>
                                            @if($member->department)
                                                <br><small class="text-muted">{{ $member->department }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($member->status === 'active')
                                                <span class="badge badge-success">Active</span>
                                            @elseif($member->status === 'inactive')
                                                <span class="badge badge-secondary">Inactive</span>
                                            @else
                                                <span class="badge badge-warning">Suspended</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $member->joining_date ? $member->joining_date->format('M d, Y') : $member->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            @if($member->last_login_at)
                                                {{ $member->last_login_at->diffForHumans() }}
                                            @else
                                                <span class="text-muted">Never</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-info btn-sm" onclick="viewMember({{ $member->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($member->status === 'active')
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="suspendMember({{ $member->id }})">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success btn-sm" onclick="activateMember({{ $member->id }})">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($teamMembers->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $teamMembers->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Team Members</h5>
                            <p class="text-muted">This seller hasn't added any team members yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Team Statistics -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Members</span>
                            <span class="info-box-number">{{ $seller->teamMembers()->count() + 1 }}</span>
                            <small class="text-muted">Including owner</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active</span>
                            <span class="info-box-number">{{ $seller->activeTeamMembers()->count() + ($seller->status === 'active' ? 1 : 0) }}</span>
                            <small class="text-muted">Active accounts</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-user-tie"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Managers</span>
                            <span class="info-box-number">{{ $seller->teamMembers()->where('role', 'manager')->count() }}</span>
                            <small class="text-muted">Management staff</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Staff</span>
                            <span class="info-box-number">{{ $seller->teamMembers()->where('role', 'staff')->count() }}</span>
                            <small class="text-muted">Regular staff</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Member Details Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Team Member Details</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="memberDetails">
                <!-- Member details will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewMember(memberId) {
    // For now, just show an alert. You can implement a detailed view later
    alert('View member details for ID: ' + memberId);
}

function suspendMember(memberId) {
    if (confirm('Are you sure you want to suspend this team member?')) {
        // Implement suspend functionality
        alert('Suspend member ID: ' + memberId);
    }
}

function activateMember(memberId) {
    if (confirm('Are you sure you want to activate this team member?')) {
        // Implement activate functionality
        alert('Activate member ID: ' + memberId);
    }
}
</script>
@endpush
