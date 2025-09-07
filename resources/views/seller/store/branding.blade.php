@extends('seller.layouts.app')

@section('title', 'Store Branding')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Store Branding</h4>
                    <p class="text-muted mb-0">Customize your store's appearance and branding</p>
                </div>
                <a href="{{ route('seller.store.show') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Store
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Branding Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.store.branding.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Store Colors -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="primary_color">Primary Color</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control" id="primary_color" name="primary_color" 
                                               value="{{ $branding['primary_color'] ?? '#007bff' }}" style="height: 38px;">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ $branding['primary_color'] ?? '#007bff' }}</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Main color for buttons and highlights</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secondary_color">Secondary Color</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control" id="secondary_color" name="secondary_color" 
                                               value="{{ $branding['secondary_color'] ?? '#6c757d' }}" style="height: 38px;">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ $branding['secondary_color'] ?? '#6c757d' }}</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Secondary color for text and borders</small>
                                </div>
                            </div>
                        </div>

                        <!-- Store Tagline -->
                        <div class="form-group mb-4">
                            <label for="store_tagline">Store Tagline</label>
                            <input type="text" class="form-control" id="store_tagline" name="store_tagline" 
                                   value="{{ $branding['store_tagline'] ?? '' }}" 
                                   placeholder="Enter a catchy tagline for your store">
                            <small class="text-muted">A short phrase that describes your store (max 200 characters)</small>
                        </div>

                        <!-- Social Media Links -->
                        <h6 class="mb-3">Social Media Links</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social_facebook">Facebook URL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="social_facebook" name="social_facebook" 
                                               value="{{ $branding['social_facebook'] ?? '' }}" 
                                               placeholder="https://facebook.com/yourstore">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social_instagram">Instagram URL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="social_instagram" name="social_instagram" 
                                               value="{{ $branding['social_instagram'] ?? '' }}" 
                                               placeholder="https://instagram.com/yourstore">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social_twitter">Twitter URL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="social_twitter" name="social_twitter" 
                                               value="{{ $branding['social_twitter'] ?? '' }}" 
                                               placeholder="https://twitter.com/yourstore">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social_youtube">YouTube URL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="social_youtube" name="social_youtube" 
                                               value="{{ $branding['social_youtube'] ?? '' }}" 
                                               placeholder="https://youtube.com/yourstore">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Branding Settings
                            </button>
                            <a href="{{ route('seller.store.show') }}" class="btn btn-outline-secondary ml-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Preview</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Store preview will be available in a future update.
                    </div>
                    
                    <!-- Color Preview -->
                    <div class="mb-3">
                        <h6>Color Preview</h6>
                        <div class="d-flex gap-2">
                            <div class="color-preview" id="primary-preview" 
                                 style="width: 50px; height: 30px; border-radius: 4px; background-color: {{ $branding['primary_color'] ?? '#007bff' }};"></div>
                            <div class="color-preview" id="secondary-preview" 
                                 style="width: 50px; height: 30px; border-radius: 4px; background-color: {{ $branding['secondary_color'] ?? '#6c757d' }};"></div>
                        </div>
                    </div>

                    <!-- Tagline Preview -->
                    @if(!empty($branding['store_tagline']))
                    <div class="mb-3">
                        <h6>Tagline</h6>
                        <p class="text-muted font-italic">"{{ $branding['store_tagline'] }}"</p>
                    </div>
                    @endif

                    <!-- Social Links Preview -->
                    <div class="mb-3">
                        <h6>Social Links</h6>
                        <div class="d-flex gap-2">
                            @if(!empty($branding['social_facebook']))
                                <a href="{{ $branding['social_facebook'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if(!empty($branding['social_instagram']))
                                <a href="{{ $branding['social_instagram'] }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if(!empty($branding['social_twitter']))
                                <a href="{{ $branding['social_twitter'] }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if(!empty($branding['social_youtube']))
                                <a href="{{ $branding['social_youtube'] }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update color previews when colors change
    document.getElementById('primary_color').addEventListener('change', function() {
        document.getElementById('primary-preview').style.backgroundColor = this.value;
        this.nextElementSibling.querySelector('.input-group-text').textContent = this.value;
    });

    document.getElementById('secondary_color').addEventListener('change', function() {
        document.getElementById('secondary-preview').style.backgroundColor = this.value;
        this.nextElementSibling.querySelector('.input-group-text').textContent = this.value;
    });
});
</script>
@endpush

@push('styles')
<style>
.gap-2 {
    gap: 0.5rem;
}

.d-flex.gap-2 > * {
    margin-right: 0.5rem;
}

.d-flex.gap-2 > *:last-child {
    margin-right: 0;
}
</style>
@endpush
