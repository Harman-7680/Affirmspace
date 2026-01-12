<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->status == 0) {
                if ($request->expectsJson()) {

                    return response()->json([
                        'success' => false,
                        'message' => 'Your account has been deactivated by admin.',
                        'code'    => 403,
                        'status'  => 'deactivated',
                    ], 403);
                }
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Your account has been deactivated by admin.']);
            }
        }

        return $next($request);
    }
}
