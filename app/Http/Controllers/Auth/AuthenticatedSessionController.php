<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */

    // public function create(): View
    // {
    //     return view('auth.login');
    // }

    public function create(): View | RedirectResponse
    {
        if (auth()->check()) {

            $user = auth()->user();

            if ($user->is_paid == 0) {
                return redirect()->route('registration.payment');
            }

            if (! $user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            if (empty($user->image) || empty($user->bio) || empty($user->pronouns) || empty($user->relationship)) {
                return redirect()->route('profile.edit');
            }

            return redirect()->route('feed');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        // Get user by email before attempting login
        $user = \App\Models\User::where('email', $request->email)->first();

        // Check if user exists and account is deactivated
        if (! $user || $user->status == 0) {
            $message = ! $user
                ? 'We could not find an account with this email address.'
                : 'Your account has been deactivated by admin.';
            return back()->withErrors(['email' => $message]);
        }

        if ($user->role == 2) {
            return back()->withErrors([
                'email' => 'Admin must login from admin panel.',
            ]);
        }

        // $request->authenticate(); // log in
        // Auth::logoutOtherDevices($request->password);
        // $request->session()->regenerate(); // regenerate session

        // 1. Authenticate user (you already do this)
        $request->authenticate();
        $user = Auth::user();

        // 2. Manually delete other sessions for this user
        \DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', session()->getId()) // keep current session
            ->delete();

        \DB::table('personal_access_tokens')
            ->where('tokenable_id', $user->id)
            ->delete();

        // 3. Now regenerate the session id
        $request->session()->regenerate();

        $user = Auth::user();

        session(['email' => $user->email]);

        // if (! $user->hasVerifiedEmail()) {
        //     // Auth::logout();
        //     return redirect()->route('verification.notice')
        //     // ->with('message', 'You need to verify your email before logging in.');
        //         ->with('email', $user->email);
        // }

        // Redirect based on role
        if ($user->role == 0) {
            return redirect()->intended(route('feed', absolute: false));
        } elseif ($user->role == 1) {
            return redirect()->intended(route('profile', absolute: false));
        } elseif ($user->role == 2) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } else {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Destroy an authenticated session.
     */

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
