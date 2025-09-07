@extends('layouts.admin')

@section('title', 'Seller Details')

@section('page_title', 'Seller Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Action Buttons -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.sellers.edit', $seller) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Seller
                </a>
                @if($seller->status === 'active')
                    <button type="button" class="btn btn-warning" onclick="suspendSeller({{ $seller->id }})">
                        <i class="fas fa-pause"></i> Suspend
                    </button>
                @else
                    <button type="button" class="btn btn-success" onclick="activateSeller({{ $seller->id }})">
                        <i class="fas fa-play"></i> Activate
                    </button>
                @endif
                @if($seller->verification_status === 'pending')
                    <button type="button" class="btn btn-info" onclick="approveSeller({{ $seller->id }})">
                        <i class="fas fa-check"></i> Approve
                    </button>
                @endif
                <button type="button" class="btn btn-danger" onclick="deleteSeller({{ $seller->id }})">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Sidebar - Navigation -->
        <div class="col-md-3">
            <x-seller-navigation :seller="$seller" active-route="admin.sellers.show" />
        </div>
        
        <!-- Right Content Area -->
        <div class="col-md-9">
            <!-- Statistics Cards Row -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $seller->product()->count() }}</h3>
                            <p>Total Products</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $seller->orders_count }}</h3>
                            <p>Total Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $seller->product()->sum('views') ?? 0 }}</h3>
                            <p>Total Views</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>4.5</h3>
                            <p>Average Rating</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seller Information Cards -->
            <div class="row">
                <!-- Personal Information -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i> Personal Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $seller->f_name }} {{ $seller->l_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $seller->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $seller->country_code }} {{ $seller->phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($seller->status === 'active')
                                            <span class="badge badge-success">Active</span>
                                        @elseif($seller->status === 'suspended')
                                            <span class="badge badge-warning">Suspended</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($seller->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Joined:</strong></td>
                                    <td>{{ $seller->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-building"></i> Business Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Business Name:</strong></td>
                                    <td>{{ $seller->business_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Business Type:</strong></td>
                                    <td>
                                        @if($seller->business_type)
                                            <span class="badge badge-info">{{ ucfirst($seller->business_type) }}</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>GST Number:</strong></td>
                                    <td>{{ $seller->gst_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>PAN Number:</strong></td>
                                    <td>{{ $seller->pan_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Verification:</strong></td>
                                    <td>
                                        @if($seller->verification_status === 'verified')
                                            <span class="badge badge-success">Verified</span>
                                        @elseif($seller->verification_status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($seller->verification_status === 'rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                        @else
                                            <span class="badge badge-secondary">Not Submitted</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history"></i> Recent Activity
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline timeline-inverse">
                                <!-- Today's Date -->
                                <div class="time-label">
                                    <span class="bg-danger">{{ now()->format('M d, Y') }}</span>
                                </div>

                                <!-- Profile Updated -->
                                <div>
                                    <i class="fas fa-user bg-info"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="far fa-clock"></i> {{ $seller->updated_at->format('H:i') }}
                                        </span>
                                        <h3 class="timeline-header border-0">
                                            <strong>Profile Updated</strong>
                                        </h3>
                                        <div class="timeline-body">
                                            Seller profile was last updated on {{ $seller->updated_at->format('M d, Y \a\t H:i') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Created -->
                                <div>
                                    <i class="fas fa-user-plus bg-success"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="far fa-clock"></i> {{ $seller->created_at->format('H:i') }}
                                        </span>
                                        <h3 class="timeline-header border-0">
                                            <strong>Account Created</strong>
                                        </h3>
                                        <div class="timeline-body">
                                            Seller account was created and registered in the system
                                        </div>
                                    </div>
                                </div>

                                @if($seller->verification_completed_at)
                                <!-- Verification Completed -->
                                <div>
                                    <i class="fas fa-check-circle bg-primary"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="far fa-clock"></i> {{ $seller->verification_completed_at->format('H:i') }}
                                        </span>
                                        <h3 class="timeline-header border-0">
                                            <strong>Verification Completed</strong>
                                        </h3>
                                        <div class="timeline-body">
                                            Seller account verification was completed and approved
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- End Timeline -->
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Row -->
            <div class="row mt-3">
                <!-- Address Information -->
                <div class="col-md-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-map-marker-alt"></i> Address Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Address:</strong> {{ $seller->address_line_1 ?? 'N/A' }}</p>
                            @if($seller->address_line_2)
                                <p><strong>Address Line 2:</strong> {{ $seller->address_line_2 }}</p>
                            @endif
                            <p><strong>Area:</strong> {{ $seller->area ?? 'N/A' }}</p>
                            <p><strong>City:</strong> {{ $seller->city ?? 'N/A' }}</p>
                            <p><strong>State:</strong> {{ $seller->state ?? 'N/A' }}</p>
                            <p><strong>Country:</strong> {{ $seller->country ?? 'N/A' }}</p>
                            <p><strong>Pincode:</strong> {{ $seller->pincode ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Details -->
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-university"></i> Bank Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Bank Name:</strong> {{ $seller->bank_name ?? 'N/A' }}</p>
                            <p><strong>Branch:</strong> {{ $seller->branch ?? 'N/A' }}</p>
                            <p><strong>IFSC Code:</strong> {{ $seller->ifsc_code ?? 'N/A' }}</p>
                            <p><strong>Account Number:</strong> {{ $seller->account_no ?? 'N/A' }}</p>
                            <p><strong>Account Holder:</strong> {{ $seller->holder_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($seller->verification_notes)
            <!-- Verification Notes -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sticky-note"></i> Verification Notes
                            </h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $seller->verification_notes }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this seller? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function suspendSeller(sellerId) {
    if (confirm('Are you sure you want to suspend this seller?')) {
        $.ajax({
            url: `/admin/sellers/${sellerId}/suspend`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
}

function activateSeller(sellerId) {
    if (confirm('Are you sure you want to activate this seller?')) {
        $.ajax({
            url: `/admin/sellers/${sellerId}/activate`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
}

function approveSeller(sellerId) {
    if (confirm('Are you sure you want to approve this seller? This will set their verification status to verified and activate their account.')) {
        $.ajax({
            url: `/admin/sellers/${sellerId}/approve`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message || 'Seller approved successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'Failed to approve seller'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Error: Failed to approve seller. Please try again.');
            }
        });
    }
}

function deleteSeller(sellerId) {
    $('#deleteForm').attr('action', `/admin/sellers/${sellerId}`);
    $('#deleteModal').modal('show');
}
</script>
@endpush