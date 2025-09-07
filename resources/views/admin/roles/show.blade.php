@extends('layouts.admin')

@section('page_title', 'Role Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Role Management</a></li>
    <li class="breadcrumb-item active">{{ ucwords(str_replace('_', ' ', $role->name)) }}</li>
@stop

@section('admin-content')
    <div class="role-details-container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-left">
                <h2 class="page-title">
                    <i class="fas fa-user-shield"></i>
                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                </h2>
                <p class="page-subtitle">Role details and permissions</p>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Roles
                </a>
                @if(!in_array($role->name, ['super_admin', 'ops_admin', 'customer', 'guest']))
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Role
                    </a>
                @endif
            </div>
        </div>

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
                        <div class="role-info-item">
                            <label>Role Name:</label>
                            <span class="badge badge-primary">{{ $role->name }}</span>
                        </div>
                        <div class="role-info-item">
                            <label>Display Name:</label>
                            <span>{{ ucwords(str_replace('_', ' ', $role->name)) }}</span>
                        </div>
                        <div class="role-info-item">
                            <label>Guard:</label>
                            <span class="badge badge-secondary">{{ $role->guard_name }}</span>
                        </div>
                        <div class="role-info-item">
                            <label>Created:</label>
                            <span>{{ $role->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="role-info-item">
                            <label>Updated:</label>
                            <span>{{ $role->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="role-info-item">
                            <label>Total Users:</label>
                            <span class="badge badge-info">{{ $role->users->count() }}</span>
                        </div>
                        <div class="role-info-item">
                            <label>Total Permissions:</label>
                            <span class="badge badge-success">{{ $role->permissions->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Users with this role -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users"></i> Users ({{ $role->users->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($role->users->take(10) as $user)
                            <div class="user-item">
                                <div class="user-avatar">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=007bff&color=fff&size=32" alt="{{ $user->name }}">
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No users assigned to this role.</p>
                        @endforelse
                        
                        @if($role->users->count() > 10)
                            <div class="mt-2">
                                <small class="text-muted">And {{ $role->users->count() - 10 }} more users...</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-key"></i> Permissions ({{ $role->permissions->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($role->permissions->count() > 0)
                            @php
                                $groupedPermissions = $role->permissions->groupBy(function ($permission) {
                                    return explode(' ', $permission->name)[1] ?? 'general';
                                });
                            @endphp

                            @foreach($groupedPermissions as $category => $permissions)
                                <div class="permission-group mb-4">
                                    <h6 class="permission-category-title">
                                        <i class="fas fa-folder"></i> {{ ucwords(str_replace('_', ' ', $category)) }}
                                        <span class="badge badge-secondary ml-2">{{ $permissions->count() }}</span>
                                    </h6>
                                    <div class="permission-list">
                                        @foreach($permissions as $permission)
                                            <span class="badge badge-success permission-badge">
                                                <i class="fas fa-check"></i> {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-permissions">
                                <i class="fas fa-key fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No permissions assigned</h5>
                                <p class="text-muted">This role doesn't have any permissions assigned yet.</p>
                                @if(!in_array($role->name, ['super_admin', 'ops_admin', 'customer', 'guest']))
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Assign Permissions
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Available Permissions to Add -->
                @if($availablePermissions->count() > 0 && !in_array($role->name, ['super_admin', 'ops_admin', 'customer', 'guest']))
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-plus-circle"></i> Available Permissions ({{ $availablePermissions->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">These permissions are not yet assigned to this role:</p>
                            @php
                                $groupedAvailable = $availablePermissions->groupBy(function ($permission) {
                                    return explode(' ', $permission->name)[1] ?? 'general';
                                });
                            @endphp

                            @foreach($groupedAvailable->take(3) as $category => $permissions)
                                <div class="available-permission-group mb-3">
                                    <h6 class="text-muted">{{ ucwords(str_replace('_', ' ', $category)) }}</h6>
                                    <div class="permission-list">
                                        @foreach($permissions->take(5) as $permission)
                                            <span class="badge badge-light permission-badge">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if($permissions->count() > 5)
                                            <span class="badge badge-secondary">+{{ $permissions->count() - 5 }} more</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-3">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit Permissions
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .role-details-container {
            padding: 0;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .header-right .btn {
            margin-left: 10px;
        }

        /* Role Info Items */
        .role-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .role-info-item:last-child {
            border-bottom: none;
        }

        .role-info-item label {
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        /* User Items */
        .user-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .user-item:last-child {
            border-bottom: none;
        }

        .user-avatar img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .user-email {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Permission Groups */
        .permission-group {
            border-left: 3px solid #e9ecef;
            padding-left: 15px;
        }

        .permission-category-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
        }

        .permission-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .permission-badge {
            font-size: 0.75rem;
            padding: 5px 8px;
            margin: 2px;
        }

        .available-permission-group {
            border-left: 3px solid #dee2e6;
            padding-left: 15px;
        }

        /* No Permissions */
        .no-permissions {
            text-align: center;
            padding: 40px 20px;
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
        }

        .card-title {
            font-weight: 600;
            color: #2c3e50;
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

            .header-right .btn {
                margin: 5px;
            }

            .role-info-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .role-info-item label {
                margin-bottom: 5px;
            }
        }
    </style>
@endpush
