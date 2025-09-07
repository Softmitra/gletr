@extends('layouts.admin')

@section('page_title', 'Role Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Role Management</li>
@stop

@section('admin-content')
    <div class="role-management-container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-left">
                <h2 class="page-title">
                    <i class="fas fa-user-shield"></i>
                    Role & Permission Management
                </h2>
                <p class="page-subtitle">Manage user roles and permissions for the system</p>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Role
                </a>
                <a href="{{ route('admin.roles.users') }}" class="btn btn-info">
                    <i class="fas fa-users"></i> Manage User Roles
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card bg-primary">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number text-white text-center">{{ $userStats['total_users'] }}</div>
                        <div class="stat-label text-white text-center">Total Users</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-danger">
                    <div class="stat-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number text-white text-center">{{ $userStats['super_admins'] }}</div>
                        <div class="stat-label text-white text-center">Super Admins</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-warning">
                    <div class="stat-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number text-white text-center">{{ $userStats['ops_admins'] }}</div>
                        <div class="stat-label text-white text-center">Ops Admins</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-success">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number text-white text-center">{{ $userStats['customers'] }}</div>
                        <div class="stat-label text-white text-center">Customers</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles Section -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-tag"></i> System Roles
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Role Name</th>
                                        <th>Users</th>
                                        <th>Permissions</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                        <tr>
                                            <td>
                                                <div class="role-info">
                                                    <span class="role-name">{{ ucwords(str_replace('_', ' ', $role->name)) }}</span>
                                                    <span class="badge badge-{{ $role->name === 'super_admin' ? 'danger' : ($role->name === 'ops_admin' ? 'warning' : 'secondary') }}">
                                                        {{ $role->name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $role->users_count }} users</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ $role->permissions->count() }} permissions</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $role->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-outline-primary" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(!in_array($role->name, ['super_admin', 'ops_admin', 'customer', 'guest']))
                                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-warning" title="Edit Role">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-outline-danger" onclick="deleteRole({{ $role->id }})" title="Delete Role">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <span class="badge badge-secondary">Protected</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="no-data">
                                                    <i class="fas fa-user-shield fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No roles found</h5>
                                                    <p class="text-muted">Create your first role to get started.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Overview -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-key"></i> Permissions Overview
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($permissions as $category => $categoryPermissions)
                            <div class="permission-category mb-3">
                                <h6 class="category-title">
                                    <i class="fas fa-folder"></i> {{ ucwords(str_replace('_', ' ', $category)) }}
                                </h6>
                                <div class="permission-list">
                                    @foreach($categoryPermissions->take(5) as $permission)
                                        <span class="badge badge-light permission-badge">{{ $permission->name }}</span>
                                    @endforeach
                                    @if($categoryPermissions->count() > 5)
                                        <span class="badge badge-secondary">+{{ $categoryPermissions->count() - 5 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-block mb-2">
                                <i class="fas fa-plus"></i> Create New Role
                            </a>
                            <a href="{{ route('admin.roles.users') }}" class="btn btn-info btn-block mb-2">
                                <i class="fas fa-users"></i> Manage User Roles
                            </a>
                            <button class="btn btn-warning btn-block mb-2" onclick="syncPermissions()">
                                <i class="fas fa-sync"></i> Sync Permissions
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-user-friends"></i> View All Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .role-management-container {
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

        /* Statistics Cards */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card.bg-primary { border-left: 4px solid #007bff; }
        .stat-card.bg-danger { border-left: 4px solid #dc3545; }
        .stat-card.bg-warning { border-left: 4px solid #ffc107; }
        .stat-card.bg-success { border-left: 4px solid #28a745; }

        .stat-icon {
            font-size: 2.5rem;
            margin-right: 20px;
            opacity: 0.7;
        }

        .stat-card.bg-primary .stat-icon { color: #007bff; }
        .stat-card.bg-danger .stat-icon { color: #dc3545; }
        .stat-card.bg-warning .stat-icon { color: #ffc107; }
        .stat-card.bg-success .stat-icon { color: #28a745; }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Role Info */
        .role-info {
            display: flex;
            flex-direction: column;
        }

        .role-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        /* Permission Categories */
        .permission-category {
            border-left: 3px solid #e9ecef;
            padding-left: 15px;
        }

        .category-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        .permission-badge {
            font-size: 0.75rem;
            margin: 2px;
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

        /* Table */
        .table th {
            font-weight: 600;
            color: #495057;
            border-top: none;
        }

        .table td {
            vertical-align: middle;
        }

        .no-data {
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

            .header-right .btn {
                margin: 5px;
            }

            .stat-card {
                text-align: center;
                flex-direction: column;
            }

            .stat-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        function deleteRole(roleId) {
            if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/roles/${roleId}`;
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add method override
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        function syncPermissions() {
            if (confirm('This will sync all permissions with the database. Continue?')) {
                // You can implement permission sync functionality here
                alert('Permission sync functionality can be implemented here');
            }
        }

        // Initialize tooltips
        $(document).ready(function() {
            $('[title]').tooltip();
        });
    </script>
@endpush
