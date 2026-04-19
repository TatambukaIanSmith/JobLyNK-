<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->append(\App\Http\Middleware\MaintenanceMode::class);
        
        // Middleware aliases
        $middleware->alias([
            'role.employer' => \App\Http\Middleware\EnsureUserIsEmployer::class,
            'role.worker' => \App\Http\Middleware\EnsureUserIsWorker::class,
            'role.admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'role.redirect' => \App\Http\Middleware\RedirectBasedOnRole::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'no-cache' => \App\Http\Middleware\NoCacheMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
