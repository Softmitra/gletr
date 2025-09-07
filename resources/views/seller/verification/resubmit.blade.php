@extends('seller.layouts.app')

@section('title', 'Resubmit Document')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Resubmit Document</h4>
                    <p class="text-muted mb-0">Upload a new version of your rejected document</p>
                </div>
                <a href="{{ route('seller.verification.documents') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Documents
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Current Document Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Rejected Document: {{ $document->document_type }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Original Filename:</strong> {{ $document->original_filename ?? 'N/A' }}</p>
                            <p><strong>File Size:</strong> {{ $document->formatted_file_size }}</p>
                            <p><strong>Uploaded:</strong> {{ $document->uploaded_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Rejected:</strong> {{ $document->verified_at->format('M d, Y H:i') }}</p>
                            @if($document->expertReviewer)
                                <p><strong>Reviewed by:</strong> {{ $document->expertReviewer->name }}</p>
                            @endif
                        </div>
                    </div>
                    
                    @if($document->admin_comments)
                    <div class="alert alert-danger mt-3">
                        <h6><i class="fas fa-info-circle"></i> Rejection Reason:</h6>
                        <p class="mb-0">{{ $document->admin_comments }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Resubmission Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Upload New Document</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.verification.documents.resubmit.store', $document) }}" 
                          method="POST" enctype="multipart/form-data" id="resubmitForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="document_file" class="form-label">
                                Select New Document File <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area border-2 border-dashed border-primary rounded p-4 text-center" 
                                 onclick="document.getElementById('document_file').click()">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h6 class="mb-2">Click to upload or drag and drop</h6>
                                <p class="text-muted mb-0">
                                    Supported formats: PDF, JPG, JPEG, PNG<br>
                                    Maximum file size: 5MB
                                </p>
                                <input type="file" 
                                       id="document_file" 
                                       name="document_file" 
                                       class="d-none" 
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       required>
                            </div>
                            @error('document_file')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="mb-4" style="display: none;">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file fa-2x me-3"></i>
                                    <div>
                                        <h6 class="mb-1" id="fileName"></h6>
                                        <small class="text-muted" id="fileSize"></small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="clearFile()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Guidelines -->
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-lightbulb"></i> Guidelines for Resubmission:</h6>
                            <ul class="mb-0">
                                <li>Ensure the document is clear and readable</li>
                                <li>Make sure all information is visible and not cut off</li>
                                <li>Address the rejection reason mentioned above</li>
                                <li>Use high-quality scans or photos</li>
                                <li>Ensure the document is the correct type as requested</li>
                            </ul>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('seller.verification.documents') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-upload"></i> Resubmit Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.upload-area {
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-area:hover {
    background-color: #f8f9fa;
    border-color: #0056b3 !important;
}

.upload-area.dragover {
    background-color: #e3f2fd;
    border-color: #1976d2 !important;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('document_file');
    const uploadArea = document.querySelector('.upload-area');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const submitBtn = document.getElementById('submitBtn');

    // File input change
    fileInput.addEventListener('change', function(e) {
        handleFileSelect(e.target.files[0]);
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect(file);
        }
    });

    function handleFileSelect(file) {
        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            filePreview.style.display = 'block';
            submitBtn.disabled = false;
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    window.clearFile = function() {
        fileInput.value = '';
        filePreview.style.display = 'none';
        submitBtn.disabled = true;
    }

    // Form submission
    document.getElementById('resubmitForm').addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        submitBtn.disabled = true;
    });
});
</script>
@endpush
