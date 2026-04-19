<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle(Request $request)
    {
        $accountType = $request->get('type', 'worker');
        
        // Store account type in session
        session(['oauth_account_type' => $accountType]);
        
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            
            // Get account type from session
            $accountType = session('oauth_account_type', 'worker');
            
            // Clear the session data
            session()->forget('oauth_account_type');
            
            return $this->handleSocialUser($socialUser, 'google', $accountType);
            
        } catch (\Exception $e) {
            return redirect()->route('register')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook(Request $request)
    {
        $accountType = $request->get('type', 'worker');
        
        // Store account type in session
        session(['oauth_account_type' => $accountType]);
        
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
            
            // Get account type from session
            $accountType = session('oauth_account_type', 'worker');
            
            // Clear the session data
            session()->forget('oauth_account_type');
            
            return $this->handleSocialUser($socialUser, 'facebook', $accountType);
            
        } catch (\Exception $e) {
            return redirect()->route('register')
                ->with('error', 'Facebook authentication failed. Please try again.');
        }
    }

    /**
     * Handle social user authentication/registration
     */
    private function handleSocialUser($socialUser, $provider, $accountType)
    {
        // Check if user already exists by email
        $existingUser = User::where('email', $socialUser->getEmail())->first();
        
        if ($existingUser) {
            // User exists, log them in
            Auth::login($existingUser);
            
            return redirect()->intended($this->getRedirectPath($existingUser->role));
        }
        
        // Create new user
        $user = User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'password' => Hash::make(Str::random(24)), // Random password since they use OAuth
            'role' => $accountType,
            'email_verified_at' => now(), // Social accounts are considered verified
        ]);
        
        Auth::login($user);
        
        return redirect()->intended($this->getRedirectPath($user->role))
            ->with('success', 'Account created successfully! Welcome to JOB-lyNK.');
    }

    /**
     * Get redirect path based on user role
     */
    private function getRedirectPath($role)
    {
        return match($role) {
            'employer' => route('employerDashboard'),
            'worker' => route('worker'),
            'admin' => route('admin'),
            default => route('dashboard'),
        };
    }
}