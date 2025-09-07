<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Show the 2FA setup page
     */
    public function show()
    {
        $user = Auth::user();
        
        if ($user->two_factor_enabled) {
            return redirect()->route('profile.edit')->with('info', 'Two-factor authentication is already enabled.');
        }

        // Generate secret key
        $secret = $this->google2fa->generateSecretKey();
        
        // Store secret in session temporarily
        session(['2fa_secret' => $secret]);
        
        // Generate QR code
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('auth.two-factor.setup', [
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $secret
        ]);
    }

    /**
     * Enable 2FA for the user
     */
    public function enable(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $secret = session('2fa_secret');

        if (!$secret) {
            return back()->withErrors(['code' => 'Invalid session. Please try again.']);
        }

        // Verify the code
        $valid = $this->google2fa->verifyKey($secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid verification code. Please try again.']);
        }

        // Generate recovery codes
        $recoveryCodes = $this->generateRecoveryCodes();

        // Save 2FA settings
        $user->update([
            'two_factor_secret' => Crypt::encrypt($secret),
            'two_factor_recovery_codes' => Crypt::encrypt($recoveryCodes->toJson()),
            'two_factor_confirmed_at' => now(),
            'two_factor_enabled' => true,
        ]);

        // Clear session
        session()->forget('2fa_secret');

        return redirect()->route('two-factor.recovery-codes')->with('success', 'Two-factor authentication has been enabled successfully!');
    }

    /**
     * Show recovery codes
     */
    public function recoveryCodes()
    {
        $user = Auth::user();
        
        if (!$user->two_factor_enabled) {
            return redirect()->route('profile.edit');
        }

        $recoveryCodes = collect(json_decode(Crypt::decrypt($user->two_factor_recovery_codes)));

        return view('auth.two-factor.recovery-codes', [
            'recoveryCodes' => $recoveryCodes
        ]);
    }

    /**
     * Regenerate recovery codes
     */
    public function regenerateRecoveryCodes()
    {
        $user = Auth::user();
        
        if (!$user->two_factor_enabled) {
            return redirect()->route('profile.edit');
        }

        $recoveryCodes = $this->generateRecoveryCodes();
        
        $user->update([
            'two_factor_recovery_codes' => Crypt::encrypt($recoveryCodes->toJson())
        ]);

        return redirect()->route('two-factor.recovery-codes')->with('success', 'Recovery codes have been regenerated.');
    }

    /**
     * Disable 2FA
     */
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();
        
        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
            'two_factor_enabled' => false,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Show 2FA challenge page
     */
    public function challenge()
    {
        if (!session('2fa_required')) {
            return redirect()->route('dashboard');
        }

        return view('auth.two-factor.challenge');
    }

    /**
     * Verify 2FA challenge
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = Auth::user();
        $code = $request->code;

        // Check if it's a recovery code
        if (strlen($code) === 10) {
            return $this->verifyRecoveryCode($user, $code);
        }

        // Verify TOTP code
        if (strlen($code) === 6) {
            return $this->verifyTotpCode($user, $code);
        }

        return back()->withErrors(['code' => 'Invalid code format.']);
    }

    /**
     * Verify TOTP code
     */
    private function verifyTotpCode($user, $code)
    {
        $secret = Crypt::decrypt($user->two_factor_secret);
        $valid = $this->google2fa->verifyKey($secret, $code);

        if ($valid) {
            session()->forget('2fa_required');
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['code' => 'Invalid verification code.']);
    }

    /**
     * Verify recovery code
     */
    private function verifyRecoveryCode($user, $code)
    {
        $recoveryCodes = collect(json_decode(Crypt::decrypt($user->two_factor_recovery_codes)));
        
        if (!$recoveryCodes->contains($code)) {
            return back()->withErrors(['code' => 'Invalid recovery code.']);
        }

        // Remove used recovery code
        $recoveryCodes = $recoveryCodes->reject(function ($recoveryCode) use ($code) {
            return $recoveryCode === $code;
        });

        $user->update([
            'two_factor_recovery_codes' => Crypt::encrypt($recoveryCodes->toJson())
        ]);

        session()->forget('2fa_required');
        
        return redirect()->intended(route('dashboard'))->with('warning', 'You used a recovery code. Consider regenerating your recovery codes.');
    }

    /**
     * Generate recovery codes
     */
    private function generateRecoveryCodes(): Collection
    {
        return collect(range(1, 8))->map(function () {
            return Str::random(10);
        });
    }
}