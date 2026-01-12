<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // VERY IMPORTANT:
        // Do NOT check profile if email is not verified
        if (! $user->hasVerifiedEmail()) {
            return $next($request);
        }

        $requiredFields = [
            'image',
            'bio',
            'pronouns',
            'relationship',
        ];

        foreach ($requiredFields as $field) {
            if (empty($user->$field)) {

                // Allow profile edit/update routes
                if ($request->routeIs('profile.*')) {
                    return $next($request);
                }

                // AJAX / API
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'profile_incomplete' => true,
                        'message'            => 'Please complete your profile first',
                    ], 403);
                }

                // DO NOT use redirect()->back() (causes loop)
                return redirect()->route('profile.edit')
                    ->with('error', 'Please complete your profile first.');
            }
        }

        return $next($request);
    }
}
