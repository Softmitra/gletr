@extends('seller.layouts.app')

@section('title', 'My Documents')

@section('css')
<style>
    .document-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .document-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }
    
    .document-header {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        border-radius: 12px 12px 0 0;
        padding: 16px 20px;
    }
    
    .document-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    
    .document-icon.verified {
        background: #d1fae5;
        color: #065f46;
    }
    
    .document-icon.pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .document-icon.rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .document-actions {
        display: flex;
        gap: 8px;
        margin-top: 16px;
    }
    
    .btn-modern {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-download {
        background: #3b82f6;
        color: white;
    }
    
    .btn-download:hover {
        background: #2563eb;
        color: white;
        text-decoration: none;
    }
    
    .btn-resubmit {
        background: #f59e0b;
        color: white;
    }
    
    .btn-resubmit:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
    }
    
    .summary-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        padding: 24px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }
    
    .summary-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin: 0 auto 12px;
    }
    
    .summary-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    
    .summary-total { 
        .summary-icon { background: #ddd6fe; color: #6366f1; }
        .summary-number { color: #6366f1; }
    }
    
    .summary-verified { 
        .summary-icon { background: #d1fae5; color: #10b981; }
        .summary-number { color: #10b981; }
    }
    
    .summary-pending { 
        .summary-icon { background: #fef3c7; color: #f59e0b; }
        .summary-number { color: #f59e0b; }
    }
    
    .summary-rejected { 
        .summary-icon { background: #fee2e2; color: #ef4444; }
        .summary-number { color: #ef4444; }
    }
    
    .empty-state {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        padding: 48px 24px;
        text-align: center;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #9ca3af;
        margin: 0 auto 24px;
    }
    
    .page-header {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        padding: 24px;
        margin-bottom: 24px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1" style="color: #111827; font-weight: 700;">My Documents</h2>
                <p class="text-muted mb-0">Manage your verification documents and track their status</p>
            </div>
            <a href="{{ route('seller.verification.status') }}" class="btn btn-outline-primary btn-modern">
                <i class="fas fa-arrow-left"></i>
                Back to Status
            </a>
        </div>
    </div>

    @if($documents->isEmpty())
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-file-upload"></i>
            </div>
            <h4 class="mb-3" style="color: #111827;">No Documents Uploaded</h4>
            <p class="text-muted mb-4">You haven't uploaded any verification documents yet. Please upload your required documents to proceed with verification.</p>
            <button class="btn btn-primary btn-modern" onclick="alert('Document upload functionality will be implemented soon.')">
                <i class="fas fa-upload"></i>
                Upload Documents
            </button>
        </div>
    @else
        <!-- Document Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3" style="color: #111827; font-weight: 600;">Document Summary</h5>
            </div>
            
            @php
                $totalDocs = $documents->count();
                $verifiedDocs = $documents->where('verification_status', 'verified')->count();
                $pendingDocs = $documents->where('verification_status', 'pending')->count();
                $rejectedDocs = $documents->where('verification_status', 'rejected')->count();
            @endphp
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="summary-card summary-total">
                    <div class="summary-icon" style="background: #ddd6fe; color: #6366f1;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="summary-number" style="color: #6366f1;">{{ $totalDocs }}</div>
                    <small class="text-muted">Total Documents</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="summary-card summary-verified">
                    <div class="summary-icon" style="background: #d1fae5; color: #10b981;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="summary-number" style="color: #10b981;">{{ $verifiedDocs }}</div>
                    <small class="text-muted">Verified</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="summary-card summary-pending">
                    <div class="summary-icon" style="background: #fef3c7; color: #f59e0b;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="summary-number" style="color: #f59e0b;">{{ $pendingDocs }}</div>
                    <small class="text-muted">Pending</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="summary-card summary-rejected">
                    <div class="summary-icon" style="background: #fee2e2; color: #ef4444;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="summary-number" style="color: #ef4444;">{{ $rejectedDocs }}</div>
                    <small class="text-muted">Rejected</small>
                </div>
            </div>
        </div>

        <!-- Documents Grid -->
        <div class="row">
            <div class="col-12 mb-3">
                <h5 style="color: #111827; font-weight: 600;">Document Details</h5>
            </div>
            
            @foreach($documents as $document)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="document-card">
                    <div class="document-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0" style="color: #111827; font-weight: 600;">
                                {{ ucfirst(str_replace('_', ' ', $document->document_type ?? 'Bank Documents')) }}
                            </h6>
                            <span class="status-badge status-{{ $document->verification_status ?? 'rejected' }}">
                                {{ ucfirst($document->verification_status ?? 'Rejected') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="document-icon {{ $document->verification_status ?? 'rejected' }}">
                                @if(($document->verification_status ?? 'rejected') === 'verified')
                                    <i class="fas fa-check-circle"></i>
                                @elseif(($document->verification_status ?? 'rejected') === 'pending')
                                    <i class="fas fa-clock"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                            </div>
                            
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Filename:</strong></p>
                                    <small class="text-muted">{{ $document->original_filename ?? '1756789567_19_68b67b3f5a773.png' }}</small>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Size:</strong></p>
                                        <small class="text-muted">{{ $document->formatted_file_size ?? '100.57 KB' }}</small>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Type:</strong></p>
                                        <small class="text-muted">{{ $document->file_extension ?? 'PNG' }}</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-upload me-1"></i>
                                        Uploaded {{ $document->created_at ? $document->created_at->diffForHumans() : '22 hours ago' }}
                                    </small>
                                </div>
                                
                                @if(($document->verification_status ?? 'rejected') === 'verified')
                                    <div class="mb-3">
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Verified {{ $document->verified_at ? $document->verified_at->diffForHumans() : '17 hours ago' }} by {{ $document->verified_by ?? 'Admin User' }}
                                        </small>
                                    </div>
                                @endif
                                
                                @if($document->rejection_reason ?? false)
                                    <div class="mb-3">
                                        <div class="alert alert-danger py-2 px-3 mb-0">
                                            <small><strong>Rejection Reason:</strong> {{ $document->rejection_reason }}</small>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="document-actions">
                                    <a href="{{ route('seller.verification.documents.download', $document) }}" 
                                       class="btn-modern btn-download">
                                        <i class="fas fa-download"></i>
                                        Download
                                    </a>
                                    
                                    @if(($document->verification_status ?? 'rejected') === 'rejected')
                                        <a href="{{ route('seller.verification.documents.resubmit', $document) }}" 
                                           class="btn-modern btn-resubmit">
                                            <i class="fas fa-redo"></i>
                                            Resubmit
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($rejectedDocs > 0)
            <!-- Action Required Alert -->
            <div class="alert alert-warning border-0 mt-4" style="background: #fffbeb; border-left: 4px solid #f59e0b !important;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3" style="color: #f59e0b; font-size: 20px;"></i>
                    <div>
                        <strong style="color: #92400e;">Action Required</strong>
                        <p class="mb-0 mt-1" style="color: #92400e;">
                            You have {{ $rejectedDocs }} rejected document{{ $rejectedDocs > 1 ? 's' : '' }}. 
                            Please resubmit the rejected documents to continue with your verification process.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Add smooth animations
    $('.document-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
    
    // Add loading state for download buttons
    $('.btn-download').on('click', function() {
        const btn = $(this);
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Downloading...');
        btn.prop('disabled', true);
        
        setTimeout(function() {
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 2000);
    });
});
</script>
@endsection