<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        // If already logged in as admin, redirect to admin dashboard
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login attempt
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Rate limiting
        $key = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        // Check if user exists and is admin
        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->isAdmin()) {
            RateLimiter::hit($key);
            
            // Log unauthorized access attempt
            \Log::warning('Unauthorized admin login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()
            ]);

            throw ValidationException::withMessages([
                'email' => ['Invalid admin credentials.'],
            ]);
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key);
            
            // Log failed login attempt
            \Log::warning('Failed admin login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()
            ]);

            throw ValidationException::withMessages([
                'email' => ['Invalid admin credentials.'],
            ]);
        }

        // Clear rate limiter on successful login
        RateLimiter::clear($key);

        // Log successful admin login
        \Log::info('Admin login successful', [
            'admin_id' => $user->id,
            'admin_email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        // Login the user
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        // Log admin logout
        if (Auth::check()) {
            \Log::info('Admin logout', [
                'admin_id' => Auth::id(),
                'admin_email' => Auth::user()->email,
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}