<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Using token-based auth, not stateful SPA auth
        // Remove EnsureFrontendRequestsAreStateful to avoid CSRF issues
        
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'check.token.expiration' => \App\Http\Middleware\CheckTokenExpiration::class,
            'sanitize.input' => \App\Http\Middleware\SanitizeInput::class,
            'log.requests' => \App\Http\Middleware\LogRequests::class,
            'monitor.performance' => \App\Http\Middleware\MonitorPerformance::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);

        // Rate limiting for API routes
        $middleware->throttleApi();
        
        // Apply input sanitization globally
        $middleware->append(\App\Http\Middleware\SanitizeInput::class);
        
        // Log all requests (optional - can be resource intensive)
        // $middleware->append(\App\Http\Middleware\LogRequests::class);
        
        // Monitor performance (optional)
        // $middleware->append(\App\Http\Middleware\MonitorPerformance::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
