<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewUserRegisteredMail;
use App\Mail\OtpMail;
use App\Models\RegistrationSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GOOGLE LOGIN - NATIVE APP
    |--------------------------------------------------------------------------
    */

    public function googleLogin(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            $socialUser = Socialite::driver('google')
                ->stateless()
                ->userFromToken($request->id_token);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid Google token.',
            ], 401);
        }

        return $this->handleSocialUser(
            provider: 'google',
            socialUser: $socialUser
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FACEBOOK LOGIN - NATIVE APP
    |--------------------------------------------------------------------------
    */

    public function facebookLogin(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
        ]);

        try {
            $socialUser = Socialite::driver('facebook')
                ->stateless()
                ->userFromToken($request->access_token);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid Facebook access token.',
            ], 401);
        }

        return $this->handleSocialUser(
            provider: 'facebook',
            socialUser: $socialUser
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COMMON SOCIAL LOGIN HANDLER
    |--------------------------------------------------------------------------
    */

    private function handleSocialUser($provider, $socialUser)
    {
        $socialId = $socialUser->getId();
        $email    = $socialUser->getEmail();

        /*
        |--------------------------------------------------------------------------
        | Find user by social ID
        |--------------------------------------------------------------------------
        */

        $user = User::where('social_id', $socialId)->first();

        /*
        |--------------------------------------------------------------------------
        | If social ID not found, find by email
        |--------------------------------------------------------------------------
        */

        if (! $user && $email) {

            $user = User::where('email', $email)->first();

            if (! $user) {
                $user = User::where('pending_email', $email)->first();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EXISTING USER
        |--------------------------------------------------------------------------
        */

        if ($user) {

            /*
            | Admin cannot use social login
            */

            if ($user->role == 2) {

                return response()->json([
                    'success' => false,
                    'message' => 'Social login not allowed for this role.',
                ], 403);
            }

            /*
            | Pending email -> main email
            */

            if ($user->pending_email === $email) {

                $user->email             = $user->pending_email;
                $user->pending_email     = null;
                $user->email_verified_at = now();

                $user->save();
            }

            /*
            | Deactivated account
            */

            if ($user->status == 0) {

                return response()->json([
                    'success' => false,
                    'message' => 'Account is deactivated.',
                ], 403);
            }

            /*
            | Attach social ID if missing
            */

            if (empty($user->social_id)) {

                $user->update([
                    'social_id' => $socialId,
                ]);
            }

            /*
            | Social login verifies email
            */

            if (! $user->email_verified_at) {

                $user->update([
                    'email_verified_at' => now(),
                ]);
            }

            /*
            | Delete old API tokens
            */

            $user->tokens()->delete();

            /*
            | Remove web sessions if any
            */

            \DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | PAYMENT CHECK
            |--------------------------------------------------------------------------
            */

            $registrationFee = optional(
                RegistrationSetting::first()
            )->registration_fee ?? 0;

            if ($registrationFee > 0 && $user->is_paid == 0) {

                return response()->json([
                    'success' => false,
                    'code'    => 'PAYMENT_REQUIRED',
                    'message' => 'Registration payment pending. Please complete payment.',
                ], 402);
            }

            /*
            |--------------------------------------------------------------------------
            | LOGIN
            |--------------------------------------------------------------------------
            */

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'success'      => true,
                'user'         => $user,
                'token'        => $token,
                'redirect_url' => $user->role == 1
                    ? '/counselor/profile'
                    : '/feed',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NEW SOCIAL USER
        |--------------------------------------------------------------------------
        */

        $temporaryToken = Str::random(64);

        \DB::table('social_login_tokens')->insert([
            'token'      => $temporaryToken,
            'provider'   => $provider,
            'social_id'  => $socialId,
            'email'      => $email,
            'name'       => $socialUser->getName(),
            'avatar'     => $socialUser->getAvatar(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success'      => true,
            'code'         => 'PROFILE_REQUIRED',

            'social_token' => $temporaryToken,

            'social_user'  => [
                'provider'  => $provider,
                'email'     => $email,
                'name'      => $socialUser->getName(),
                'avatar'    => $socialUser->getAvatar(),
                'social_id' => $socialId,
            ],

            'message'      => 'Complete profile required.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETE PROFILE
    |--------------------------------------------------------------------------
    */

    public function completeProfile(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate temporary social token
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'social_token' => 'required|string',
        ]);

        $socialData = \DB::table('social_login_tokens')
            ->where('token', $request->social_token)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->first();

        if (! $socialData) {

            return response()->json([
                'success' => false,
                'message' => 'Social login session expired.',
            ], 401);
        }

        $socialId = $socialData->social_id;

        $email = $request->email ?? $socialData->email;

        /*
        |--------------------------------------------------------------------------
        | Check social ID again
        |--------------------------------------------------------------------------
        */

        $user = User::where('social_id', $socialId)->first();

        if ($user) {

            if ($user->role == 2) {

                return response()->json([
                    'success' => false,
                    'message' => 'Social login not allowed for this role.',
                ], 403);
            }

            if ($user->status == 0) {

                return response()->json([
                    'success' => false,
                    'message' => 'Account is deactivated.',
                ], 403);
            }

            $user->tokens()->delete();

            $registrationFee = optional(
                RegistrationSetting::first()
            )->registration_fee ?? 0;

            if ($registrationFee > 0 && $user->is_paid == 0) {

                return response()->json([
                    'success' => false,
                    'code'    => 'PAYMENT_REQUIRED',
                    'message' => 'Registration payment pending. Please complete payment.',
                ], 402);
            }

            $token = $user->createToken('API Token')->plainTextToken;

            \DB::table('social_login_tokens')
                ->where('token', $request->social_token)
                ->delete();

            return response()->json([
                'success'      => true,
                'user'         => $user,
                'token'        => $token,
                'redirect_url' => $user->role == 1
                    ? '/counselor/profile'
                    : '/feed',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Existing email user
        |--------------------------------------------------------------------------
        */

        $existingUser = null;

        if ($email) {

            $existingUser = User::where('email', $email)
                ->orWhere('pending_email', $email)
                ->first();
        }

        if ($existingUser) {

            /*
            | OTP must be verified
            */

            $request->validate([
                'otp_verified' => 'required|in:1',
            ]);

            /*
            | Pending email -> main email
            */

            if ($existingUser->pending_email === $email) {

                $existingUser->email         = $existingUser->pending_email;
                $existingUser->pending_email = null;
            }

            /*
            | Attach social login
            */

            $existingUser->social_id         = $socialId;
            $existingUser->email_verified_at = now();

            $existingUser->save();

            /*
            | Admin check
            */

            if ($existingUser->role == 2) {

                return response()->json([
                    'success' => false,
                    'message' => 'Social login not allowed for this role.',
                ], 403);
            }

            /*
            | Deactivated account
            */

            if ($existingUser->status == 0) {

                return response()->json([
                    'success' => false,
                    'message' => 'Account is deactivated.',
                ], 403);
            }

            /*
            | Remove old tokens
            */

            $existingUser->tokens()->delete();

            /*
            |--------------------------------------------------------------------------
            | PAYMENT
            |--------------------------------------------------------------------------
            */

            $registrationFee = optional(
                RegistrationSetting::first()
            )->registration_fee ?? 0;

            if (
                $registrationFee > 0 &&
                $existingUser->is_paid == 0
            ) {

                return response()->json([
                    'success' => false,
                    'code'    => 'PAYMENT_REQUIRED',
                    'message' => 'Registration payment pending. Please complete payment.',
                ], 402);
            }

            /*
            |--------------------------------------------------------------------------
            | Login
            |--------------------------------------------------------------------------
            */

            $token = $existingUser
                ->createToken('API Token')
                ->plainTextToken;

            /*
            | Delete temporary token
            */

            \DB::table('social_login_tokens')
                ->where('token', $request->social_token)
                ->delete();

            return response()->json([
                'success'      => true,
                'user'         => $existingUser,
                'token'        => $token,
                'redirect_url' => $existingUser->role == 1
                    ? '/counselor/profile'
                    : '/feed',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NEW USER PROFILE VALIDATION
        |--------------------------------------------------------------------------
        */

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

        /*
        | Counselor specialization
        */

        if ($request->role == 1) {

            $rules['specialization_id'] = 'required|exists:specializations,id';
        }

        $request->validate($rules);

        /*
        |--------------------------------------------------------------------------
        | Generate referral code
        |--------------------------------------------------------------------------
        */

        do {

            $referCode =
            strtolower($request->first_name)
            . '_'
            . rand(1000, 9999);

        } while (
            User::where('refer_code', $referCode)->exists()
        );

        /*
        |--------------------------------------------------------------------------
        | Find referrer
        |--------------------------------------------------------------------------
        */

        $referrer = null;

        if ($request->filled('refer_code')) {

            $referrer = User::where(
                'refer_code',
                $request->refer_code
            )->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Create user
        |--------------------------------------------------------------------------
        */

        $user = User::create([

            'first_name'        => $request->first_name,

            'last_name'         => $request->last_name,

            'email'             => $email,

            'email_verified_at' => now(),

            'gender'            => $request->gender,

            'role'              => $request->role,

            'status'            => 1,

            'UserStatus'        => 1,

            'password'          => \Hash::make(
                Str::random(12)
            ),

            'refer_code'        => $referCode,

            'address'           => $request->address,

            'referred_by'       => $referrer
                ? $referrer->id
                : null,

            'social_id'         => $socialId,

            'specialization_id' => $request->role == 1
                ? $request->specialization_id
                : null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin notification
        |--------------------------------------------------------------------------
        */

        $totalCounselees = User::where(
            'role',
            0
        )->count();

        $totalCounselors = User::where(
            'role',
            1
        )->count();

        Mail::to('admin@gmail.com')->send(

            new NewUserRegisteredMail(
                $user,
                $totalCounselees,
                $totalCounselors
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Device record
        |--------------------------------------------------------------------------
        */

        if (method_exists($user, 'devices')) {

            $user->devices()->create([

                'device_token' => null,

                'device_type'  => $socialData->provider,

                'device_name'  => $socialData->provider,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Payment check
        |--------------------------------------------------------------------------
        */

        $registrationFee = optional(
            RegistrationSetting::first()
        )->registration_fee ?? 0;

        if ($registrationFee > 0) {

            return response()->json([

                'success'          => false,

                'code'             => 'PAYMENT_REQUIRED',

                'message'          => 'Registration fee required.',

                'user_id'          => $user->id,

                'registration_fee' => $registrationFee,
            ], 402);
        }

        /*
        |--------------------------------------------------------------------------
        | Login
        |--------------------------------------------------------------------------
        */

        $token = $user
            ->createToken('API Token')
            ->plainTextToken;

        /*
        | Delete temporary social token
        */

        \DB::table('social_login_tokens')
            ->where('token', $request->social_token)
            ->delete();

        return response()->json([

            'success'      => true,

            'user'         => $user,

            'token'        => $token,

            'redirect_url' => $user->role == 1
                ? '/counselor/profile'
                : '/feed',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK EMAIL
    |--------------------------------------------------------------------------
    */

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = User::where('email', $request->email)
            ->orWhere('pending_email', $request->email)
            ->exists();

        return response()->json([
            'success' => true,
            'exists'  => $exists,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SEND OTP
    |--------------------------------------------------------------------------
    */

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        $otp = rand(100000, 999999);

        Session::put('otp_email', $email);
        Session::put('otp_code', $otp);
        Session::put(
            'otp_expires',
            now()->addMinutes(5)
        );

        $exists = User::where('email', $email)
            ->orWhere('pending_email', $email)
            ->exists();

        Mail::to($email)->send(
            new OtpMail($otp)
        );

        return response()->json([
            'success' => true,
            'exists'  => $exists,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        if (
            Session::get('otp_email') === $request->email &&
            Session::get('otp_code') == $request->otp &&
            now()->lt(
                Session::get('otp_expires')
            )
        ) {

            Session::forget([
                'otp_email',
                'otp_code',
                'otp_expires',
            ]);

            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Wrong OTP',
        ], 422);
    }
}
