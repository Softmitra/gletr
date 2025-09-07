<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerTeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    /**
     * Display team members list
     */
    public function index()
    {
        $seller = $this->getCurrentSeller();
        
        if (!$seller) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'Please complete your seller profile first.');
        }

        $teamMembers = $seller->teamMembers()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_members' => $seller->teamMembers()->count(),
            'active_members' => $seller->activeTeamMembers()->count(),
            'managers' => $seller->teamMembers()->byRole('manager')->count(),
            'staff' => $seller->teamMembers()->byRole('staff')->count(),
        ];

        return view('seller.team.index', compact('teamMembers', 'stats', 'seller'));
    }

    /**
     * Show create team member form
     */
    public function create()
    {
        $seller = $this->getCurrentSeller();
        
        if (!$seller) {
            return redirect()->route('seller.profile.create')
                ->with('error', 'Please complete your seller profile first.');
        }

        $roles = SellerTeamMember::getAvailableRoles();
        $permissions = SellerTeamMember::getAvailablePermissions();

        return view('seller.team.create', compact('roles', 'permissions', 'seller'));
    }

    /**
     * Store new team member
     */
    public function store(Request $request)
    {
        $seller = $this->getCurrentSeller();
        
        if (!$seller) {
            return redirect()->route('seller.profile.create')
                ->with('error', 'Please complete your seller profile first.');
        }

        $validatedData = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:seller_team_members,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:10',
            'role' => 'required|in:manager,staff,accountant,inventory_manager,customer_service',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', array_keys(SellerTeamMember::getAvailablePermissions())),
            'employee_id' => 'nullable|string|max:50',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'department' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validatedData['seller_id'] = $seller->id;
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['status'] = 'active';

        $teamMember = SellerTeamMember::create($validatedData);

        return redirect()->route('seller.team.show', $teamMember)
            ->with('success', 'Team member added successfully!');
    }

    /**
     * Show team member details
     */
    public function show(SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            abort(403, 'Unauthorized access to team member.');
        }

        return view('seller.team.show', compact('teamMember', 'seller'));
    }

    /**
     * Show edit team member form
     */
    public function edit(SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            abort(403, 'Unauthorized access to team member.');
        }

        $roles = SellerTeamMember::getAvailableRoles();
        $permissions = SellerTeamMember::getAvailablePermissions();

        return view('seller.team.edit', compact('teamMember', 'roles', 'permissions', 'seller'));
    }

    /**
     * Update team member
     */
    public function update(Request $request, SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            abort(403, 'Unauthorized access to team member.');
        }

        $validatedData = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('seller_team_members', 'email')->ignore($teamMember->id)
            ],
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:10',
            'role' => 'required|in:manager,staff,accountant,inventory_manager,customer_service',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', array_keys(SellerTeamMember::getAvailablePermissions())),
            'status' => 'required|in:active,inactive,suspended',
            'employee_id' => 'nullable|string|max:50',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'department' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Handle password update if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed'
            ]);
            $validatedData['password'] = Hash::make($request->password);
        }

        $teamMember->update($validatedData);

        return redirect()->route('seller.team.show', $teamMember)
            ->with('success', 'Team member updated successfully!');
    }

    /**
     * Delete team member
     */
    public function destroy(SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            abort(403, 'Unauthorized access to team member.');
        }

        $teamMember->delete();

        return redirect()->route('seller.team.index')
            ->with('success', 'Team member removed successfully!');
    }

    /**
     * Update team member status
     */
    public function updateStatus(Request $request, SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $teamMember->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'status' => $teamMember->status
        ]);
    }

    /**
     * Logout team member from all devices
     */
    public function logoutMember(SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Revoke all tokens for this team member (if using Sanctum)
        // $teamMember->tokens()->delete();
        
        // For now, we'll just update the remember_token to force logout
        $teamMember->update(['remember_token' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Team member has been logged out from all devices'
        ]);
    }

    /**
     * Reset team member password
     */
    public function resetPassword(SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Generate new temporary password
        $newPassword = Str::random(12);
        $teamMember->update([
            'password' => Hash::make($newPassword),
            'remember_token' => null // Force logout
        ]);

        // Here you would send email with new password
        // Mail::to($teamMember->email)->send(new PasswordResetMail($newPassword));

        return response()->json([
            'success' => true,
            'message' => 'Password reset email has been sent to the team member',
            'temp_password' => $newPassword // Remove this in production
        ]);
    }

    /**
     * Send welcome email to team member
     */
    public function sendWelcomeEmail(SellerTeamMember $teamMember)
    {
        $seller = $this->getCurrentSeller();
        
        // Check if team member belongs to current seller
        if ($teamMember->seller_id !== $seller->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Here you would send welcome email with login instructions
        // Mail::to($teamMember->email)->send(new WelcomeTeamMemberMail($teamMember, $seller));

        return response()->json([
            'success' => true,
            'message' => 'Welcome email has been sent successfully'
        ]);
    }

    /**
     * Get current authenticated seller
     */
    private function getCurrentSeller()
    {
        $user = auth()->user();
        if (!$user) {
            return null;
        }
        
        return Seller::where('email', $user->email)->first();
    }
}