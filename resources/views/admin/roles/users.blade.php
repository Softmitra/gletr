@extends('layouts.admin')

@section('page_title', 'User Role Management')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Role Management</a></li>
    <li class="breadcrumb-item active">User Roles</li>
@stop

@section('admin-content')
    <div class="user-roles-container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-left">
                <h2 class="page-title">
                    <i class="fas fa-users-cog"></i>
                    User Role Management
                </h2>
                <p class="page-subtitle">Assign and manage user roles</p>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Roles
                </a>
                <button class="btn btn-primary" data-toggle="modal" data-target="#bulkAssignModal">
                    <i class="fas fa-users"></i> Bulk Assign
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Filter by Role</label>
                        <select name="role" class="form-control" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Search Users</label>
                        <input type="text" name="search" class="form-control" placeholder="Name or email..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.roles.users') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users"></i> Users ({{ $users->total() }})
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="selectAll">
                                        <label class="custom-control-label" for="selectAll"></label>
                                    </div>
                                </th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Current Roles</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input user-checkbox" 
                                                   id="user_{{ $user->id }}" value="{{ $user->id }}">
                                            <label class="custom-control-label" for="user_{{ $user->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=007bff&color=fff&size=40" 
                                                 alt="{{ $user->name }}" class="user-avatar">
                                            <div class="user-details">
                                                <div class="user-name">{{ $user->name }}</div>
                                                <div class="user-id">ID: {{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="user-email">{{ $user->email }}</span>
                                        @if($user->email_verified_at)
                                            <i class="fas fa-check-circle text-success" title="Verified"></i>
                                        @else
                                            <i class="fas fa-exclamation-circle text-warning" title="Unverified"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="user-roles">
                                            @forelse($user->roles as $role)
                                                <span class="badge badge-{{ $role->name === 'super_admin' ? 'danger' : ($role->name === 'ops_admin' ? 'warning' : 'secondary') }}">
                                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                                    @if(!in_array($role->name, ['super_admin']) || auth()->user()->hasRole('super_admin'))
                                                        <button type="button" class="btn-remove-role" 
                                                                onclick="removeRole({{ $user->id }}, {{ $role->id }})"
                                                                title="Remove role">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </span>
                                            @empty
                                                <span class="badge badge-light">No roles</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" 
                                                    onclick="showAssignRoleModal({{ $user->id }}, '{{ $user->name }}')"
                                                    title="Assign Role">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <a href="#" class="btn btn-outline-info" title="View Profile">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="no-users">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No users found</h5>
                                            <p class="text-muted">Try adjusting your search criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Assign Role Modal -->
    <div class="modal fade" id="assignRoleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Role</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.roles.users.assign') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="assignUserId">
                        <p>Assign role to: <strong id="assignUserName"></strong></p>
                        
                        <div class="form-group">
                            <label for="role_id">Select Role</label>
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">Choose a role...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Assign Modal -->
    <div class="modal fade" id="bulkAssignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Role Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.roles.users.bulk') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bulk_role_id">Select Role</label>
                            <select name="role_id" id="bulk_role_id" class="form-control" required>
                                <option value="">Choose a role...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="bulk_action">Action</label>
                            <select name="action" id="bulk_action" class="form-control" required>
                                <option value="assign">Assign Role</option>
                                <option value="remove">Remove Role</option>
                            </select>
                        </div>
                        
                        <div class="selected-users">
                            <p><strong>Selected Users:</strong> <span id="selectedUsersCount">0</span></p>
                            <div id="selectedUsersList"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Apply Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .user-roles-container {
            padding: 0;
        }

        .page-header {
            background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
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

        /* User Info */
        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .user-id {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .user-email {
            font-family: monospace;
            font-size: 0.85rem;
        }

        /* User Roles */
        .user-roles {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .user-roles .badge {
            position: relative;
            padding-right: 25px;
        }

        .btn-remove-role {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.8);
            font-size: 0.7rem;
            padding: 0;
            width: 14px;
            height: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-remove-role:hover {
            color: white;
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

        .no-users {
            padding: 40px 20px;
        }

        /* Selected Users */
        .selected-users {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }

        #selectedUsersList {
            max-height: 150px;
            overflow-y: auto;
            margin-top: 10px;
        }

        .selected-user-item {
            display: flex;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .selected-user-item:last-child {
            border-bottom: none;
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

            .user-info {
                flex-direction: column;
                text-align: center;
            }

            .user-avatar {
                margin-right: 0;
                margin-bottom: 5px;
            }

            .user-roles {
                justify-content: center;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedUsers();
        });

        // Individual checkbox change
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedUsers);
        });

        // Update selected users count and list
        function updateSelectedUsers() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            const count = checkedBoxes.length;
            
            document.getElementById('selectedUsersCount').textContent = count;
            
            const usersList = document.getElementById('selectedUsersList');
            usersList.innerHTML = '';
            
            checkedBoxes.forEach(checkbox => {
                const userId = checkbox.value;
                const userRow = checkbox.closest('tr');
                const userName = userRow.querySelector('.user-name').textContent;
                const userEmail = userRow.querySelector('.user-email').textContent;
                
                const userItem = document.createElement('div');
                userItem.className = 'selected-user-item';
                userItem.innerHTML = `
                    <input type="hidden" name="user_ids[]" value="${userId}">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=007bff&color=fff&size=24" 
                         alt="${userName}" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 10px;">
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem;">${userName}</div>
                        <div style="font-size: 0.8rem; color: #6c757d;">${userEmail}</div>
                    </div>
                `;
                usersList.appendChild(userItem);
            });
        }

        // Show assign role modal
        function showAssignRoleModal(userId, userName) {
            document.getElementById('assignUserId').value = userId;
            document.getElementById('assignUserName').textContent = userName;
            $('#assignRoleModal').modal('show');
        }

        // Remove role
        function removeRole(userId, roleId) {
            if (confirm('Are you sure you want to remove this role from the user?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.roles.users.remove") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const userIdInput = document.createElement('input');
                userIdInput.type = 'hidden';
                userIdInput.name = 'user_id';
                userIdInput.value = userId;
                form.appendChild(userIdInput);
                
                const roleIdInput = document.createElement('input');
                roleIdInput.type = 'hidden';
                roleIdInput.name = 'role_id';
                roleIdInput.value = roleId;
                form.appendChild(roleIdInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectedUsers();
        });
    </script>
@endpush
