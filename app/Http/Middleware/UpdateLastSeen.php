<?php
namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Store "online" status for 2 mins
            Cache::put('user-is-online-' . $user->id, true, now()->addMinutes(2));

            // Update last seen
            $user->last_seen = Carbon::now();
            $user->save();
        }

        return $next($request);
    }
}
