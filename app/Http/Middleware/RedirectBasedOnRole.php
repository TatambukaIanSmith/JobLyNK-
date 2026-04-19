<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     * Redirect authenticated users to their role-specific dashboard.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Log the current user and request for debugging
            \Illuminate\Support\Facades\Log::info('RedirectBasedOnRole middleware triggered', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'current_route' => $request->route()->getName(),
                'current_url' => $request->url(),
                'isWorker' => $user->isWorker(),
                'isEmployer' => $user->isEmployer(),
                'isAdmin' => $user->isAdmin()
            ]);
            
            // If user is on generic dashboard, redirect to role-specific dashboard
            if ($request->routeIs('dashboard')) {
                if ($user->isAdmin()) {
                    \Illuminate\Support\Facades\Log::info('Redirecting admin to admin.dashboard');
                    return redirect()->route('admin.dashboard');
                } elseif ($user->isEmployer()) {
                    \Illuminate\Support\Facades\Log::info('Redirecting employer to employerDashboard');
                    return redirect()->route('employerDashboard');
                } elseif ($user->isWorker()) {
                    \Illuminate\Support\Facades\Log::info('Redirecting worker to worker');
                    return redirect()->route('worker');
                }
            }
            
            // Additional check: if employer is on worker route, redirect them
            if ($user->isEmployer() && $request->routeIs('worker')) {
                \Illuminate\Support\Facades\Log::info('Employer on worker route, redirecting to employerDashboard');
                return redirect()->route('employerDashboard');
            }
            
            // Additional check: if worker is on employer route, redirect them
            if ($user->isWorker() && $request->routeIs('employerDashboard')) {
                \Illuminate\Support\Facades\Log::info('Worker on employer route, redirecting to worker');
                return redirect()->route('worker');
            }
        }

        return $next($request);
    }
}


