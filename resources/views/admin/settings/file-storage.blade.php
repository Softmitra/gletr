@extends('layouts.admin')

@section('title', 'File Storage Settings')

@section('page_title', 'File Storage Settings')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item active">File Storage</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <form action="{{ route('admin.settings.file-storage.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary">
                    <div class="card-body text-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="mb-1">
                                    <i class="fas fa-hdd mr-2"></i>File Storage Configuration
                                </h3>
                                <p class="mb-0 opacity-75">Configure how files are stored, managed, and secured in your application</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-light btn-lg mr-2">
                                        <i class="fas fa-save mr-1"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-lg" onclick="resetSettings()">
                                        <i class="fas fa-undo mr-1"></i>Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <!-- Storage Configuration -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-cogs text-primary mr-2"></i>Storage Configuration
                            </h5>
                            <span class="badge badge-primary badge-pill">Core Settings</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_storage_driver" class="font-weight-bold">
                                        <i class="fas fa-server text-info mr-1"></i>Storage Driver
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control form-control-lg @error('file_storage_driver') is-invalid @enderror" 
                                            id="file_storage_driver" name="file_storage_driver">
                                        @foreach($groups['storage'] as $setting)
                                            @foreach($setting->options as $value => $label)
                                                <option value="{{ $value }}" 
                                                        {{ old('file_storage_driver', $groups['storage']->firstWhere('key', 'file_storage_driver')->typed_value) == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('file_storage_driver')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Choose where files will be stored
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_storage_max_size" class="font-weight-bold">
                                        <i class="fas fa-weight-hanging text-warning mr-1"></i>Maximum File Size (MB)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <input type="number" class="form-control @error('file_storage_max_size') is-invalid @enderror" 
                                               id="file_storage_max_size" name="file_storage_max_size" 
                                               value="{{ old('file_storage_max_size', $groups['limits']->firstWhere('key', 'file_storage_max_size')->typed_value) }}"
                                               min="1" max="100">
                                        <div class="input-group-append">
                                            <span class="input-group-text">MB</span>
                                        </div>
                                    </div>
                                    @error('file_storage_max_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Maximum allowed file size in megabytes
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <label class="font-weight-bold">
                                    <i class="fas fa-file-alt text-success mr-1"></i>Allowed File Types
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="row">
                                    @foreach($groups['types']->firstWhere('key', 'file_storage_allowed_types')->options as $value => $label)
                                        <div class="col-md-4 mb-3">
                                            <div class="custom-control custom-checkbox custom-control-lg">
                                                <input type="checkbox" class="custom-control-input" 
                                                       id="file_storage_allowed_types_{{ $value }}" 
                                                       name="file_storage_allowed_types[]" 
                                                       value="{{ $value }}"
                                                       {{ in_array($value, old('file_storage_allowed_types', $groups['types']->firstWhere('key', 'file_storage_allowed_types')->typed_value ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="file_storage_allowed_types_{{ $value }}">
                                                    <i class="fas fa-file-{{ $value }} mr-2"></i>{{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('file_storage_allowed_types')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AWS S3 Configuration -->
                <div class="card shadow-sm mb-4" id="s3-config" style="display: none;">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fab fa-aws text-warning mr-2"></i>Amazon S3 Configuration
                            </h5>
                            <button type="button" class="btn btn-info btn-sm" onclick="testS3Connection()">
                                <i class="fas fa-plug mr-1"></i>Test Connection
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Note:</strong> Make sure to configure your AWS credentials in the .env file before testing the connection.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aws_s3_bucket" class="font-weight-bold">
                                        <i class="fas fa-database text-primary mr-1"></i>S3 Bucket Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('aws_s3_bucket') is-invalid @enderror" 
                                           id="aws_s3_bucket" name="aws_s3_bucket" 
                                           value="{{ old('aws_s3_bucket', $groups['s3']->firstWhere('key', 'aws_s3_bucket')->typed_value) }}"
                                           placeholder="my-app-bucket">
                                    @error('aws_s3_bucket')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aws_s3_region" class="font-weight-bold">
                                        <i class="fas fa-globe text-success mr-1"></i>S3 Region
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control form-control-lg @error('aws_s3_region') is-invalid @enderror" 
                                            id="aws_s3_region" name="aws_s3_region">
                                        @foreach($groups['s3']->firstWhere('key', 'aws_s3_region')->options as $value => $label)
                                            <option value="{{ $value }}" 
                                                    {{ old('aws_s3_region', $groups['s3']->firstWhere('key', 'aws_s3_region')->typed_value) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aws_s3_region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aws_s3_url" class="font-weight-bold">
                                        <i class="fas fa-link text-info mr-1"></i>S3 Endpoint URL
                                    </label>
                                    <input type="url" class="form-control @error('aws_s3_url') is-invalid @enderror" 
                                           id="aws_s3_url" name="aws_s3_url" 
                                           value="{{ old('aws_s3_url', $groups['s3']->firstWhere('key', 'aws_s3_url')->typed_value) }}"
                                           placeholder="https://s3.amazonaws.com">
                                    @error('aws_s3_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Leave empty for default AWS endpoint
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch mt-4">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="aws_s3_use_path_style_endpoint" 
                                               name="aws_s3_use_path_style_endpoint" 
                                               value="1"
                                               {{ old('aws_s3_use_path_style_endpoint', $groups['s3']->firstWhere('key', 'aws_s3_use_path_style_endpoint')->typed_value) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="aws_s3_use_path_style_endpoint">
                                            <i class="fas fa-route text-warning mr-1"></i>Use Path Style Endpoint
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Use path-style endpoint instead of virtual-hosted-style
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Settings -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-upload text-success mr-2"></i>Upload Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_upload_max_files" class="font-weight-bold">
                                        <i class="fas fa-layer-group text-info mr-1"></i>Maximum Files per Upload
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('file_upload_max_files') is-invalid @enderror" 
                                               id="file_upload_max_files" name="file_upload_max_files" 
                                               value="{{ old('file_upload_max_files', $groups['upload']->firstWhere('key', 'file_upload_max_files')->typed_value) }}"
                                               min="1" max="50">
                                        <div class="input-group-append">
                                            <span class="input-group-text">files</span>
                                        </div>
                                    </div>
                                    @error('file_upload_max_files')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch mt-4">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="file_upload_auto_resize_images" 
                                               name="file_upload_auto_resize_images" 
                                               value="1"
                                               {{ old('file_upload_auto_resize_images', $groups['upload']->firstWhere('key', 'file_upload_auto_resize_images')->typed_value) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="file_upload_auto_resize_images">
                                            <i class="fas fa-compress-arrows-alt text-warning mr-1"></i>Auto Resize Images
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Automatically resize large images to save storage space
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="image-settings" style="display: none;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="file_upload_image_max_width" class="font-weight-bold">
                                        <i class="fas fa-arrows-alt-h text-primary mr-1"></i>Maximum Image Width
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('file_upload_image_max_width') is-invalid @enderror" 
                                               id="file_upload_image_max_width" name="file_upload_image_max_width" 
                                               value="{{ old('file_upload_image_max_width', $groups['upload']->firstWhere('key', 'file_upload_image_max_width')->typed_value) }}"
                                               min="100" max="4000">
                                        <div class="input-group-append">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                    @error('file_upload_image_max_width')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Maximum width in pixels</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="file_upload_image_max_height" class="font-weight-bold">
                                        <i class="fas fa-arrows-alt-v text-success mr-1"></i>Maximum Image Height
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('file_upload_image_max_height') is-invalid @enderror" 
                                               id="file_upload_image_max_height" name="file_upload_image_max_height" 
                                               value="{{ old('file_upload_image_max_height', $groups['upload']->firstWhere('key', 'file_upload_image_max_height')->typed_value) }}"
                                               min="100" max="4000">
                                        <div class="input-group-append">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                    @error('file_upload_image_max_height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Maximum height in pixels</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="file_upload_image_quality" class="font-weight-bold">
                                        <i class="fas fa-star text-warning mr-1"></i>Image Quality
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('file_upload_image_quality') is-invalid @enderror" 
                                               id="file_upload_image_quality" name="file_upload_image_quality" 
                                               value="{{ old('file_upload_image_quality', $groups['upload']->firstWhere('key', 'file_upload_image_quality')->typed_value) }}"
                                               min="1" max="100">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    @error('file_upload_image_quality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">JPEG quality (1-100)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization Settings -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-folder text-info mr-2"></i>File Organization
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="file_storage_organize_by_date" 
                                               name="file_storage_organize_by_date" 
                                               value="1"
                                               {{ old('file_storage_organize_by_date', $groups['organization']->firstWhere('key', 'file_storage_organize_by_date')->typed_value) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="file_storage_organize_by_date">
                                            <i class="fas fa-calendar-alt text-primary mr-1"></i>Organize Files by Date
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Automatically organize uploaded files by date folders
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="file_storage_keep_original_name" 
                                               name="file_storage_keep_original_name" 
                                               value="1"
                                               {{ old('file_storage_keep_original_name', $groups['naming']->firstWhere('key', 'file_storage_keep_original_name')->typed_value) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="file_storage_keep_original_name">
                                            <i class="fas fa-file-signature text-success mr-1"></i>Keep Original Filename
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Keep original filename instead of generating unique names
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-shield-alt text-danger mr-2"></i>Security Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="file_storage_scan_virus" 
                                               name="file_storage_scan_virus" 
                                               value="1"
                                               {{ old('file_storage_scan_virus', $groups['security']->firstWhere('key', 'file_storage_scan_virus')->typed_value) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="file_storage_scan_virus">
                                            <i class="fas fa-virus-slash text-success mr-1"></i>Virus Scan Files
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Scan uploaded files for viruses
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="file_storage_block_executable" 
                                               name="file_storage_block_executable" 
                                               value="1"
                                               {{ old('file_storage_block_executable', $groups['security']->firstWhere('key', 'file_storage_block_executable')->typed_value) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="file_storage_block_executable">
                                            <i class="fas fa-ban text-danger mr-1"></i>Block Executable Files
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Block upload of executable files
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="file_storage_require_authentication" 
                                               name="file_storage_require_authentication" 
                                               value="1"
                                               {{ old('file_storage_require_authentication', $groups['security']->firstWhere('key', 'file_storage_require_authentication')->typed_value) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="file_storage_require_authentication">
                                            <i class="fas fa-user-lock text-warning mr-1"></i>Require Authentication
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>Require user authentication for file uploads
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Quick Actions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt text-warning mr-2"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save mr-2"></i>Save Settings
                            </button>
                            
                            <button type="button" class="btn btn-warning" onclick="resetSettings()">
                                <i class="fas fa-undo mr-2"></i>Reset to Default
                            </button>
                            
                            <a href="{{ route('admin.settings.export') }}" class="btn btn-info">
                                <i class="fas fa-download mr-2"></i>Export Settings
                            </a>
                            
                            <button type="button" class="btn btn-secondary" onclick="showImportModal()">
                                <i class="fas fa-upload mr-2"></i>Import Settings
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Information Panel -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle text-info mr-2"></i>Information & Tips
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info border-0 mb-3">
                            <h6><i class="fas fa-lightbulb text-warning mr-2"></i>Quick Tips:</h6>
                            <ul class="mb-0 pl-3">
                                <li>Test S3 connection before saving</li>
                                <li>Configure AWS credentials in .env file</li>
                                <li>Enable virus scanning for better security</li>
                                <li>Use path-style endpoints for compatibility</li>
                            </ul>
                        </div>
                        
                        <div class="alert alert-success border-0">
                            <h6><i class="fas fa-check-circle text-success mr-2"></i>Best Practices:</h6>
                            <ul class="mb-0 pl-3">
                                <li>Set appropriate file size limits</li>
                                <li>Enable auto-resize for images</li>
                                <li>Use secure file types only</li>
                                <li>Regular backup of settings</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Storage Status -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-pie text-success mr-2"></i>Storage Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <div class="border-right">
                                    <h4 class="text-primary mb-1" id="current-driver">
                                        {{ ucfirst($groups['storage']->firstWhere('key', 'file_storage_driver')->typed_value) }}
                                    </h4>
                                    <small class="text-muted">Current Driver</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-1" id="max-size">
                                    {{ $groups['limits']->firstWhere('key', 'file_storage_max_size')->typed_value }}MB
                                </h4>
                                <small class="text-muted">Max File Size</small>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshStatus()">
                                <i class="fas fa-sync-alt mr-1"></i>Refresh Status
                            </button>
                        </div>
                    </div>
                </div>

                <!-- File Type Summary -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt text-primary mr-2"></i>Allowed File Types
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($groups['types']->firstWhere('key', 'file_storage_allowed_types')->options as $value => $label)
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-{{ $value }} text-{{ $value == 'image' ? 'success' : ($value == 'document' ? 'primary' : ($value == 'video' ? 'danger' : 'warning')) }} mr-2"></i>
                                        <small class="text-muted">{{ $label }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-upload mr-2"></i>Import Settings
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.settings.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="settings_file" class="font-weight-bold">
                            <i class="fas fa-file-json text-warning mr-1"></i>Settings File (JSON)
                        </label>
                        <input type="file" class="form-control-file" id="settings_file" name="settings_file" accept=".json" required>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle mr-1"></i>Upload a JSON file exported from settings
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload mr-1"></i>Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
/* Modern Card Styling */
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

/* Form Controls */
.form-control, .form-control-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-color: #fafbfc;
}

.form-control:focus, .form-control-lg:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    background-color: #ffffff;
    transform: translateY(-1px);
}

/* Custom Checkboxes */
.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.custom-control-label {
    font-weight: 500;
    color: #495057;
    padding-left: 0.5rem;
}

/* Buttons */
.btn {
    border-radius: 10px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    border: none;
    text-transform: none;
    letter-spacing: 0.5px;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: #212529;
}

.btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

/* Alerts */
.alert {
    border-radius: 10px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
}

.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

/* Badges */
.badge {
    border-radius: 20px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
}

.badge-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

/* Input Groups */
.input-group-text {
    border-radius: 0 10px 10px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid #e9ecef;
    color: #6c757d;
    font-weight: 500;
}

.input-group .form-control {
    border-radius: 10px 0 0 10px;
}

/* Modal Styling */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
    border-radius: 15px 15px 0 0;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-bottom: none;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.modal-header .close:hover {
    opacity: 1;
}

/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

/* Status Display */
#current-driver, #max-size {
    font-weight: 700;
    font-size: 1.5rem;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate__fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .form-control-lg {
        font-size: 1rem;
        padding: 0.75rem;
    }
}

/* Hover Effects */
.form-group:hover .form-control {
    border-color: #007bff;
}

.custom-control:hover .custom-control-label {
    color: #007bff;
}

/* Loading States */
.btn:disabled {
    opacity: 0.7;
    transform: none;
}

/* Success States */
.form-control.is-valid {
    border-color: #28a745;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
}

/* Error States */
.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E");
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #007bff;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #0056b3;
}

/* File Type Icons */
.fa-file-image { color: #28a745 !important; }
.fa-file-document { color: #007bff !important; }
.fa-file-video { color: #dc3545 !important; }
.fa-file-audio { color: #ffc107 !important; }
.fa-file-archive { color: #6f42c1 !important; }
.fa-file-spreadsheet { color: #fd7e14 !important; }

/* Enhanced Card Interactions */
.card {
    position: relative;
    overflow: hidden;
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.card:hover::before {
    left: 100%;
}

/* Status Indicators */
.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.status-active {
    background-color: #28a745;
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.2);
}

.status-inactive {
    background-color: #6c757d;
    box-shadow: 0 0 0 2px rgba(108, 117, 125, 0.2);
}

/* Enhanced Form Groups */
.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    display: block;
}

.form-group .form-control {
    position: relative;
    z-index: 1;
}

.form-group .form-control:focus + label {
    color: #007bff;
}

/* Progress Indicators */
.progress-ring {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: conic-gradient(#007bff 0deg, #e9ecef 0deg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.progress-ring::before {
    content: attr(data-progress) '%';
    font-size: 12px;
    font-weight: 600;
    color: #007bff;
}

/* Enhanced Buttons */
.btn {
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.3s, height 0.3s;
}

.btn:hover::before {
    width: 300px;
    height: 300px;
}

/* Loading States */
.loading {
    position: relative;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Enhanced Alerts */
.alert {
    position: relative;
    overflow: hidden;
}

.alert::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
    opacity: 0.3;
}

/* Responsive Grid */
@media (max-width: 768px) {
    .d-grid {
        grid-template-columns: 1fr;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .form-control-lg {
        font-size: 1rem;
        padding: 0.75rem;
    }
    
    .col-md-4 .card {
        margin-bottom: 1rem;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .card {
        background-color: #2d3748;
        color: #e2e8f0;
    }
    
    .form-control {
        background-color: #4a5568;
        border-color: #718096;
        color: #e2e8f0;
    }
    
    .form-control:focus {
        background-color: #2d3748;
        border-color: #3182ce;
    }
}
</style>
@endpush

@push('js')
<script>
// Show/hide S3 configuration based on storage driver
document.getElementById('file_storage_driver').addEventListener('change', function() {
    const s3Config = document.getElementById('s3-config');
    const currentDriver = document.getElementById('current-driver');
    
    if (this.value === 's3') {
        s3Config.style.display = 'block';
        s3Config.classList.add('animate__fadeInUp');
    } else {
        s3Config.style.display = 'none';
    }
    
    // Update status display
    currentDriver.textContent = this.options[this.selectedIndex].text;
});

// Show/hide image settings based on auto resize
document.getElementById('file_upload_auto_resize_images').addEventListener('change', function() {
    const imageSettings = document.getElementById('image-settings');
    
    if (this.checked) {
        imageSettings.style.display = 'block';
        imageSettings.classList.add('animate__fadeInUp');
    } else {
        imageSettings.style.display = 'none';
    }
});

// Update max size display
document.getElementById('file_storage_max_size').addEventListener('input', function() {
    document.getElementById('max-size').textContent = this.value + 'MB';
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Trigger change events to set initial state
    document.getElementById('file_storage_driver').dispatchEvent(new Event('change'));
    document.getElementById('file_upload_auto_resize_images').dispatchEvent(new Event('change'));
    
    // Add loading animation to cards
    document.querySelectorAll('.card').forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate__fadeInUp');
        }, index * 100);
    });
});

// Test S3 connection with improved UI
function testS3Connection() {
    const bucket = document.getElementById('aws_s3_bucket').value;
    const region = document.getElementById('aws_s3_region').value;
    const url = document.getElementById('aws_s3_url').value;

    if (!bucket || !region) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please fill in S3 bucket name and region',
            confirmButtonColor: '#007bff',
            background: '#f8f9fa',
            backdrop: 'rgba(0,0,0,0.4)'
        });
        return;
    }

    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';
    button.disabled = true;

    fetch('{{ route("admin.settings.test-s3") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            aws_s3_bucket: bucket,
            aws_s3_region: region,
            aws_s3_url: url
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Connection Successful!',
                text: 'S3 connection test completed successfully.',
                confirmButtonColor: '#28a745',
                background: '#f8f9fa',
                backdrop: 'rgba(0,0,0,0.4)'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Connection Failed',
                text: 'S3 connection test failed: ' + data.message,
                confirmButtonColor: '#dc3545',
                background: '#f8f9fa',
                backdrop: 'rgba(0,0,0,0.4)'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Connection Error',
            text: 'S3 connection test failed: ' + error.message,
            confirmButtonColor: '#dc3545',
            background: '#f8f9fa',
            backdrop: 'rgba(0,0,0,0.4)'
        });
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Reset settings with confirmation
function resetSettings() {
    Swal.fire({
        title: 'Reset Settings?',
        text: 'Are you sure you want to reset all file storage settings to default values?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, reset!',
        cancelButtonText: 'Cancel',
        background: '#f8f9fa',
        backdrop: 'rgba(0,0,0,0.4)'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route("admin.settings.reset") }}?category=file_storage';
        }
    });
}

// Show import modal
function showImportModal() {
    $('#importModal').modal('show');
}

// Refresh status with animation
function refreshStatus() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        
        // Update status with animation
        const currentDriver = document.getElementById('current-driver');
        currentDriver.style.transform = 'scale(1.1)';
        currentDriver.style.color = '#28a745';
        
        setTimeout(() => {
            currentDriver.style.transform = 'scale(1)';
            currentDriver.style.color = '#007bff';
        }, 500);
    }, 1000);
}

// Add smooth scrolling for better UX
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add form validation feedback
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value.trim() !== '') {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
        } else if (this.hasAttribute('required')) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        }
    });
});
</script>
@endpush
