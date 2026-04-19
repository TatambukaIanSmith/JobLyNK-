<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            // Log unauthorized access attempt
            \Log::warning('Unauthorized admin area access attempt', [
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'user_role' => Auth::user()->role,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'timestamp' => now()
            ]);

            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Unauthorized access. This incident has been logged.');
        }

        return $next($request);
    }
}