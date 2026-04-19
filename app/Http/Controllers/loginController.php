<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    /**
     * Display the login form
     */
    public function login()
    {
        return view('files.login');
    }

    /**
     * Handle login request
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if user is suspended
        if ($user->is_suspended) {
            throw ValidationException::withMessages([
                'email' => ['This account has been suspended.'],
            ]);
        }

        // If 2FA is enabled, redirect to 2FA challenge
        if ($user->two_factor_secret) {
            // Store user ID in session for 2FA verification
            session(['2fa_user_id' => $user->id]);
            return redirect()->route('two-factor.login');
        }

        // Login user without 2FA
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Redirect based on user role
        return redirect()->intended($this->redirectPath($user));
    }

    /**
     * Show 2FA challenge page
     */
    public function showTwoFactorChallenge()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('files.two-factor-challenge');
    }

    /**
     * Verify 2FA code
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        // Verify TOTP code
        $verified = $this->verifyTOTPCode($user, $request->code);

        if (!$verified) {
            throw ValidationException::withMessages([
                'code' => ['The provided code is invalid.'],
            ]);
        }

        // Clear 2FA session and login user
        session()->forget('2fa_user_id');
        Auth::login($user, false);
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath($user));
    }

    /**
     * Verify TOTP code
     */
    private function verifyTOTPCode(User $user, string $code): bool
    {
        if (!$user->two_factor_secret) {
            return false;
        }

        // Use Laravel Fortify's TOTP verification
        $secret = $user->two_factor_secret;
        
        // Simple TOTP verification (you may want to use a library like OTPHP)
        // For now, we'll use a basic implementation
        $time = floor(time() / 30);
        
        for ($i = -1; $i <= 1; $i++) {
            $hash = hash_hmac('sha1', pack('N*', 0) . pack('N*', $time + $i), base64_decode($secret), true);
            $offset = ord($hash[19]) & 0xf;
            $otp = (((ord($hash[$offset]) & 0x7f) << 24) |
                    ((ord($hash[$offset + 1]) & 0xff) << 16) |
                    ((ord($hash[$offset + 2]) & 0xff) << 8) |
                    (ord($hash[$offset + 3]) & 0xff)) % 1000000;
            
            if (str_pad($otp, 6, '0', STR_PAD_LEFT) === $code) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get redirect path based on user role
     */
    private function redirectPath(User $user): string
    {
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        } elseif ($user->role === 'employer') {
            return route('employerDashboard');
        } else {
            return route('worker');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
