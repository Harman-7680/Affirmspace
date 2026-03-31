<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    public function handle($request, Closure $next)
    {
        if (config('app.maintenance_mode') === true) {

            // Allow admin login page
            if ($request->is('admin/login') || $request->is('admin/login/*')) {
                return $next($request);
            }

            // Allow logged-in admin (role = 2)
            if (Auth::check() && Auth::user()->role == 2) {
                return $next($request);
            }

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
