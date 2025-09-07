@extends('layouts.admin')

@section('title', 'Customer Reviews - ' . $customer->name)

@section('page_title', 'Customer Reviews')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a></li>
    <li class="breadcrumb-item active">Reviews</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <!-- Customer Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-warning">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        @if($customer->profile && $customer->profile->profile_picture)
                            <img src="{{ asset('storage/' . $customer->profile->profile_picture) }}" class="rounded-circle mr-3" width="60" height="60" alt="Profile">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}" class="rounded-circle mr-3" width="60" height="60" alt="Profile">
                        @endif
                        <div>
                            <h3 class="mb-1">{{ $customer->name }}'s Reviews</h3>
                            <p class="mb-0">{{ $customer->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-star mr-2"></i>Customer Reviews ({{ $reviews->total() }})
                        </h5>
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Customer
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($reviews->count() > 0)
                        <div class="row">
                            @foreach($reviews as $review)
                                <div class="col-md-6 mb-4">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1">
                                                        @if($review->product)
                                                            <a href="#" class="text-dark">{{ $review->product->name }}</a>
                                                        @else
                                                            <span class="text-muted">Product not found</span>
                                                        @endif
                                                    </h6>
                                                    <div class="mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= ($review->rating ?? 0))
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                        <span class="ml-1 text-muted">({{ $review->rating ?? 0 }}/5)</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    @switch($review->status ?? 'pending')
                                                        @case('approved')
                                                            <span class="badge badge-success">Approved</span>
                                                            @break
                                                        @case('rejected')
                                                            <span class="badge badge-danger">Rejected</span>
                                                            @break
                                                        @default
                                                            <span class="badge badge-warning">Pending</span>
                                                    @endswitch
                                                </div>
                                            </div>

                                            @if($review->title)
                                                <h6 class="font-weight-bold">{{ $review->title }}</h6>
                                            @endif

                                            @if($review->comment)
                                                <p class="text-muted mb-2">{{ Str::limit($review->comment, 150) }}</p>
                                            @endif

                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $review->created_at->format('M d, Y') }}
                                                </small>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info" onclick="viewReview({{ $review->id }})" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if(($review->status ?? 'pending') == 'pending')
                                                        <button type="button" class="btn btn-sm btn-success" onclick="approveReview({{ $review->id }})" title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="rejectReview({{ $review->id }})" title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($review->order)
                                                <div class="mt-2">
                                                    <small class="text-info">
                                                        <i class="fas fa-shopping-cart mr-1"></i>
                                                        Order #{{ $review->order->id }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $reviews->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Reviews Found</h5>
                            <p class="text-muted">This customer hasn't written any reviews yet.</p>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left mr-1"></i>Back to Customer
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 0 1rem rgba(0, 0, 0, .125);
}

.border-left-primary {
    border-left: 4px solid #007bff !important;
}

.btn-group .btn {
    margin-right: 5px;
}

.fa-star.text-warning {
    color: #ffc107 !important;
}

@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: column;
    }

    .btn-group .btn {
        margin-right: 0;
        margin-bottom: 5px;
        border-radius: 5px;
    }
}
</style>
@endpush

@push('js')
<script>
function viewReview(reviewId) {
    // Redirect to customer reviews page with specific review
    window.location.href = '{{ route("admin.customer-reviews.index") }}?review_id=' + reviewId;
}

function approveReview(reviewId) {
    Swal.fire({
        title: 'Approve Review?',
        text: 'Are you sure you want to approve this review?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, approve!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/customer-reviews/' + reviewId + '/approve';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectReview(reviewId) {
    Swal.fire({
        title: 'Reject Review?',
        text: 'Are you sure you want to reject this review?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, reject!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/customer-reviews/' + reviewId + '/reject';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
