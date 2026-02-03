<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user ||
            ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())) {

            // API / App request
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please verify your email to continue.',
                ], 403);
            }

            // Web request
            return redirect()
                ->route('verification.notice')
                ->with('error', 'Please verify your email to continue.');
        }

        return $next($request);
    }
}
