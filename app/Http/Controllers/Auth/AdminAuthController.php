<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Show admin login page
     */
    public function create(): View | RedirectResponse
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin-login');
    }

    /**
     * Handle admin login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user || $user->status == 0) {
            return back()->withErrors([
                'email' => 'Invalid credentials or account deactivated.',
            ]);
        }

        // Only admin allowed
        if ($user->role != 2) {
            return back()->withErrors([
                'email' => 'Unauthorized. Admin access only.',
            ]);
        }

        $request->authenticate();
        $user = Auth::user();

        // Remove other sessions
        \DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', session()->getId())
            ->delete();

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
