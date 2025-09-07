@extends('layouts.admin')

@section('title', 'Customer Details - ' . $customer->name)

@section('page_title', 'Customer Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
    <li class="breadcrumb-item active">{{ $customer->name }}</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Customer Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary">
                <div class="card-body text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                @if($customer->profile && $customer->profile->profile_picture)
                                    <img src="{{ asset('storage/' . $customer->profile->profile_picture) }}" class="rounded-circle mr-4" width="80" height="80" alt="Profile">
                                @else
                                    <img src="{{ asset('images/default-avatar.svg') }}" class="rounded-circle mr-4" width="80" height="80" alt="Profile">
                                @endif
                                <div>
                                    <h2 class="mb-1">{{ $customer->name }}</h2>
                                    <p class="mb-2">{{ $customer->email }}</p>
                                    <div class="d-flex align-items-center">
                                        @if($customer->status == 'active')
                                            <span class="badge badge-success badge-lg mr-2">Active</span>
                                        @elseif($customer->status == 'inactive')
                                            <span class="badge badge-secondary badge-lg mr-2">Inactive</span>
                                        @elseif($customer->status == 'suspended')
                                            <span class="badge badge-warning badge-lg mr-2">Suspended</span>
                                        @elseif($customer->status == 'banned')
                                            <span class="badge badge-danger badge-lg mr-2">Banned</span>
                                        @endif
                                        <span class="text-white-50">
                                            <i class="fas fa-calendar mr-1"></i>Joined {{ $customer->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="btn-group">
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-light btn-lg">
                                    <i class="fas fa-edit mr-1"></i>Edit Customer
                                </a>
                                <button type="button" class="btn btn-outline-light btn-lg dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.customers.orders', $customer) }}" class="dropdown-item">
                                        <i class="fas fa-shopping-cart mr-2"></i>View Orders
                                    </a>
                                    <a href="{{ route('admin.customers.reviews', $customer) }}" class="dropdown-item">
                                        <i class="fas fa-star mr-2"></i>View Reviews
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item" onclick="toggleStatus()">
                                        <i class="fas fa-power-off mr-2"></i>Toggle Status
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="resetPassword()">
                                        <i class="fas fa-key mr-2"></i>Reset Password
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" class="dropdown-item text-danger" onclick="deleteCustomer()">
                                        <i class="fas fa-trash mr-2"></i>Delete Customer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total_orders']) }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('admin.customers.orders', $customer) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['total_reviews']) }}</h3>
                    <p>Total Reviews</p>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <a href="{{ route('admin.customers.reviews', $customer) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>₹{{ number_format($stats['total_spent']) }}</h3>
                    <p>Total Spent</p>
                </div>
                <div class="icon">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <a href="{{ route('admin.customers.orders', $customer) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['active_sessions']) }}</h3>
                    <p>Active Sessions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user mr-2"></i>Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Full Name</label>
                                <p class="mb-0">{{ $customer->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Email Address</label>
                                <p class="mb-0">
                                    <i class="fas fa-envelope text-primary mr-1"></i>{{ $customer->email }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Phone Number</label>
                                <p class="mb-0">
                                    @if($customer->profile && $customer->profile->phone)
                                        <i class="fas fa-phone text-success mr-1"></i>{{ $customer->profile->phone }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Date of Birth</label>
                                <p class="mb-0">
                                    @if($customer->profile && $customer->profile->date_of_birth)
                                        <i class="fas fa-birthday-cake text-warning mr-1"></i>{{ $customer->profile->date_of_birth->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Gender</label>
                                <p class="mb-0">
                                    @if($customer->profile && $customer->profile->gender)
                                        <i class="fas fa-venus-mars text-info mr-1"></i>{{ ucfirst($customer->profile->gender) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Member Since</label>
                                <p class="mb-0">
                                    <i class="fas fa-calendar text-primary mr-1"></i>{{ $customer->created_at->format('M d, Y') }}
                                    <small class="text-muted">({{ $customer->created_at->diffForHumans() }})</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            @if($customer->profile)
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-id-card mr-2"></i>Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($customer->profile->bio)
                        <div class="col-12 mb-3">
                            <label class="font-weight-bold">Bio</label>
                            <p class="mb-0">{{ $customer->profile->bio }}</p>
                        </div>
                        @endif
                        @if($customer->profile->website)
                        <div class="col-md-6">
                            <label class="font-weight-bold">Website</label>
                            <p class="mb-0">
                                <i class="fas fa-globe text-primary mr-1"></i>
                                <a href="{{ $customer->profile->website }}" target="_blank">{{ $customer->profile->website }}</a>
                            </p>
                        </div>
                        @endif
                        @if($customer->profile->social_links)
                        <div class="col-12">
                            <label class="font-weight-bold">Social Links</label>
                            <div class="d-flex flex-wrap">
                                @foreach($customer->profile->social_links as $platform => $url)
                                    <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary btn-sm mr-2 mb-2">
                                        <i class="fab fa-{{ $platform }} mr-1"></i>{{ ucfirst($platform) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Sessions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-desktop mr-2"></i>Recent Sessions
                    </h5>
                </div>
                <div class="card-body">
                    @if($customer->sessions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Browser</th>
                                        <th>IP Address</th>
                                        <th>Location</th>
                                        <th>Login Time</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->sessions->take(5) as $session)
                                        <tr>
                                            <td>
                                                <i class="fab fa-{{ $session->browser_icon }} mr-1"></i>
                                                {{ $session->browser }}
                                            </td>
                                            <td>{{ $session->ip_address }}</td>
                                            <td>{{ $session->location ?? 'Unknown' }}</td>
                                            <td>{{ $session->login_at->format('M d, H:i') }}</td>
                                            <td>{{ $session->formatted_duration }}</td>
                                            <td>
                                                @if($session->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No sessions found.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history mr-2"></i>Recent Activities
                    </h5>
                </div>
                <div class="card-body">
                    @if($customer->activities->count() > 0)
                        <div class="timeline">
                            @foreach($customer->activities->take(10) as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $activity->activity_color }}">
                                        <i class="fas fa-{{ $activity->activity_icon }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ $activity->human_description }}</h6>
                                        <p class="mb-1 text-muted">{{ $activity->created_at->diffForHumans() }}</p>
                                        @if($activity->ip_address)
                                            <small class="text-muted">{{ $activity->ip_address }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No recent activities found.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Addresses -->
            @if($customer->addresses->count() > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt mr-2"></i>Addresses ({{ $customer->addresses->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($customer->addresses as $address)
                        <div class="address-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $address->label }}</h6>
                                    <p class="mb-1 text-muted">{{ $address->formatted_address }}</p>
                                    @if($address->phone)
                                        <small><i class="fas fa-phone mr-1"></i>{{ $address->phone }}</small>
                                    @endif
                                </div>
                                @if($address->is_default)
                                    <span class="badge badge-primary">Default</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Account Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>Account Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Current Status:</strong>
                        @if($customer->status == 'active')
                            <span class="badge badge-success badge-lg">Active</span>
                        @elseif($customer->status == 'inactive')
                            <span class="badge badge-secondary badge-lg">Inactive</span>
                        @elseif($customer->status == 'suspended')
                            <span class="badge badge-warning badge-lg">Suspended</span>
                        @elseif($customer->status == 'banned')
                            <span class="badge badge-danger badge-lg">Banned</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>Last Login:</strong>
                        @if($stats['last_login'])
                            <p class="mb-0">{{ $stats['last_login']->diffForHumans() }}</p>
                        @else
                            <p class="mb-0 text-muted">Never logged in</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>Total Sessions:</strong>
                        <p class="mb-0">{{ number_format($stats['login_count']) }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Account Created:</strong>
                        <p class="mb-0">{{ $customer->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
                            <i class="fas fa-edit mr-1"></i>Edit Customer
                        </a>
                        <a href="{{ route('admin.customers.orders', $customer) }}" class="btn btn-info">
                            <i class="fas fa-shopping-cart mr-1"></i>View Orders
                        </a>
                        <a href="{{ route('admin.customers.reviews', $customer) }}" class="btn btn-warning">
                            <i class="fas fa-star mr-1"></i>View Reviews
                        </a>
                        <button type="button" class="btn btn-success" onclick="toggleStatus()">
                            <i class="fas fa-power-off mr-1"></i>Toggle Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Toggle Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Toggle Customer Status</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Current status: <strong>{{ ucfirst($customer->status) }}</strong></p>
                    <p>This will change the status to: <strong id="newStatus"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Reset Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Customer Password</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="passwordForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <small class="form-text text-muted">Password must be at least 8 characters long</small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.small-box {
    border-radius: 10px;
    box-shadow: 0 0 1rem rgba(0, 0, 0, .125);
    transition: all .3s ease;
}

.small-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
}

.address-item {
    transition: all 0.3s ease;
}

.address-item:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -37px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    z-index: 1;
}

.timeline-content {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: column;
    }

    .btn-group .btn {
        border-radius: 5px;
        margin-bottom: 5px;
    }
}
</style>
@endpush

@push('js')
<script>
function toggleStatus() {
    const currentStatus = '{{ $customer->status }}';
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';

    $('#newStatus').text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
    $('#statusForm').attr('action', '{{ route("admin.customers.toggle-status", $customer) }}');
    $('#statusModal').modal('show');
}

function resetPassword() {
    $('#passwordForm').attr('action', '{{ route("admin.customers.reset-password", $customer) }}');
    $('#passwordModal').modal('show');
}

function deleteCustomer() {
    Swal.fire({
        title: 'Delete Customer?',
        text: 'Are you sure you want to delete {{ $customer->name }}? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.customers.destroy", $customer) }}';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Handle form submissions with AJAX
$('#statusForm, #passwordForm').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const submitBtn = form.find('button[type="submit"]');
    const originalText = submitBtn.text();

    submitBtn.prop('disabled', true).text('Processing...');

    $.post(form.attr('action'), form.serialize())
        .done(function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Something went wrong.'
                });
            }
        })
        .fail(function(xhr) {
            let message = 'Something went wrong.';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                message = Object.values(xhr.responseJSON.errors)[0][0];
            }
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message
            });
        })
        .always(function() {
            submitBtn.prop('disabled', false).text(originalText);
        });
});
</script>
@endpush
