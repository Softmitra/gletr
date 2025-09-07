@extends('layouts.seller')

@section('title', 'Add Team Member')
@section('page-title', 'Add Team Member')

@section('breadcrumb')
<li class="flex items-center">
    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
    </svg>
    <a href="{{ route('seller.team.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Team Management</a>
</li>
<li class="flex items-center">
    <svg class="flex-shrink-0 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="ml-2 text-sm font-medium text-gray-500">Add Member</span>
</li>
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Add New Team Member</h1>
            <p class="mt-2 text-sm text-gray-700">Create a new account for your team member with specific roles and permissions.</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('seller.team.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="px-6 py-6">
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="f_name" class="block text-sm font-medium text-gray-700">First Name *</label>
                                <input type="text" name="f_name" id="f_name" value="{{ old('f_name') }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('f_name') border-red-300 @enderror">
                                @error('f_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="l_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
                                <input type="text" name="l_name" id="l_name" value="{{ old('l_name') }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('l_name') border-red-300 @enderror">
                                @error('l_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="country_code" id="country_code" value="{{ old('country_code', '+91') }}" placeholder="+91"
                                           class="w-20 border-gray-300 rounded-l-md focus:ring-blue-500 focus:border-blue-500">
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                           class="flex-1 border-gray-300 rounded-r-md focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-300 @enderror">
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                                <input type="password" name="password" id="password" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Minimum 8 characters</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Role and Permissions -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Role and Permissions</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role *</label>
                                <select name="role" id="role" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-300 @enderror">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $key => $label)
                                        <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
                                <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-md p-3">
                                    @foreach($permissions as $key => $label)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $key }}" id="permission_{{ $key }}"
                                                   {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="permission_{{ $key }}" class="ml-2 text-sm text-gray-700">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permissions')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Employment Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                                <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('employee_id') border-red-300 @enderror">
                                @error('employee_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="joining_date" class="block text-sm font-medium text-gray-700">Joining Date</label>
                                <input type="date" name="joining_date" id="joining_date" value="{{ old('joining_date', date('Y-m-d')) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('joining_date') border-red-300 @enderror">
                                @error('joining_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                                <input type="text" name="department" id="department" value="{{ old('department') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('department') border-red-300 @enderror">
                                @error('department')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="salary" class="block text-sm font-medium text-gray-700">Salary (₹)</label>
                                <input type="number" name="salary" id="salary" value="{{ old('salary') }}" min="0" step="0.01"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('salary') border-red-300 @enderror">
                                @error('salary')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-8">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Additional notes about this team member..."
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-300 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('seller.team.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Team Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Role-based permission suggestions
    const roleSelect = document.getElementById('role');
    const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
    
    const rolePermissions = {
        'manager': ['manage_products', 'manage_orders', 'manage_inventory', 'view_analytics', 'manage_customers'],
        'staff': ['manage_products', 'manage_orders'],
        'accountant': ['manage_payments', 'view_analytics'],
        'inventory_manager': ['manage_inventory', 'manage_products'],
        'customer_service': ['manage_customers', 'manage_orders', 'manage_reviews']
    };
    
    roleSelect.addEventListener('change', function() {
        const selectedRole = this.value;
        
        // Clear all checkboxes first
        permissionCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Check relevant permissions for the selected role
        if (rolePermissions[selectedRole]) {
            rolePermissions[selectedRole].forEach(permission => {
                const checkbox = document.querySelector(`input[value="${permission}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
    });
    
    // Password confirmation validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    function validatePasswords() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);
});
</script>
@endpush
