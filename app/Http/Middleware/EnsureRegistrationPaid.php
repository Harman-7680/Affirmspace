<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRegistrationPaid
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // If not authenticated
        if (! $user) {

            // API → JSON
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            // Web → login
            return redirect()->route('login');
        }

        $registrationFee = optional(\App\Models\RegistrationSetting::first())->registration_fee ?? 0;

        // If fee is 0 → Payment system disabled → allow access
        if ($registrationFee == 0) {
            return $next($request);
        }

        /**
         * IMPORTANT:
         * - Payment check AFTER auth
         * - Web users → redirect to payment
         * - App users → JSON error
         */

        if ($user->is_paid == 0) {

            // Allow payment routes (WEB only)
            if (! $request->is('api/*') && $request->routeIs('registration.*')) {
                return $next($request);
            }

            // API (Mobile App)
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'code'    => 'PAYMENT_REQUIRED',
                    'message' => 'Registration payment pending. Please complete payment from website.',
                    'user'    => $user,
                ], 402);
            }

            // Web
            return redirect()->route('registration.payment')
                ->with('error', 'Please complete registration payment.');
        }

        return $next($request);
    }
}
