<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified'         => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'isAdmin'          => \App\Http\Middleware\IsAdmin::class,
            'profile.complete' => \App\Http\Middleware\EnsureProfileComplete::class,
        ]);

        $middleware->web([
            \App\Http\Middleware\UpdateLastSeen::class,
            \App\Http\Middleware\CheckAccountStatus::class, // This check status on every request for web
        ]);

        $middleware->api([
            \App\Http\Middleware\UpdateLastSeen::class,
            \App\Http\Middleware\CheckAccountStatus::class, // This check status on every request for mobile
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Illuminate\Auth\AuthenticationException $e, $request) {

            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'status'  => 'Unauthenticated',
                    'message' => 'Your session has expired. Please log in again.',
                ], 401);
            }

            return redirect()->guest(route('login'))
                ->with('error', 'Unauthorized access or session expired.');
        });

    })->create();
