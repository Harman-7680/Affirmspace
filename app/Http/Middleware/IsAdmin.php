<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }

        if (Auth::user()->role != 2) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
