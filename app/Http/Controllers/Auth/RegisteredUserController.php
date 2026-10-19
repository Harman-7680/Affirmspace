<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUserRegisteredMail;
use App\Models\RegistrationSetting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

        // Generate default initials avatar for new users
        $firstName = trim($user->first_name ?? '');
        $lastName  = trim($user->last_name ?? '');

        $initials = mb_strtoupper(
            mb_substr($firstName, 0, 1) .
            mb_substr($lastName, 0, 1)
        );

        if ($initials === '') {
            $initials = 'U';
        }

// Generate a consistent background color
        $hash = md5((string) $user->id);

        $red   = 50 + (hexdec(substr($hash, 0, 2)) % 100);
        $green = 50 + (hexdec(substr($hash, 2, 2)) % 100);
        $blue  = 50 + (hexdec(substr($hash, 4, 2)) % 100);

        $background = sprintf('#%02X%02X%02X', $red, $green, $blue);

// Escape initials for safe SVG output
        $escapedInitials = htmlspecialchars(
            $initials,
            ENT_QUOTES | ENT_XML1,
            'UTF-8'
        );

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256">
    <circle cx="128" cy="128" r="128" fill="{$background}"/>
    <text x="128" y="128"
          font-family="Arial, sans-serif"
          font-size="88"
          font-weight="bold"
          fill="#FFFFFF"
          text-anchor="middle"
          dominant-baseline="central">{$escapedInitials}</text>
</svg>
SVG;

// Save avatar in the same directory structure as profile photos
        $avatarPath = 'profile_images/initials_' . $user->id . '.svg';

        if (Storage::disk('public')->put($avatarPath, $svg)) {
            $user->image = $avatarPath;
            $user->save();
        }

        $user->devices()->create([
            'device_token' => null,
            'device_type'  => 'Web',
            'device_name'  => 'unknown',
        ]);

        $user->is_paid = 0;
        $user->save();

        Auth::login($user);

        // Total counts after new user registration
        $totalCounselees = \App\Models\User::where('role', 0)->count();
        $totalCounselors = \App\Models\User::where('role', 1)->count();

        Mail::to(config('mail.admin_email'))->send(
            new NewUserRegisteredMail(
                $user,
                $totalCounselees,
                $totalCounselors
            )
        );

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
