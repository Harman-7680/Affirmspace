<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RegistrationSetting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        // Validation
        $request->validate([
            'first_name'     => ['required', 'string', 'max:25'],
            'last_name'      => ['required', 'string', 'max:25'],
            'email'          => ['required', 'string', 'email', 'max:25', 'unique:users,email'],
            'terms'          => ['required'],
            'is_adult'       => ['required'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'refer_code'     => ['nullable', 'exists:users,refer_code'], // optional
            'address'        => ['nullable'],
            'specialization' => ['nullable', 'exists:specializations,id'],
        ]);

        // Generate unique refer code for new user
        do {
            $userReferCode = strtolower($request->first_name) . '_' . rand(1000, 9999);
        } while (\App\Models\User::where('refer_code', $userReferCode)->exists());

        $referrer = null;
        if ($request->filled('refer_code')) {
            $referrer = \App\Models\User::where('refer_code', $request->refer_code)->first();
        }

        // Create user
        $user = \App\Models\User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'gender'            => $request->gender,
            'email'             => $request->email,
            'password'          => \Hash::make($request->password),
            'role'              => $request->role,
            'status'            => 1,
            'refer_code'        => $userReferCode,
            'referred_by'       => $referrer ? $referrer->id : null,
            'address'           => $request->address,
            'specialization_id' => $request->role == 1 ? $request->specialization : null,
        ]);

        $user->devices()->create([
            'device_token' => null,
            'device_type'  => 'Web',
            'device_name'  => 'unknown',
        ]);

        $user->is_paid = 0;
        $user->save();

        Auth::login($user);

        // SEND VERIFICATION EMAIL IMMEDIATELY
        event(new Registered($user));

        $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

        if ($registrationFee > 0) {
            return redirect()->route('registration.payment');
        }

        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please verify your email.');

        // event(new Registered($user));
        // Auth::login($user);

        // session(['email' => $user->email]);

        // return redirect()->route('verification.notice')
        //     ->with('message', 'Registration successful! Please verify your email.');

        // if ($request->role === '0') {
        //     return redirect(route('feed', absolute: false));
        // } else {
        //     return redirect(route('profile', absolute: false));
        // }
    }
}
