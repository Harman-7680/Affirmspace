<?php
namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\RegistrationSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    // Redirect to provider
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Handle provider callback
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Social login failed!');
        }

        $socialId = $socialUser->getId();
        $email    = $socialUser->getEmail();

        // Check if social_id exists → login directly
        $user = User::where('social_id', $socialId)->first();

        // If no social_id, check by email if available
        if (! $user && $email) {
            $user = User::where('email', $email)->first();
        }

        // If user found → login directly (attach social_id if missing)
        if ($user) {
            if ($user->status == 0) {
                return redirect()->route('login')->withErrors(['email' => 'Sorry, your account is deactivated.']);
            }

            if (empty($user->social_id)) {
                $user->update(['social_id' => $socialId]);
            }

            $user->tokens()->delete();
            \DB::table('sessions')->where('user_id', $user->id)->delete();

            if (! $user->email_verified_at) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }

            Auth::login($user);

            $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

            if ($registrationFee > 0 && $user->is_paid == 0) {
                return redirect()->route('registration.payment');
            }

            return $this->redirectByRole($user);
        }

        // New user → store social info in session & show complete profile
        session([
            'social_user' => [
                'provider'  => $provider,
                'email'     => $email,
                'name'      => $socialUser->getName(),
                'avatar'    => $socialUser->getAvatar(),
                'social_id' => $socialId,
            ],
        ]);

        return redirect()->route('social.complete');
    }

    // Show Complete Profile Form
    public function showCompleteProfileForm()
    {
        $socialUser = session('social_user');
        if (! $socialUser) {
            return redirect()->route('login')->with('error', 'No social login data found.');
        }

        return view('auth.complete-profile', compact('socialUser'));
    }

    // Handle Complete Profile Submission
    // public function completeProfile(Request $request)
    // {
    //     $socialUser = session('social_user');
    //     if (! $socialUser) {
    //         return redirect()->route('login')->with('error', 'No social login data found.');
    //     }

    //     $request->validate([
    //         'first_name' => 'required|string|max:25',
    //         'last_name'  => 'required|string|max:25',
    //         'gender'     => 'required|string',
    //         'role'       => 'required|in:0,1',
    //         'address'    => 'required|string',
    //         'refer_code' => ['nullable', 'exists:users,refer_code'],
    //         'email'      => 'required|email|max:50',
    //     ]);

    //     $email    = $request->email;
    //     $socialId = $socialUser['social_id'] ?? null;

    //     // Check if a user already exists with this email
    //     $existingUser = User::where('email', $email)->first();

    //     if ($existingUser) {
    //         // Attach social_id if not already set
    //         if (empty($existingUser->social_id)) {
    //             $existingUser->update(['social_id' => $socialId]);
    //         }

    //         Auth::login($existingUser);
    //         session()->forget('social_user');
    //         return $this->redirectByRole($existingUser);
    //     }

    //     // Generate unique refer code
    //     do {
    //         $referCode = strtolower($request->first_name) . '_' . rand(1000, 9999);
    //     } while (User::where('refer_code', $referCode)->exists());

    //     $referrer = null;
    //     if ($request->filled('refer_code')) {
    //         $referrer = User::where('refer_code', $request->refer_code)->first();
    //     }

    //     // Create a new user since email doesn’t exist
    //     $user = User::create([
    //         'first_name'  => $request->first_name,
    //         'last_name'   => $request->last_name,
    //         'email'       => $email,
    //         'gender'      => $request->gender,
    //         'role'        => $request->role,
    //         'status'      => 1,
    //         'UserStatus'  => 1,
    //         'password'    => Hash::make(Str::random(12)),
    //         'refer_code'  => $referCode,
    //         'address'     => $request->address,
    //         'referred_by' => $referrer ? $referrer->id : null,
    //         'social_id'   => $socialId,
    //     ]);

    //     // Optional: store device info if relation exists
    //     if (method_exists($user, 'devices')) {
    //         $user->devices()->create([
    //             'device_token' => null,
    //             'device_type'  => $socialUser['provider'] ?? 'social',
    //             'device_name'  => $socialUser['provider'] ?? 'social',
    //         ]);
    //     }

    //     // Clear session and log in
    //     session()->forget('social_user');
    //     Auth::login($user);

    //     return $this->redirectByRole($user);
    // }

    public function completeProfile(Request $request)
    {
        $socialUser = session('social_user');
        if (! $socialUser) {
            return redirect()->route('login');
        }

        $socialId = $socialUser['social_id'];
        $email    = $request->email ?? $socialUser['email'] ?? null;

        // Check if social_id exists → login directly
        $user = User::where('social_id', $socialId)->first();
        if ($user) {
            $user->tokens()->delete();
            \DB::table('sessions')->where('user_id', $user->id)->delete();

            Auth::login($user);

            session()->forget('social_user');

            $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

            if ($registrationFee > 0 && $user->is_paid == 0) {
                return redirect()->route('registration.payment');
            }

            return redirect($user->role == 1 ? '/counselor/profile' : '/feed');
        }

        // If email exists → require OTP
        $existingUser = $email ? User::where('email', $email)->first() : null;

        if ($existingUser) {
            // validate OTP
            $request->validate(['otp_verified' => 'required|in:1']);
            $existingUser->update([
                'social_id'         => $socialId,
                'email_verified_at' => now(),
            ]);

            $existingUser->tokens()->delete();
            \DB::table('sessions')->where('user_id', $existingUser->id)->delete();

            Auth::login($existingUser);

            session()->forget('social_user');

            $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

            if ($registrationFee > 0 && $existingUser->is_paid == 0) {
                return redirect()->route('registration.payment');
            }

            return redirect($existingUser->role == 1 ? '/counselor/profile' : '/feed');
        }

        // New user → validate all fields & create
        $rules = [
            'first_name'   => 'required|string|max:25',
            'last_name'    => 'required|string|max:25',
            'email'        => 'required|email|max:50',
            'otp_verified' => 'required|in:1',
            'gender'       => 'required|string',
            'role'         => 'required|in:0,1',
            'address'      => 'required|string',
            'refer_code'   => ['nullable', 'exists:users,refer_code'],
        ];

        if ($request->role == 1) {
            $rules['specialization_id'] = 'required|exists:specializations,id';
        }

        $request->validate($rules);

        do {
            $referCode = strtolower($request->first_name) . '_' . rand(1000, 9999);
        } while (User::where('refer_code', $referCode)->exists());

        $referrer = $request->filled('refer_code') ? User::where('refer_code', $request->refer_code)->first() : null;

        $user = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'email_verified_at' => now(),
            'gender'            => $request->gender,
            'role'              => $request->role,
            'status'            => 1,
            'UserStatus'        => 1,
            'password'          => \Hash::make(Str::random(12)),
            'refer_code'        => $referCode,
            'address'           => $request->address,
            'referred_by'       => $referrer ? $referrer->id : null,
            'social_id'         => $socialId,
            'specialization_id' => $request->role == 1 ? $request->specialization_id : null,
        ]);

        if (method_exists($user, 'devices')) {
            $user->devices()->create([
                'device_token' => null,
                'device_type'  => $socialUser['provider'] ?? 'social',
                'device_name'  => $socialUser['provider'] ?? 'social',
            ]);
        }

        $user->tokens()->delete();
        \DB::table('sessions')->where('user_id', $user->id)->delete();

        Auth::login($user);
        session()->forget('social_user');

        $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

        if ($registrationFee > 0 && $user->is_paid == 0) {
            return redirect()->route('registration.payment');
        }

        return redirect($user->role == 1 ? '/counselor/profile' : '/feed');
    }

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;
        $otp   = rand(100000, 999999);

        Session::put('otp_email', $email);
        Session::put('otp_code', $otp);
        Session::put('otp_expires', now()->addMinutes(5));

        $exists = \App\Models\User::where('email', $email)->exists();

        // Mail::to($email)->queue(new OtpMail($otp)); queue mail
        Mail::to($email)->send(new OtpMail($otp));

        return response()->json(['success' => true, 'exists' => $exists]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        if (Session::get('otp_email') === $request->email &&
            Session::get('otp_code') == $request->otp &&
            now()->lt(Session::get('otp_expires'))) {

            Session::forget(['otp_email', 'otp_code', 'otp_expires']);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    private function redirectByRole($user)
    {
        if ($user->role == 1) {
            return redirect('/counselor/profile')->with('message', 'Logged in successfully!');
        }
        return redirect('/feed')->with('message', 'Logged in successfully!');
    }
}
