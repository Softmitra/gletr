@extends('layouts.admin')

@section('page_title', 'Email Configuration')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.business.setup') }}">Business Setup</a></li>
    <li class="breadcrumb-item active">Email Configuration</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope-open-text mr-2"></i>
                        Email Configuration Management
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" onclick="initializeConfigs()">
                            <i class="fas fa-sync-alt"></i> Initialize Default Configs
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.business.setup.email-settings.update') }}" id="emailConfigForm">
                        @csrf
                        @method('PUT')

                        <!-- Customer Email Configuration -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-users text-primary mr-2"></i>
                                            Customer Email Configuration
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        @if($customerEmails->count() > 0)
                                            @foreach($customerEmails as $index => $config)
                                                <div class="form-group border-bottom pb-3 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label class="font-weight-bold">
                                                            {{ $customerEvents[$config->event] ?? ucfirst($config->event) }}
                                                        </label>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" 
                                                                   class="custom-control-input email-toggle" 
                                                                   id="customer_{{ $config->id }}"
                                                                   name="configs[{{ $index }}][is_enabled]"
                                                                   value="1"
                                                                   data-config-id="{{ $config->id }}"
                                                                   {{ $config->is_enabled ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="customer_{{ $config->id }}"></label>
                                                        </div>
                                                    </div>
                                                    
                                                    <input type="hidden" name="configs[{{ $index }}][id]" value="{{ $config->id }}">
                                                    
                                                    <div class="form-group">
                                                        <label for="customer_subject_{{ $config->id }}">Email Subject</label>
                                                        <input type="text" 
                                                               class="form-control" 
                                                               id="customer_subject_{{ $config->id }}"
                                                               name="configs[{{ $index }}][subject]"
                                                               value="{{ $config->subject }}"
                                                               {{ !$config->is_enabled ? 'disabled' : '' }}>
                                                    </div>
                                                    
                                                    @if($config->description)
                                                        <small class="text-muted">{{ $config->description }}</small>
                                                    @endif
                                                    
                                                    <div class="mt-2">
                                                        <button type="button" 
                                                                class="btn btn-outline-info btn-xs mr-2"
                                                                onclick="testEmail('customer', '{{ $config->event }}')">
                                                            <i class="fas fa-paper-plane"></i> Test Email
                                                        </button>
                                                        <button type="button" 
                                                                class="btn btn-outline-secondary btn-xs"
                                                                onclick="previewEmail('customer', '{{ $config->event }}')">
                                                            <i class="fas fa-eye"></i> Preview
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-envelope-open text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2">No customer email configurations found.</p>
                                                <button type="button" class="btn btn-primary" onclick="initializeConfigs()">
                                                    Initialize Default Configurations
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Seller Email Configuration -->
                            <div class="col-lg-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-store text-success mr-2"></i>
                                            Seller Email Configuration
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        @if($sellerEmails->count() > 0)
                                            @foreach($sellerEmails as $index => $config)
                                                <div class="form-group border-bottom pb-3 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label class="font-weight-bold">
                                                            {{ $sellerEvents[$config->event] ?? ucfirst($config->event) }}
                                                        </label>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" 
                                                                   class="custom-control-input email-toggle" 
                                                                   id="seller_{{ $config->id }}"
                                                                   name="configs[{{ $customerEmails->count() + $index }}][is_enabled]"
                                                                   value="1"
                                                                   data-config-id="{{ $config->id }}"
                                                                   {{ $config->is_enabled ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="seller_{{ $config->id }}"></label>
                                                        </div>
                                                    </div>
                                                    
                                                    <input type="hidden" name="configs[{{ $customerEmails->count() + $index }}][id]" value="{{ $config->id }}">
                                                    
                                                    <div class="form-group">
                                                        <label for="seller_subject_{{ $config->id }}">Email Subject</label>
                                                        <input type="text" 
                                                               class="form-control" 
                                                               id="seller_subject_{{ $config->id }}"
                                                               name="configs[{{ $customerEmails->count() + $index }}][subject]"
                                                               value="{{ $config->subject }}"
                                                               {{ !$config->is_enabled ? 'disabled' : '' }}>
                                                    </div>
                                                    
                                                    @if($config->description)
                                                        <small class="text-muted">{{ $config->description }}</small>
                                                    @endif
                                                    
                                                    <div class="mt-2">
                                                        <button type="button" 
                                                                class="btn btn-outline-info btn-xs mr-2"
                                                                onclick="testEmail('seller', '{{ $config->event }}')">
                                                            <i class="fas fa-paper-plane"></i> Test Email
                                                        </button>
                                                        <button type="button" 
                                                                class="btn btn-outline-secondary btn-xs"
                                                                onclick="previewEmail('seller', '{{ $config->event }}')">
                                                            <i class="fas fa-eye"></i> Preview
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-store text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2">No seller email configurations found.</p>
                                                <button type="button" class="btn btn-success" onclick="initializeConfigs()">
                                                    Initialize Default Configurations
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Save Email Configuration
                                        </button>
                                        <a href="{{ route('admin.business.setup') }}" class="btn btn-secondary ml-2">
                                            <i class="fas fa-arrow-left mr-2"></i>Back to Business Setup
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Email Modal -->
<div class="modal fade" id="testEmailModal" tabindex="-1" role="dialog" aria-labelledby="testEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testEmailModalLabel">
                    <i class="fas fa-paper-plane mr-2"></i>Test Email Configuration
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="testEmailForm">
                    <input type="hidden" id="testEmailType" name="type">
                    <input type="hidden" id="testEmailEvent" name="event">
                    
                    <div class="form-group">
                        <label for="testEmailAddress">Test Email Address</label>
                        <input type="email" class="form-control" id="testEmailAddress" name="test_email" required>
                        <small class="form-text text-muted">Enter email address to send test email</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendTestEmail()">
                    <i class="fas fa-paper-plane mr-2"></i>Send Test Email
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Handle email toggle switches
    $('.email-toggle').on('change', function() {
        const configId = $(this).data('config-id');
        const isEnabled = $(this).is(':checked');
        const subjectInput = $(this).closest('.form-group').find('input[type="text"]');
        
        // Enable/disable subject input
        subjectInput.prop('disabled', !isEnabled);
        
        // AJAX call to toggle immediately
        $.ajax({
            url: '{{ route("admin.business.setup.email-settings.toggle") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: configId,
                is_enabled: isEnabled
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function() {
                showNotification('Failed to update email configuration', 'error');
                // Revert toggle state
                $(this).prop('checked', !isEnabled);
            }
        });
    });
});

function initializeConfigs() {
    if (confirm('This will create default email configurations. Continue?')) {
        $.ajax({
            url: '{{ route("admin.business.setup.email-settings.initialize") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function() {
                showNotification('Failed to initialize email configurations', 'error');
            }
        });
    }
}

function testEmail(type, event) {
    $('#testEmailType').val(type);
    $('#testEmailEvent').val(event);
    $('#testEmailModal').modal('show');
}

function previewEmail(type, event) {
    const previewUrl = '{{ route("admin.business.setup.email-settings.preview") }}' + '?type=' + type + '&event=' + event;
    window.open(previewUrl, 'emailPreview', 'width=800,height=600,scrollbars=yes,resizable=yes');
}

function sendTestEmail() {
    const form = $('#testEmailForm');
    const formData = form.serialize();
    
    $.ajax({
        url: '{{ route("admin.business.setup.email-settings.test") }}',
        method: 'POST',
        data: formData + '&_token={{ csrf_token() }}',
        success: function(response) {
            if (response.success) {
                showNotification(response.message, 'success');
                $('#testEmailModal').modal('hide');
            } else {
                showNotification(response.message, 'error');
            }
        },
        error: function() {
            showNotification('Failed to send test email', 'error');
        }
    });
}

function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
    
    const alert = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas fa-${icon} mr-2"></i>${message}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    
    $('.card-body').prepend(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
@endsection
