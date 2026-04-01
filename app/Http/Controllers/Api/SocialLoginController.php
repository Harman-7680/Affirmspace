<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    // Redirect to provider (for API, just return the URL)
    public function redirectToProvider($provider)
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    // Handle provider callback
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Social login failed!']);
        }

        $socialId = $socialUser->getId();
        $email    = $socialUser->getEmail();

        // Check if social_id exists → login
        // $user = User::where('social_id', $socialId)->first();

        // If no social_id, check by email
        // if (! $user && $email) {
        //     $user = User::where('email', $email)->first();
        // }

        $user = User::where('social_id', $socialId)->first();

        if (! $user && $email) {
            // check main email
            $user = User::where('email', $email)->first();
            // check pending email
            if (! $user) {
                $user = User::where('pending_email', $email)->first();
            }
        }

        // User exists → attach social_id if missing
        if ($user) {
            if ($user->role == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Social login not allowed for this role.',
                ], 403);
            }

            if ($user && $user->pending_email === $email) {
                $user->email             = $user->pending_email;
                $user->pending_email     = null;
                $user->email_verified_at = now();
                $user->save();
            }

            if ($user->status == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is deactivated.',
                ], 403);
            }

            if (empty($user->social_id)) {
                $user->update(['social_id' => $socialId]);
            }

            $user->tokens()->delete();
            \DB::table('sessions')->where('user_id', $user->id)->delete();

            if (! $user->email_verified_at) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }

            // PAYMENT CHECK FOR APP
            $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

            if ($registrationFee > 0 && $user->is_paid == 0) {
                return response()->json([
                    'success' => false,
                    'code'    => 'PAYMENT_REQUIRED',
                    'message' => 'Registration payment pending. Please complete payment from website.',
                ], 402);
            }

            Auth::login($user);
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'success'      => true,
                'user'         => $user,
                'token'        => $token,
                'redirect_url' => $user->role == 1 ? '/counselor/profile' : '/feed',
            ]);
        }

        // New user → return social info to complete profile
        session([
            'social_user' => [
                'provider'  => $provider,
                'email'     => $email,
                'name'      => $socialUser->getName(),
                'avatar'    => $socialUser->getAvatar(),
                'social_id' => $socialId,
            ],
        ]);

        return response()->json([
            'success'     => true,
            'social_user' => session('social_user'),
            'message'     => 'Complete profile required',
        ]);
    }

    // Show complete profile (API returns session data)
    public function showCompleteProfileForm()
    {
        $socialUser = session('social_user');
        if (! $socialUser) {
            return response()->json(['success' => false, 'message' => 'No social login data']);
        }

        return response()->json(['success' => true, 'social_user' => $socialUser]);
    }

    // Complete profile submission
    public function completeProfile(Request $request)
    {
        $socialUser = session('social_user');
        if (! $socialUser) {
            return response()->json(['success' => false, 'message' => 'No social login data']);
        }

        $socialId = $socialUser['social_id'];
        $email    = $request->email ?? $socialUser['email'] ?? null;

        // Check if social_id exists → login
        $user = User::where('social_id', $socialId)->first();
        if ($user) {
            if ($user->role == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Social login not allowed for this role.',
                ], 403);
            }

            $user->tokens()->delete();
            \DB::table('sessions')->where('user_id', $user->id)->delete();

            $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

            if ($registrationFee > 0 && $user->is_paid == 0) {
                return response()->json([
                    'success' => false,
                    'code'    => 'PAYMENT_REQUIRED',
                    'message' => 'Registration payment pending. Please complete payment from website.',
                ], 402);
            }

            Auth::login($user);
            $token = $user->createToken('API Token')->plainTextToken;

            session()->forget('social_user');
            return response()->json([
                'success'      => true,
                'user'         => $user,
                'token'        => $token,
                'redirect_url' => $user->role == 1 ? '/counselor/profile' : '/feed',
            ]);
        }

        // If email exists → require OTP
        // $existingUser = $email ? User::where('email', $email)->first() : null;
        $existingUser = null;
        if ($email) {
            $existingUser = User::where('email', $email)
                ->orWhere('pending_email', $email)
                ->first();
        }

        if ($existingUser) {
            $request->validate(['otp_verified' => 'required|in:1']);
            // $existingUser->update([
            //     'social_id'         => $socialId,
            //     'email_verified_at' => now(),
            // ]);

            if ($existingUser && $existingUser->pending_email === $email) {
                $existingUser->email         = $existingUser->pending_email;
                $existingUser->pending_email = null;
            }

            $existingUser->social_id         = $socialId;
            $existingUser->email_verified_at = now();
            $existingUser->save();

            $existingUser->tokens()->delete();
            \DB::table('sessions')->where('user_id', $existingUser->id)->delete();

            $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

            if ($registrationFee > 0 && $existingUser->is_paid == 0) {
                return response()->json([
                    'success' => false,
                    'code'    => 'PAYMENT_REQUIRED',
                    'message' => 'Registration payment pending. Please complete payment from website.',
                ], 402);
            }

            Auth::login($existingUser);
            $token = $existingUser->createToken('API Token')->plainTextToken;

            session()->forget('social_user');
            return response()->json([
                'success'      => true,
                'user'         => $existingUser,
                'token'        => $token,
                'redirect_url' => $existingUser->role == 1 ? '/counselor/profile' : '/feed',
            ]);
        }

        // New user → validate all fields
        $rules = [
            'first_name'   => 'required|string|max:25',
            'last_name'    => 'required|string|max:25',
            'email'        => 'required|email|max:50',
            'otp_verified' => 'required|in:1',
            'gender'       => 'required|string',
            'role'         => 'required|in:0,1',
            'address'      => 'required|string',
            'refer_code'   => ['nullable', 'exists:users,refer_code'],
            'refer_code'   => ['nullable', 'exists:users,refer_code'],
        ];
        $request->validate($rules);

        // Generate refer code
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

        $registrationFee = optional(RegistrationSetting::first())->registration_fee ?? 0;

        if ($registrationFee > 0) {
            return response()->json([
                'success'          => false,
                'code'             => 'PAYMENT_REQUIRED',
                'message'          => 'Registration fee required.',
                'user_id'          => $user->id,
                'registration_fee' => $registrationFee,
            ], 402);
        }

        Auth::login($user);
        $token = $user->createToken('API Token')->plainTextToken;

        session()->forget('social_user');

        return response()->json([
            'success'      => true,
            'user'         => $user,
            'token'        => $token,
            'redirect_url' => $user->role == 1 ? '/counselor/profile' : '/feed',
        ]);
    }

    // Check if email exists
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        // $exists = User::where('email', $request->email)->exists();
        $exists = User::where('email', $request->email)
            ->orWhere('pending_email', $request->email)
            ->exists();
        return response()->json(['success' => true, 'exists' => $exists]);
    }

    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;
        $otp   = rand(100000, 999999);

        Session::put('otp_email', $email);
        Session::put('otp_code', $otp);
        Session::put('otp_expires', now()->addMinutes(5));

        // $exists = User::where('email', $email)->exists();
        $exists = User::where('email', $email)
            ->orWhere('pending_email', $email)
            ->exists();
        Mail::to($email)->send(new OtpMail($otp));

        return response()->json(['success' => true, 'exists' => $exists]);
    }

    // Verify OTP
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

        return response()->json(['success' => false, 'message' => 'Wrong OTP']);
    }
}
