<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Check if maintenance mode is enabled
            if (Setting::isMaintenanceMode()) {
                // FIRST: Allow all admin routes (before any other checks)
                // This includes login, authentication, and all admin panel routes
                if (str_starts_with($request->path(), 'admin')) {
                    return $next($request);
                }
                
                // SECOND: Allow authenticated admins to access any route
                if (auth()->check() && auth()->user()->role === 'admin') {
                    return $next($request);
                }
                
                // THIRD: Block all other routes for regular users
                return response()->view('maintenance', [], 503);
            }
        } catch (\Exception $e) {
            // If database is not available, skip maintenance check and continue
            // This prevents the app from crashing when MySQL is not running
        }
        
        return $next($request);
    }
}
