<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Utils\FileStorage;

class UserProfileController extends Controller
{
    /**
     * Display a listing of user profiles.
     */
    public function index(Request $request)
    {
        $query = User::with(['profile', 'addresses', 'roles']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function ($profileQuery) use ($search) {
                      $profileQuery->where('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Profile status filter
        if ($request->filled('profile_status')) {
            if ($request->profile_status === 'complete') {
                $query->whereHas('profile', function ($profileQuery) {
                    $profileQuery->whereNotNull('phone')
                                ->whereNotNull('date_of_birth')
                                ->whereNotNull('gender');
                });
            } else {
                $query->whereDoesntHave('profile', function ($profileQuery) {
                    $profileQuery->whereNotNull('phone')
                                ->whereNotNull('date_of_birth')
                                ->whereNotNull('gender');
                });
            }
        }

        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($roleQuery) use ($request) {
                $roleQuery->where('name', $request->role);
            });
        }

        $users = $query->paginate(15);

        // Statistics
        $stats = [
            'total_users' => User::count(),
            'profiles_completed' => User::whereHas('profile', function ($query) {
                $query->whereNotNull('phone')
                      ->whereNotNull('date_of_birth')
                      ->whereNotNull('gender');
            })->count(),
            'profiles_incomplete' => User::whereDoesntHave('profile', function ($query) {
                $query->whereNotNull('phone')
                      ->whereNotNull('date_of_birth')
                      ->whereNotNull('gender');
            })->count(),
            'active_users' => User::where('status', 'active')->count(),
        ];

        return view('admin.user-profiles.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user profile.
     */
    public function create()
    {
        return view('admin.user-profiles.create');
    }

    /**
     * Store a newly created user profile.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'website' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links.facebook' => 'nullable|url|max:255',
            'social_links.twitter' => 'nullable|url|max:255',
            'social_links.instagram' => 'nullable|url|max:255',
            'social_links.linkedin' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,suspended,banned',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        // Assign default role
        $user->assignRole('customer');

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $fileStorage = new FileStorage();
            $result = $fileStorage->store($request->file('profile_picture'), 'profile-pictures', 'image');
            
            if ($result['success']) {
                $profilePicturePath = $result['path'];
            }
        }

        // Create user profile
        $user->profile()->create([
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'profile_picture' => $profilePicturePath,
            'bio' => $request->bio,
            'website' => $request->website,
            'social_links' => $request->social_links,
            'preferences' => [
                'notifications' => $request->has('preferences.notifications'),
                'marketing' => $request->has('preferences.marketing'),
                'newsletter' => $request->has('preferences.newsletter'),
            ],
        ]);

        return redirect()->route('admin.user-profiles.show', $user)
            ->with('success', 'User profile created successfully.');
    }

    /**
     * Display the specified user profile.
     */
    public function show(User $user)
    {
        $user->load(['profile', 'addresses', 'roles']);
        return view('admin.user-profiles.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user profile.
     */
    public function edit(User $user)
    {
        $user->load(['profile', 'addresses', 'roles']);
        return view('admin.user-profiles.edit', compact('user'));
    }

    /**
     * Update the specified user profile.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'website' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links.facebook' => 'nullable|url|max:255',
            'social_links.twitter' => 'nullable|url|max:255',
            'social_links.instagram' => 'nullable|url|max:255',
            'social_links.linkedin' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,suspended,banned',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user basic info
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        // Handle profile picture upload
        $profilePicturePath = $user->profile->profile_picture ?? null;
        if ($request->hasFile('profile_picture')) {
            $fileStorage = new FileStorage();
            
            // Delete old image if exists
            if ($profilePicturePath) {
                $fileStorage->delete($profilePicturePath);
            }
            
            $result = $fileStorage->store($request->file('profile_picture'), 'profile-pictures', 'image');
            
            if ($result['success']) {
                $profilePicturePath = $result['path'];
            }
        }

        // Update or create user profile
        if ($user->profile) {
            $user->profile->update([
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'profile_picture' => $profilePicturePath,
                'bio' => $request->bio,
                'website' => $request->website,
                'social_links' => $request->social_links,
                'preferences' => [
                    'notifications' => $request->has('preferences.notifications'),
                    'marketing' => $request->has('preferences.marketing'),
                    'newsletter' => $request->has('preferences.newsletter'),
                ],
            ]);
        } else {
            $user->profile()->create([
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'profile_picture' => $profilePicturePath,
                'bio' => $request->bio,
                'website' => $request->website,
                'social_links' => $request->social_links,
                'preferences' => [
                    'notifications' => $request->has('preferences.notifications'),
                    'marketing' => $request->has('preferences.marketing'),
                    'newsletter' => $request->has('preferences.newsletter'),
                ],
            ]);
        }

        return redirect()->route('admin.user-profiles.show', $user)
            ->with('success', 'User profile updated successfully.');
    }

    /**
     * Remove the specified user profile.
     */
    public function destroy(User $user)
    {
        // Delete profile picture if exists
        if ($user->profile && $user->profile->profile_picture) {
            $fileStorage = new FileStorage();
            $fileStorage->delete($user->profile->profile_picture);
        }

        // Delete user (this will cascade delete profile and addresses)
        $user->delete();

        return redirect()->route('admin.user-profiles.index')
            ->with('success', 'User profile deleted successfully.');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', "User status changed to {$newStatus}.");
    }

    /**
     * Bulk actions for user profiles.
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:activate,deactivate,delete',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userIds = $request->user_ids;
        $action = $request->action;

        switch ($action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['status' => 'active']);
                $message = 'Selected users activated successfully.';
                break;

            case 'deactivate':
                User::whereIn('id', $userIds)->update(['status' => 'inactive']);
                $message = 'Selected users deactivated successfully.';
                break;

            case 'delete':
                // Delete profile pictures first
                $users = User::whereIn('id', $userIds)->with('profile')->get();
                $fileStorage = new FileStorage();
                foreach ($users as $user) {
                    if ($user->profile && $user->profile->profile_picture) {
                        $fileStorage->delete($user->profile->profile_picture);
                    }
                }
                
                User::whereIn('id', $userIds)->delete();
                $message = 'Selected users deleted successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
