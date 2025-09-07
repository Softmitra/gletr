@extends('seller.layouts.app')

@section('title', 'Verification Status')

@section('css')
<style>
    .verification-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .verification-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }
    
    .progress-modern {
        height: 12px;
        border-radius: 8px;
        background-color: #f3f4f6;
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    
    .progress-bar-modern {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        border-radius: 8px;
        transition: width 0.6s ease;
        height: 100%;
        display: block;
        position: relative;
    }
    
    .step-card {
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .step-card.completed {
        border-color: #10b981;
        background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
    }
    
    .step-card.in-progress {
        border-color: #f59e0b;
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }
    
    .step-card.pending {
        border-color: #e5e7eb;
        background: white;
    }
    
    .step-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 16px;
    }
    
    .step-icon.completed {
        background: #10b981;
        color: white;
    }
    
    .step-icon.in-progress {
        background: #f59e0b;
        color: white;
    }
    
    .step-icon.pending {
        background: #f3f4f6;
        color: #6b7280;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .stats-card {
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        text-align: center;
        padding: 20px;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    
    .stats-verified { color: #10b981; }
    .stats-pending { color: #f59e0b; }
    .stats-rejected { color: #ef4444; }
    .stats-total { color: #6366f1; }
    
    .activity-item {
        padding: 16px;
        border-left: 3px solid #e5e7eb;
        margin-bottom: 12px;
        background: #f9fafb;
        border-radius: 0 8px 8px 0;
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        background: #f3f4f6;
        border-left-color: #6366f1;
    }
    
    .activity-item.verified {
        border-left-color: #10b981;
        background: #ecfdf5;
    }
    
    .activity-item.rejected {
        border-left-color: #ef4444;
        background: #fef2f2;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="verification-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mb-1" style="color: #111827; font-weight: 700;">Account Verification Status</h4>
                            <p class="text-muted mb-0">Track your verification progress and complete required steps</p>
                        </div>
                        <span class="status-badge status-{{ $seller->verification_status === 'verified' ? 'verified' : ($seller->verification_status === 'rejected' ? 'rejected' : 'pending') }}">
                            {{ ucfirst(str_replace('_', ' ', $seller->verification_status)) }}
                        </span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted font-weight-500">Verification Progress</span>
                            <span class="font-weight-bold" style="color: #10b981; font-size: 18px;">{{ $progress['percentage'] ?? 50 }}%</span>
                        </div>
                        <div class="progress-modern">
                            <div class="progress-bar-modern" style="width: {{ $progress['percentage'] ?? 50 }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-muted">{{ $progress['completed_steps'] ?? 2 }} of {{ $progress['total_steps'] ?? 4 }} steps completed</small>
                            <small class="text-muted">{{ $progress['status_text'] ?? 'In Progress' }}</small>
                        </div>
                    </div>
                    
                    <!-- Current Status Message -->
                    @if($seller->verification_status === 'verified')
                        <div class="alert alert-success border-0" style="background: #ecfdf5; color: #065f46;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3" style="font-size: 20px;"></i>
                                <div>
                                    <strong>Congratulations! Your account is fully verified.</strong>
                                    <p class="mb-0 mt-1">You can now start selling your products on our platform.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($seller->verification_status === 'rejected')
                        <div class="alert alert-danger border-0" style="background: #fef2f2; color: #991b1b;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-3" style="font-size: 20px;"></i>
                                <div>
                                    <strong>Action Required: Some documents need attention.</strong>
                                    <p class="mb-0 mt-1">Please review the rejected documents and resubmit them.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info border-0" style="background: #eff6ff; color: #1e40af;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-3" style="font-size: 20px;"></i>
                                <div>
                                    <strong>Verification in Progress</strong>
                                    <p class="mb-0 mt-1">Our team is reviewing your documents. We'll notify you once the review is complete.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Verification Steps -->
        <div class="col-lg-8 mb-4">
            <div class="verification-card">
                <div class="card-body p-4">
                    <h5 class="mb-4" style="color: #111827; font-weight: 600;">Verification Steps</h5>
                    
                    <!-- Step 1: Account Registration -->
                    <div class="step-card completed mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="step-icon completed">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" style="color: #065f46; font-weight: 600;">Account Registration</h6>
                                    <p class="text-muted mb-1">Your seller account has been created successfully.</p>
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Completed on Sep 02, 2025
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Document Upload -->
                    <div class="step-card completed mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="step-icon completed">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" style="color: #065f46; font-weight: 600;">Document Upload</h6>
                                    <p class="text-muted mb-1">Upload required verification documents.</p>
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        1 documents uploaded
                                    </small>
                                    <div class="mt-2">
                                        <a href="{{ route('seller.verification.documents') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> View Documents
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Document Review -->
                    <div class="step-card in-progress mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="step-icon in-progress">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" style="color: #92400e; font-weight: 600;">Document Review</h6>
                                    <p class="text-muted mb-1">Our team reviews your submitted documents.</p>
                                    
                                    <!-- Document Status Stats -->
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            <div class="text-center">
                                                <div class="stats-number stats-verified">0</div>
                                                <small class="text-muted">Verified</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="text-center">
                                                <div class="stats-number stats-pending">0</div>
                                                <small class="text-muted">Pending</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="text-center">
                                                <div class="stats-number stats-rejected">1</div>
                                                <small class="text-muted">Rejected</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="text-center">
                                                <div class="stats-number stats-total">1</div>
                                                <small class="text-muted">Total</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Final Approval -->
                    <div class="step-card pending">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="step-icon pending">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" style="color: #6b7280; font-weight: 600;">Final Approval</h6>
                                    <p class="text-muted mb-1">Final review and account activation.</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Pending document verification
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Overview -->
            <div class="verification-card mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="color: #111827; font-weight: 600;">Quick Overview</h5>
                    
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-file-alt" style="font-size: 24px; color: #6366f1;"></i>
                                </div>
                                <div class="stats-number stats-total">1</div>
                                <small class="text-muted">Documents</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-check-circle" style="font-size: 24px; color: #10b981;"></i>
                                </div>
                                <div class="stats-number stats-verified">0</div>
                                <small class="text-muted">Verified</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        

          
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Add smooth animations
    $('.step-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('animate__animated animate__fadeInUp');
    });
    
    // Progress bar animation
    setTimeout(function() {
        $('.progress-bar-modern').each(function() {
            const targetWidth = $(this).attr('style').match(/width:\s*(\d+(?:\.\d+)?%)/);
            if (targetWidth) {
                $(this).css('width', '0%');
                $(this).animate({
                    width: targetWidth[1]
                }, 1200, 'swing');
            }
        });
    }, 500);
});
</script>
@endsection