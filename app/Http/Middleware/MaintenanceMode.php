<?php
namespace App\Http\Middleware;

use Closure;

class MaintenanceMode
{
    public function handle($request, Closure $next)
    {
        if (config('app.maintenance_mode') === true) {

            // API request
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Server is under maintenance. Please try later.',
                ], 503);
            }

            // Web request
            abort(503);
        }

        return $next($request);
    }
}
