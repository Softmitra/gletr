<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoleManagementController extends Controller
{
    public function __construct()
    {
        // Middleware is handled by the route group in admin.php
        // No need for additional middleware here since admin routes already have auth + admin middleware
    }

    /**
     * Display roles and permissions overview
     */
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[1] ?? 'general';
        });
        
        $userStats = [
            'total_users' => User::count(),
            'super_admins' => User::role('super_admin')->count(),
            'ops_admins' => User::role('ops_admin')->count(),
            'seller_owners' => User::role('seller_owner')->count(),
            'seller_staff' => User::role('seller_staff')->count(),
            'customers' => User::role('customer')->count(),
            'no_role' => User::doesntHave('roles')->count(),
        ];

        return view('admin.roles.index', compact('roles', 'permissions', 'userStats'));
    }

    /**
     * Show role details
     */
    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        $availablePermissions = Permission::whereNotIn('id', $role->permissions->pluck('id'))->get();
        
        return view('admin.roles.show', compact('role', 'availablePermissions'));
    }

    /**
     * Show create role form
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[1] ?? 'general';
        });
        
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store new role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        DB::transaction(function () use ($request) {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            if ($request->permissions) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->syncPermissions($permissions);
            }
        });

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully!');
    }

    /**
     * Show edit role form
     */
    public function edit(Role $role)
    {
        // Prevent editing super_admin role
        if ($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')) {
            abort(403, 'Cannot edit super admin role.');
        }

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[1] ?? 'general';
        });
        
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update role
     */
    public function update(Request $request, Role $role)
    {
        // Prevent editing super_admin role
        if ($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')) {
            abort(403, 'Cannot edit super admin role.');
        }

        $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        DB::transaction(function () use ($request, $role) {
            if ($request->permissions) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }
        });

        return redirect()->route('admin.roles.show', $role)
            ->with('success', 'Role updated successfully!');
    }

    /**
     * Delete role
     */
    public function destroy(Role $role)
    {
        // Prevent deleting core roles
        $protectedRoles = ['super_admin', 'ops_admin', 'seller_owner', 'seller_staff', 'customer', 'guest'];
        
        if (in_array($role->name, $protectedRoles)) {
            return back()->withErrors(['error' => 'Cannot delete core system role.']);
        }

        if ($role->users()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete role that has assigned users.']);
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully!');
    }

    /**
     * Show user role management
     */
    public function users()
    {
        $users = User::with('roles')->paginate(20);
        $roles = Role::all();
        
        return view('admin.roles.users', compact('users', 'roles'));
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        // Prevent non-super-admin from assigning super_admin role
        if ($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')) {
            return back()->withErrors(['error' => 'Cannot assign super admin role.']);
        }

        // Prevent assigning role to super admin (except by super admin)
        if ($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
            return back()->withErrors(['error' => 'Cannot modify super admin user.']);
        }

        $user->assignRole($role);

        return back()->with('success', "Role '{$role->name}' assigned to {$user->name}");
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        // Prevent removing super_admin role
        if ($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')) {
            return back()->withErrors(['error' => 'Cannot remove super admin role.']);
        }

        // Prevent modifying super admin user
        if ($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
            return back()->withErrors(['error' => 'Cannot modify super admin user.']);
        }

        $user->removeRole($role);

        return back()->with('success', "Role '{$role->name}' removed from {$user->name}");
    }

    /**
     * Bulk role assignment
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'role_id' => 'required|exists:roles,id',
            'action' => 'required|in:assign,remove'
        ]);

        $role = Role::findOrFail($request->role_id);
        $users = User::whereIn('id', $request->user_ids)->get();

        // Security checks
        if ($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')) {
            return back()->withErrors(['error' => 'Cannot modify super admin role.']);
        }

        $count = 0;
        foreach ($users as $user) {
            // Skip super admin users if current user is not super admin
            if ($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
                continue;
            }

            if ($request->action === 'assign') {
                $user->assignRole($role);
            } else {
                $user->removeRole($role);
            }
            $count++;
        }

        $action = $request->action === 'assign' ? 'assigned to' : 'removed from';
        return back()->with('success', "Role '{$role->name}' {$action} {$count} users");
    }

    /**
     * Get role permissions via AJAX
     */
    public function getRolePermissions(Role $role)
    {
        return response()->json([
            'permissions' => $role->permissions->pluck('id')
        ]);
    }

    /**
     * Search users for role assignment
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->with('roles')
            ->limit(10)
            ->get();

        return response()->json($users);
    }
}