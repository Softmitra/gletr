@extends('adminlte::page')

@section('title', 'Seller Verification - ' . $seller->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Seller Verification - {{ $seller->name }}</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.seller-verification.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            @if($seller->verification_status === 'documents_verified')
                @can('approve seller verification')
                    <button type="button" class="btn btn-success" onclick="approveSeller()">
                        <i class="fas fa-check"></i> Approve Seller
                    </button>
                    <button type="button" class="btn btn-danger" onclick="rejectSeller()">
                        <i class="fas fa-times"></i> Reject Seller
                    </button>
                @endcan
            @endif
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Seller Information -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ $seller->image ? Storage::url($seller->image) : asset('vendor/adminlte/dist/img/user4-128x128.jpg') }}"
                             alt="Seller profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $seller->name }}</h3>

                    <p class="text-muted text-center">{{ $seller->sellerType->name ?? 'N/A' }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <span class="float-right">{{ $seller->email }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Phone</b> <span class="float-right">{{ $seller->phone }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Business Name</b> <span class="float-right">{{ $seller->business_name }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Registration Date</b> <span class="float-right">{{ $seller->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Verification Status</b> 
                            <span class="float-right">
                                @php
                                    $statusConfig = [
                                        'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Pending'],
                                        'documents_verified' => ['class' => 'primary', 'icon' => 'check', 'text' => 'Documents Verified'],
                                        'verified' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Verified'],
                                        'rejected' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Rejected'],
                                    ];
                                    $config = $statusConfig[$seller->verification_status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Unknown'];
                                @endphp
                                <span class="badge badge-{{ $config['class'] }}">
                                    <i class="fas fa-{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                </span>
                            </span>
                        </li>
                        @if($seller->expertReviewer)
                            <li class="list-group-item">
                                <b>Expert Reviewer</b> <span class="float-right">{{ $seller->expertReviewer->name }}</span>
                            </li>
                        @endif
                    </ul>

                    @can('manage verification workflow')
                        <button type="button" class="btn btn-primary btn-block" onclick="assignReviewer()">
                            <i class="fas fa-user-plus"></i> 
                            {{ $seller->expertReviewer ? 'Change Reviewer' : 'Assign Reviewer' }}
                        </button>
                    @endcan
                </div>
            </div>

            <!-- Address Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Address Information</h3>
                </div>
                <div class="card-body">
                    <address>
                        <strong>{{ $seller->business_name }}</strong><br>
                        {{ $seller->address_line_1 }}<br>
                        @if($seller->address_line_2)
                            {{ $seller->address_line_2 }}<br>
                        @endif
                        {{ $seller->area }}, {{ $seller->city }}<br>
                        {{ $seller->state }} - {{ $seller->pincode }}<br>
                        {{ $seller->country }}
                    </address>
                </div>
            </div>

            <!-- Bank Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bank Information</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><strong>Bank Name:</strong> {{ $seller->bank_name }}</li>
                        <li><strong>Account Holder:</strong> {{ $seller->holder_name }}</li>
                        <li><strong>Account Number:</strong> {{ $seller->account_no }}</li>
                        <li><strong>IFSC Code:</strong> {{ $seller->ifsc_code }}</li>
                        @if($seller->branch)
                            <li><strong>Branch:</strong> {{ $seller->branch }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Documents and Verification -->
        <div class="col-md-8">
            <!-- Documents -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Document Verification</h3>
                </div>
                <div class="card-body">
                    @if($documents->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            No documents have been uploaded by this seller.
                        </div>
                    @else
                        <div class="row">
                            @foreach($documents as $document)
                                <div class="col-md-6 mb-4">
                                    <div class="card {{ $document->isApproved() ? 'border-success' : ($document->isRejected() ? 'border-danger' : 'border-warning') }}">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">{{ $document->document_type }}</h5>
                                            <div class="card-tools">
                                                <span class="badge {{ $document->status_badge_class }}">
                                                    {{ $document->status_display }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <small class="text-muted">Original Filename:</small><br>
                                                    <strong>{{ $document->original_filename ?? 'N/A' }}</strong>
                                                </div>
                                                <div class="col-sm-6">
                                                    <small class="text-muted">File Size:</small><br>
                                                    <strong>{{ $document->formatted_file_size }}</strong>
                                                </div>
                                            </div>
                                            
                                            @if($document->uploaded_at)
                                                <div class="mt-2">
                                                    <small class="text-muted">Uploaded:</small><br>
                                                    <strong>{{ $document->uploaded_at->format('M d, Y H:i') }}</strong>
                                                </div>
                                            @endif

                                            @if($document->verified_at)
                                                <div class="mt-2">
                                                    <small class="text-muted">Verified:</small><br>
                                                    <strong>{{ $document->verified_at->format('M d, Y H:i') }}</strong>
                                                    @if($document->expertReviewer)
                                                        <br><small class="text-muted">by {{ $document->expertReviewer->name }}</small>
                                                    @endif
                                                </div>
                                            @endif

                                            @if($document->admin_comments)
                                                <div class="mt-2">
                                                    <small class="text-muted">Comments:</small><br>
                                                    <div class="alert alert-info py-2">{{ $document->admin_comments }}</div>
                                                </div>
                                            @endif

                                            <div class="mt-3">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <!-- Document View/Download Buttons -->
                                                    @if($document->document_path)
                                                        <a href="{{ asset('storage/' . $document->document_path) }}" 
                                                           class="btn btn-outline-info" target="_blank">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <a href="{{ asset('storage/' . $document->document_path) }}" 
                                                           class="btn btn-outline-primary" download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @endif
                                                    
                                                    <!-- Verification Action Buttons -->
                                                    @can('verify seller documents')
                                                        @if($document->isPending())
                                                            <button type="button" class="btn btn-success" 
                                                                    onclick="verifyDocument({{ $document->id }}, 'verified')">
                                                                <i class="fas fa-check"></i> Approve
                                                            </button>
                                                            <button type="button" class="btn btn-danger" 
                                                                    onclick="verifyDocument({{ $document->id }}, 'rejected')">
                                                                <i class="fas fa-times"></i> Reject
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-secondary" 
                                                                    onclick="verifyDocument({{ $document->id }}, 'pending')">
                                                                <i class="fas fa-undo"></i> Reset
                                                            </button>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Verification Logs -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Verification Activity Log</h3>
                </div>
                <div class="card-body">
                    @if($verificationLogs->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            No verification activities recorded yet.
                        </div>
                    @else
                        <div class="timeline">
                            @foreach($verificationLogs as $log)
                                <div class="time-label">
                                    <span class="bg-blue">{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    @php
                                        $actionConfig = [
                                            'document_verified' => ['icon' => 'file-check', 'color' => 'success'],
                                            'seller_approved' => ['icon' => 'check-circle', 'color' => 'success'],
                                            'seller_rejected' => ['icon' => 'times-circle', 'color' => 'danger'],
                                            'reviewer_assigned' => ['icon' => 'user-plus', 'color' => 'info'],
                                        ];
                                        $config = $actionConfig[$log->action] ?? ['icon' => 'info', 'color' => 'secondary'];
                                    @endphp
                                    <i class="fas fa-{{ $config['icon'] }} bg-{{ $config['color'] }}"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                                        </span>
                                        <h3 class="timeline-header">
                                            <strong>{{ $log->user->name }}</strong> 
                                            {{ $log->formatted_action }}
                                        </h3>
                                        @if($log->data)
                                            <div class="timeline-body">
                                                @if(isset($log->data['comments']) && $log->data['comments'])
                                                    <strong>Comments:</strong> {{ $log->data['comments'] }}<br>
                                                @endif
                                                @if(isset($log->data['reason']) && $log->data['reason'])
                                                    <strong>Reason:</strong> {{ $log->data['reason'] }}<br>
                                                @endif
                                                @if(isset($log->data['document_id']))
                                                    <strong>Document ID:</strong> {{ $log->data['document_id'] }}<br>
                                                @endif
                                                @if(isset($log->data['status']))
                                                    <strong>Status:</strong> {{ ucfirst($log->data['status']) }}<br>
                                                @endif
                                                @if(isset($log->data['reviewer_id']))
                                                    <strong>Reviewer ID:</strong> {{ $log->data['reviewer_id'] }}<br>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div>
                                <i class="fas fa-user-plus bg-gray"></i>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Document Verification Modal -->
    <div class="modal fade" id="documentVerificationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Document Verification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="documentVerificationForm" method="POST">
                    @csrf
                    <input type="hidden" name="document_id" id="document_id">
                    <input type="hidden" name="status" id="verification_status">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="verification_comments">Comments</label>
                            <textarea name="comments" id="verification_comments" class="form-control" rows="3" 
                                      placeholder="Add comments about this verification..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="verification_submit_btn">
                            <i class="fas fa-check"></i> Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Assign Reviewer Modal -->
    <div class="modal fade" id="assignReviewerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Expert Reviewer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="{{ route('admin.seller-verification.assign-reviewer', $seller) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reviewer_id">Select Reviewer</label>
                            <select name="reviewer_id" id="reviewer_id" class="form-control" required>
                                <option value="">Choose a reviewer...</option>
                                @foreach(\App\Models\User::permission('verify seller documents')->get() as $user)
                                    <option value="{{ $user->id }}" {{ $seller->expert_reviewer_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
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
                <form method="POST" action="{{ route('admin.seller-verification.approve', $seller) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
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

    <!-- Reject Seller Modal -->
    <div class="modal fade" id="rejectSellerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reject Seller</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="{{ route('admin.seller-verification.reject', $seller) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            This will reject the seller verification and suspend their account.
                        </div>
                        <div class="form-group">
                            <label for="rejection_comments">Rejection Reason (Required)</label>
                            <textarea name="comments" id="rejection_comments" class="form-control" rows="3" 
                                      placeholder="Please provide a reason for rejection..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Reject Seller
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
function verifyDocument(documentId, status) {
    console.log('verifyDocument called:', documentId, status);
    
    document.getElementById('document_id').value = documentId;
    document.getElementById('verification_status').value = status;
    
    const form = document.getElementById('documentVerificationForm');
    form.action = `{{ route('admin.seller-verification.verify-document', $seller) }}`;
    
    const submitBtn = document.getElementById('verification_submit_btn');
    const modal = document.getElementById('documentVerificationModal');
    
    if (status === 'verified') {
        submitBtn.className = 'btn btn-success';
        submitBtn.innerHTML = '<i class="fas fa-check"></i> Approve Document';
        modal.querySelector('.modal-title').textContent = 'Approve Document';
    } else if (status === 'rejected') {
        submitBtn.className = 'btn btn-danger';
        submitBtn.innerHTML = '<i class="fas fa-times"></i> Reject Document';
        modal.querySelector('.modal-title').textContent = 'Reject Document';
    } else {
        submitBtn.className = 'btn btn-warning';
        submitBtn.innerHTML = '<i class="fas fa-undo"></i> Reset Status';
        modal.querySelector('.modal-title').textContent = 'Reset Document Status';
    }
    
    $('#documentVerificationModal').modal('show');
}

function assignReviewer() {
    console.log('assignReviewer called');
    $('#assignReviewerModal').modal('show');
}

function approveSeller() {
    console.log('approveSeller called');
    console.log('Modal element:', document.getElementById('approveSellerModal'));
    
    // Check if modal exists
    const modal = document.getElementById('approveSellerModal');
    if (!modal) {
        console.error('Approve seller modal not found!');
        alert('Error: Approval modal not found. Please refresh the page and try again.');
        return;
    }
    
    // Show the modal
    $('#approveSellerModal').modal('show');
}

function rejectSeller() {
    console.log('rejectSeller called');
    console.log('Modal element:', document.getElementById('rejectSellerModal'));
    
    // Check if modal exists
    const modal = document.getElementById('rejectSellerModal');
    if (!modal) {
        console.error('Reject seller modal not found!');
        alert('Error: Rejection modal not found. Please refresh the page and try again.');
        return;
    }
    
    // Show the modal
    $('#rejectSellerModal').modal('show');
}

// Add form submission handlers
$(document).ready(function() {
    console.log('Document ready - checking modals...');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Bootstrap modal available:', typeof $.fn.modal);
    console.log('Approve modal:', document.getElementById('approveSellerModal'));
    console.log('Reject modal:', document.getElementById('rejectSellerModal'));
    
    // Handle approve form submission
    $('#approveSellerModal form').on('submit', function(e) {
        console.log('=== APPROVE FORM SUBMISSION START ===');
        console.log('Form element:', this);
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);
        
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        console.log('Form data:');
        for (let [key, value] of formData.entries()) {
            console.log(`  ${key}: ${value}`);
        }
        
        console.log('CSRF token:', form.querySelector('input[name="_token"]')?.value);
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Approving...';
        
        console.log('Form submitting to:', form.action);
        console.log('=== APPROVE FORM SUBMISSION END ===');
        
        // Let the form submit normally
        return true;
    });
    
    // Handle reject form submission
    $('#rejectSellerModal form').on('submit', function(e) {
        console.log('Reject form submitted');
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';
        
        // Let the form submit normally
        return true;
    });
});
</script>
@endpush

@section('css')
<style>
.timeline {
    position: relative;
    margin: 0 0 30px 0;
    padding: 0;
    list-style: none;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #ddd;
    left: 31px;
    margin: 0;
    border-radius: 2px;
}

.timeline > li {
    position: relative;
    margin-right: 10px;
    margin-bottom: 15px;
}

.timeline > li:before,
.timeline > li:after {
    content: " ";
    display: table;
}

.timeline > li:after {
    clear: both;
}

.timeline > li > .timeline-item {
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 3px;
    margin-top: 0;
    background: #fff;
    color: #444;
    margin-left: 60px;
    margin-right: 15px;
    padding: 0;
    position: relative;
}

.timeline > li > .timeline-item > .time {
    color: #999;
    float: right;
    padding: 10px;
    font-size: 12px;
}

.timeline > li > .timeline-item > .timeline-header {
    margin: 0;
    color: #555;
    border-bottom: 1px solid #f4f4f4;
    padding: 10px;
    font-size: 16px;
    line-height: 1.1;
}

.timeline > li > .timeline-item > .timeline-body,
.timeline > li > .timeline-item > .timeline-footer {
    padding: 10px;
}

.timeline > li > .fa,
.timeline > li > .fas,
.timeline > li > .far,
.timeline > li > .fab,
.timeline > li > .fal,
.timeline > li > .fad,
.timeline > li > .glyphicon,
.timeline > li > .ion {
    width: 30px;
    height: 30px;
    font-size: 15px;
    line-height: 30px;
    position: absolute;
    color: #666;
    background: #d2d6de;
    border-radius: 50%;
    text-align: center;
    left: 18px;
    top: 0;
}

.timeline > .time-label > span {
    font-weight: 600;
    color: #fff;
    border-radius: 4px;
    display: inline-block;
    padding: 5px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    top: 10px;
    left: -15px;
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-right: 10px solid #fff;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

.bg-blue {
    background-color: #007bff !important;
}

.bg-gray {
    background-color: #6c757d !important;
}
</style>
@stop
