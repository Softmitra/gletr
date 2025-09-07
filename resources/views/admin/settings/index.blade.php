@extends('layouts.admin')

@section('title', 'System Settings')

@section('page_title', 'System Settings')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!-- Settings Navigation -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Settings Categories</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <a href="#{{ $category }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ ucwords(str_replace('_', ' ', $category)) }}
                                <span class="badge badge-primary badge-pill">{{ $settings[$category]->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Settings Content -->
            @foreach($categories as $category)
                <div class="card" id="{{ $category }}">
                    <div class="card-header">
                        <h3 class="card-title">{{ ucwords(str_replace('_', ' ', $category)) }} Settings</h3>
                        <div class="card-tools">
                            @if($category === 'file_storage')
                                <a href="{{ route('admin.settings.file-storage') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-cog"></i> Configure
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($settings[$category] as $setting)
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="{{ $setting->key }}">
                                            {{ $setting->label }}
                                            @if($setting->is_required)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        
                                        @if($setting->type === 'boolean')
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" 
                                                       id="{{ $setting->key }}" 
                                                       {{ $setting->typed_value ? 'checked' : '' }}
                                                       disabled>
                                                <label class="custom-control-label" for="{{ $setting->key }}">
                                                    {{ $setting->typed_value ? 'Enabled' : 'Disabled' }}
                                                </label>
                                            </div>
                                        @elseif($setting->type === 'array' && $setting->options)
                                            <select class="form-control" disabled>
                                                @foreach($setting->options as $value => $label)
                                                    <option value="{{ $value }}" 
                                                            {{ in_array($value, $setting->typed_value ?? []) ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif($setting->options)
                                            <select class="form-control" disabled>
                                                @foreach($setting->options as $value => $label)
                                                    <option value="{{ $value }}" 
                                                            {{ $setting->typed_value == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control" 
                                                   value="{{ $setting->typed_value }}" 
                                                   disabled>
                                        @endif
                                        
                                        @if($setting->description)
                                            <small class="form-text text-muted">{{ $setting->description }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
