@extends('layouts.admin')

@section('page_title', 'Create Role')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Role Management</a></li>
    <li class="breadcrumb-item active">Create Role</li>
@stop

@section('admin-content')
    <div class="create-role-container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-left">
                <h2 class="page-title">
                    <i class="fas fa-plus-circle"></i>
                    Create New Role
                </h2>
                <p class="page-subtitle">Define a new role with specific permissions</p>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Roles
                </a>
            </div>
        </div>

        <form action="{{ route('admin.roles.store') }}" method="POST" id="createRoleForm">
            @csrf
            <div class="row">
                <!-- Role Information -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Role Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class="form-label required">Role Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="e.g., content_manager" required>
                                <small class="form-text text-muted">Use lowercase with underscores (e.g., content_manager)</small>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="display_name" class="form-label required">Display Name</label>
                                <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                       id="display_name" name="display_name" value="{{ old('display_name') }}" 
                                       placeholder="e.g., Content Manager" required>
                                <small class="form-text text-muted">Human-readable name for the role</small>
                                @error('display_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Brief description of this role...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="role-preview">
                                <h6>Role Preview:</h6>
                                <div class="preview-badge">
                                    <span class="badge badge-primary" id="rolePreview">New Role</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Create Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-block mt-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Permissions Selection -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-key"></i> Assign Permissions
                            </h5>
                            <div class="permission-controls">
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="selectAllPermissions()">
                                    <i class="fas fa-check-double"></i> Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-warning" onclick="deselectAllPermissions()">
                                    <i class="fas fa-times"></i> Deselect All
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($permissions->count() > 0)
                                @foreach($permissions as $category => $categoryPermissions)
                                    <div class="permission-category mb-4">
                                        <div class="category-header">
                                            <h6 class="category-title">
                                                <i class="fas fa-folder"></i> {{ ucwords(str_replace('_', ' ', $category)) }}
                                                <span class="badge badge-secondary">{{ $categoryPermissions->count() }}</span>
                                            </h6>
                                            <div class="category-controls">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        onclick="toggleCategoryPermissions('{{ $category }}')">
                                                    <i class="fas fa-check"></i> Toggle All
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="permissions-grid" data-category="{{ $category }}">
                                            @foreach($categoryPermissions as $permission)
                                                <div class="permission-item">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input permission-checkbox" 
                                                               id="permission_{{ $permission->id }}" 
                                                               name="permissions[]" 
                                                               value="{{ $permission->id }}"
                                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="permission_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-permissions">
                                    <i class="fas fa-key fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No permissions available</h5>
                                    <p class="text-muted">Please create some permissions first.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('css')
    <style>
        .create-role-container {
            padding: 0;
        }

        .page-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
        }

        .page-subtitle {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .form-label.required::after {
            content: " *";
            color: #dc3545;
        }

        /* Role Preview */
        .role-preview {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .preview-badge {
            margin-top: 10px;
        }

        /* Permission Categories */
        .permission-category {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            background: #f8f9fa;
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .category-title {
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        .permission-controls,
        .category-controls {
            display: flex;
            gap: 5px;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
        }

        .permission-item {
            background: white;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .permission-item:hover {
            border-color: #007bff;
            background: #f0f8ff;
        }

        .custom-control-label {
            font-size: 0.9rem;
            color: #495057;
            cursor: pointer;
        }

        .permission-checkbox:checked + .custom-control-label {
            color: #007bff;
            font-weight: 600;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        /* No Permissions */
        .no-permissions {
            text-align: center;
            padding: 40px 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                text-align: center;
            }

            .header-right {
                margin-top: 20px;
            }

            .category-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .category-controls {
                margin-top: 10px;
            }

            .permissions-grid {
                grid-template-columns: 1fr;
            }

            .permission-controls {
                margin-top: 10px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        // Update role preview
        function updateRolePreview() {
            const name = document.getElementById('name').value || 'New Role';
            const displayName = document.getElementById('display_name').value || name;
            document.getElementById('rolePreview').textContent = displayName;
        }

        // Auto-generate display name from role name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const displayName = name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            document.getElementById('display_name').value = displayName;
            updateRolePreview();
        });

        document.getElementById('display_name').addEventListener('input', updateRolePreview);

        // Select all permissions
        function selectAllPermissions() {
            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        // Deselect all permissions
        function deselectAllPermissions() {
            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        // Toggle category permissions
        function toggleCategoryPermissions(category) {
            const categoryGrid = document.querySelector(`[data-category="${category}"]`);
            const checkboxes = categoryGrid.querySelectorAll('.permission-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }

        // Form validation
        document.getElementById('createRoleForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const displayName = document.getElementById('display_name').value.trim();
            
            if (!name || !displayName) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
            
            // Check if role name follows convention
            if (!/^[a-z_]+$/.test(name)) {
                e.preventDefault();
                alert('Role name should only contain lowercase letters and underscores.');
                return false;
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateRolePreview();
        });
    </script>
@endpush
