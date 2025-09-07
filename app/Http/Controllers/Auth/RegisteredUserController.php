<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:customer,seller'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role to user
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $request->role]);
        $user->assignRole($role);

        event(new Registered($user));

        // Send registration email if enabled
        $emailService = new EmailService();
        if ($request->role === 'customer') {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $emailService->sendCustomerRegistrationEmail($user->email, [
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'verification_link' => $verificationUrl,
            ]);
        }

        Auth::login($user);

        // Redirect based on role
        if ($request->role === 'seller') {
            return redirect()->route('seller.dashboard')->with('success', 'Welcome to Gletr! Please complete your seller profile.');
        } else {
            return redirect()->route('customer.dashboard')->with('success', 'Welcome to Gletr! A registration email has been sent to your email address.');
        }
    }
}
