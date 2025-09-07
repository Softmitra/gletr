@extends('layouts.admin')

@section('title', 'Edit Customer - ' . $customer->name)

@section('page_title', 'Edit Customer')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit mr-2"></i>Edit Customer Information
                    </h5>
                </div>
                <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="font-weight-bold">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $customer->profile->phone ?? '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $customer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="suspended" {{ old('status', $customer->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="banned" {{ old('status', $customer->status) == 'banned' ? 'selected' : '' }}>Banned</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth" class="font-weight-bold">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="date_of_birth" name="date_of_birth" 
                                           value="{{ old('date_of_birth', $customer->profile && $customer->profile->date_of_birth ? $customer->profile->date_of_birth->format('Y-m-d') : '') }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender" class="font-weight-bold">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $customer->profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $customer->profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $customer->profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>Back to Customer
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Update Customer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Customer Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($customer->profile && $customer->profile->profile_picture)
                            <img src="{{ asset('storage/' . $customer->profile->profile_picture) }}" class="rounded-circle" width="80" height="80" alt="Profile">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}" class="rounded-circle" width="80" height="80" alt="Profile">
                        @endif
                        <h5 class="mt-2 mb-0">{{ $customer->name }}</h5>
                        <p class="text-muted">{{ $customer->email }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Current Status:</strong>
                        @if($customer->status == 'active')
                            <span class="badge badge-success">Active</span>
                        @elseif($customer->status == 'inactive')
                            <span class="badge badge-secondary">Inactive</span>
                        @elseif($customer->status == 'suspended')
                            <span class="badge badge-warning">Suspended</span>
                        @elseif($customer->status == 'banned')
                            <span class="badge badge-danger">Banned</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>Member Since:</strong>
                        <p class="mb-0">{{ $customer->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Last Login:</strong>
                        @if($customer->last_login_at)
                            <p class="mb-0">{{ $customer->last_login_at->diffForHumans() }}</p>
                        @else
                            <p class="mb-0 text-muted">Never logged in</p>
                        @endif
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
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-info">
                            <i class="fas fa-eye mr-1"></i>View Details
                        </a>
                        <a href="{{ route('admin.customers.orders', $customer) }}" class="btn btn-warning">
                            <i class="fas fa-shopping-cart mr-1"></i>View Orders
                        </a>
                        <a href="{{ route('admin.customers.reviews', $customer) }}" class="btn btn-success">
                            <i class="fas fa-star mr-1"></i>View Reviews
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteCustomer()">
                            <i class="fas fa-trash mr-1"></i>Delete Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 0 1rem rgba(0, 0, 0, .125);
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.d-grid {
    display: grid;
}

.gap-2 {
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .d-flex {
        flex-direction: column;
    }
    
    .d-flex .btn {
        margin-bottom: 10px;
    }
}
</style>
@endpush

@push('js')
<script>
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

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const status = document.getElementById('status').value;

    if (!name || !email || !status) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please fill in all required fields.'
        });
        return false;
    }
});
</script>
@endpush
