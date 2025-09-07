<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DebugAdminLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:admin-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug admin login and role issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Admin Login Debug ===');
        
        // Check if roles exist
        $this->info('Checking roles...');
        $roles = Role::all();
        if ($roles->isEmpty()) {
            $this->error('No roles found in database!');
            $this->info('Creating admin roles...');
            
            Role::create(['name' => 'super_admin']);
            Role::create(['name' => 'ops_admin']);
            
            $this->info('Admin roles created.');
        } else {
            $this->info('Available roles:');
            foreach ($roles as $role) {
                $this->line("  - {$role->name}");
            }
        }
        
        // Check users and their roles
        $this->info('Checking users...');
        $users = User::with('roles')->get();
        
        if ($users->isEmpty()) {
            $this->error('No users found in database!');
            return;
        }
        
        foreach ($users as $user) {
            $userRoles = $user->roles->pluck('name')->toArray();
            $hasAdminRole = $user->hasAnyRole(['super_admin', 'ops_admin']);
            
            $this->info("User: {$user->email}");
            $this->line("  ID: {$user->id}");
            $this->line("  Roles: " . (empty($userRoles) ? 'None' : implode(', ', $userRoles)));
            $this->line("  Has Admin Role: " . ($hasAdminRole ? 'Yes' : 'No'));
            
            if (!$hasAdminRole && empty($userRoles)) {
                $this->warn("  ^ This user has no roles assigned!");
                $this->ask("Assign super_admin role to {$user->email}? (y/n)", 'n') === 'y' 
                    ? $user->assignRole('super_admin') && $this->info("  Role assigned!")
                    : null;
            }
        }
        
        // Test route resolution
        $this->info('Testing route resolution...');
        try {
            $adminDashboardUrl = route('admin.dashboard');
            $this->info("Admin dashboard URL: {$adminDashboardUrl}");
        } catch (\Exception $e) {
            $this->error("Error resolving admin.dashboard route: " . $e->getMessage());
        }
        
        try {
            $adminLoginUrl = route('admin.login');
            $this->info("Admin login URL: {$adminLoginUrl}");
        } catch (\Exception $e) {
            $this->error("Error resolving admin.login route: " . $e->getMessage());
        }
        
        $this->info('=== Debug Complete ===');
    }
}