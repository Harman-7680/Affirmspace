<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Message;
use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (! Auth::attempt($credentials)) {
    //         return response()->json([
    //             'message' => 'Invalid email or password.',
    //         ], 401);
    //     }

    //     $user = Auth::user();

    //     if (! $user || $user->status == 0) {
    //         $message = ! $user
    //             ? 'We could not find an account with this email address.'
    //             : 'Sorry, your account is deactivated.';
    //         return response()->json(['message' => $message], 403);
    //     }

    //     // Check email verification
    //     if (! $user->hasVerifiedEmail()) {
    //         Auth::logout(); // safely logout
    //         return response()->json([
    //             'message' => 'You need to verify your email before logging in.',
    //         ], 403); // 403 Forbidden
    //     }

    //     // Save or update device token
    //     if (empty($request->device_token)) {
    //         return response()->json([
    //             'message' => 'Device token is required',
    //         ], 422); // 422 Unprocessable Entity
    //     }

    //     $user->devices()->updateOrCreate(
    //         ['device_token' => $request->device_token],
    //         ['device_type' => $request->device_type ?? 'unknown']
    //     );

    //     $token = $user->createToken('API Token')->plainTextToken;

    //     // If Counselee (role = 0) → Return feed data
    //     if ($user->role == 0) {
    //         $notifications = $user->unreadNotifications;
    //         $friends       = $user->friendsList();

    //         $all_users = User::where('id', '!=', $user->id)
    //             ->with('ratingsReceived')
    //             ->get();

    //         foreach ($all_users as $u) {
    //             $u->friend_count = \App\Models\Friendship::where(function ($q) use ($u) {
    //                 $q->where('sender_id', $u->id)->orWhere('receiver_id', $u->id);
    //             })->where('status', 'accepted')->count();

    //             $u->is_friend = $friends->contains('id', $u->id);

    //             $friendship = \App\Models\Friendship::where(function ($q) use ($user, $u) {
    //                 $q->where('sender_id', $user->id)->where('receiver_id', $u->id);
    //             })->orWhere(function ($q) use ($user, $u) {
    //                 $q->where('sender_id', $u->id)->where('receiver_id', $user->id);
    //             })->first();

    //             $u->friendship_status = $friendship?->status;
    //             $u->friendship_sender = $friendship?->sender_id;
    //             $u->average_rating    = round($u->ratingsReceived->avg('rating') ?? 0, 1);
    //         }

    //         $all_posts = Post::with(['user', 'likes', 'comments.user'])
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         $statuses = Status::with('user')
    //             ->where('created_at', '>=', now()->subDay())
    //             ->latest()
    //             ->get()
    //             ->groupBy('user_id')
    //             ->map(fn($group) => collect($group));

    //         return response()->json([
    //             'message'       => 'Login successful',
    //             'role'          => 'counselee',
    //             'token'         => $token,
    //             'user'          => $user,
    //             'notifications' => $notifications,
    //             'all_users'     => $all_users,
    //             'posts'         => $all_posts,
    //             'statuses'      => $statuses,
    //         ]);
    //     }

    //     // If Counselor (role = 1) → Return counselor details
    //     elseif ($user->role == 1) {
    //         // Notifications
    //         $notifications = $user->unreadNotifications;

    //         // Availabilities (future dates only)
    //         $availabilities = $user->availabilities()
    //             ->where('available_date', '>=', now()->toDateString())
    //             ->orderBy('available_date')
    //             ->orderBy('start_time')
    //             ->get();

    //         // Latest 4 messages
    //         $messages = Message::where('receiver_id', $user->id)
    //             ->orderBy('created_at', 'desc')
    //             ->take(4)
    //             ->get();

    //         // Ratings
    //         $averageRating = $user->ratingsReceived()->avg('rating');
    //         $totalReviews  = $user->ratingsReceived()->count();

    //         // Friend count (optional)
    //         $friendCount = $user->friends()->count();

    //         // Appointments (if relation exists)
    //         $appointments = Message::with('availability')
    //             ->where(function ($query) use ($user) {
    //                 $query->where('sender_id', $user->id)
    //                     ->orWhere('receiver_id', $user->id);
    //             })
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         return response()->json([
    //             'message'        => 'Login successful',
    //             'role'           => 'counselor',
    //             'token'          => $token,
    //             'user'           => $user,
    //             'notifications'  => $notifications,
    //             'availabilities' => $availabilities,
    //             'messages'       => $messages,
    //             'appointments'   => $appointments,
    //             'averageRating'  => round($averageRating ?? 0, 1),
    //             'totalReviews'   => $totalReviews,
    //             'friendCount'    => $friendCount,
    //         ]);
    //     }

    //     // Fallback → In case you add more roles later
    //     return response()->json([
    //         'message' => 'Login successful',
    //         'role'    => $user->role,
    //         'token'   => $token,
    //         'user'    => $user,
    //     ]);
    // }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $user = Auth::user();

        if (! $user || $user->status == 0) {
            $message = ! $user
                ? 'We could not find an account with this email address.'
                : 'Your account has been deactivated by admin.';
            return response()->json(['message' => $message], 403);
        }

        // Check email verification
        // if (! $user->hasVerifiedEmail()) {
        //     Auth::logout();
        //     return response()->json([
        //         'message' => 'You need to verify your email before logging in.',
        //     ], 403);
        // }

        // Validate device token presence
        if (empty($request->device_token)) {
            return response()->json([
                'message' => 'Device token is required',
            ], 422);
        }

        $deviceToken = $request->device_token;
        $deviceType  = $request->device_type ?? 'unknown';
        $deviceName  = $request->device_name ?? 'unknown';

        // Reassign device token logic (same as in register)
        $existingDevice = \App\Models\UserDevice::where('device_token', $deviceToken)->first();

        if ($existingDevice) {
            // Update the device record to belong to the new (currently logged-in) user
            $existingDevice->update([
                'user_id'     => $user->id,
                'device_type' => $deviceType,
                'device_name' => $deviceName,
            ]);
        } else {
            // Otherwise, create a new one for this user
            $user->devices()->create([
                'device_token' => $deviceToken,
                'device_type'  => $deviceType,
                'device_name'  => $deviceName,
            ]);
        }

        // DELETE old mobile API tokens (Sanctum)
        $user->tokens()->delete();
        // DELETE old browser sessions (web logins)
        \DB::table('sessions')
            ->where('user_id', $user->id)
            ->delete();

        // Create API token for the user
        $token = $user->createToken('API Token')->plainTextToken;

        // Return response based on user role
        if ($user->role == 0) {
            $notifications = $user->unreadNotifications;
            $friends       = $user->friendsList();

            $all_users = User::where('id', '!=', $user->id)
                ->with('ratingsReceived')
                ->get();

            foreach ($all_users as $u) {
                $u->friend_count = \App\Models\Friendship::where(function ($q) use ($u) {
                    $q->where('sender_id', $u->id)->orWhere('receiver_id', $u->id);
                })->where('status', 'accepted')->count();

                $u->is_friend = $friends->contains('id', $u->id);

                $friendship = \App\Models\Friendship::where(function ($q) use ($user, $u) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $u->id);
                })->orWhere(function ($q) use ($user, $u) {
                    $q->where('sender_id', $u->id)->where('receiver_id', $user->id);
                })->first();

                $u->friendship_status = $friendship?->status;
                $u->friendship_sender = $friendship?->sender_id;
                $u->average_rating    = round($u->ratingsReceived->avg('rating') ?? 0, 1);
            }

            $all_posts = Post::with(['user', 'likes', 'comments.user'])
                ->orderBy('created_at', 'desc')
                ->get();

            $statuses = Status::with('user')
                ->where('created_at', '>=', now()->subDay())
                ->latest()
                ->get()
                ->groupBy('user_id')
                ->map(fn($group) => collect($group));

            return response()->json([
                'message'       => 'Login successful',
                'role'          => 'counselee',
                'token'         => $token,
                'user'          => $user,
                'notifications' => $notifications,
                'all_users'     => $all_users,
                'posts'         => $all_posts,
                'statuses'      => $statuses,
            ]);
        } elseif ($user->role == 1) {
            $notifications = $user->unreadNotifications;

            $availabilities = $user->availabilities()
                ->where('available_date', '>=', now()->toDateString())
                ->orderBy('available_date')
                ->orderBy('start_time')
                ->get();

            $messages = Message::where('receiver_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();

            $averageRating = $user->ratingsReceived()->avg('rating');
            $totalReviews  = $user->ratingsReceived()->count();
            $friendCount   = $user->friends()->count();

            $appointments = Message::with('availability')
                ->where(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $specialization = $user->specialization ? [
                'id'   => $user->specialization->id,
                'name' => $user->specialization->name,
            ] : null;

            return response()->json([
                'message'        => 'Login successful',
                'role'           => 'counselor',
                'token'          => $token,
                'user'           => $user,
                'notifications'  => $notifications,
                'availabilities' => $availabilities,
                'messages'       => $messages,
                'appointments'   => $appointments,
                'averageRating'  => round($averageRating ?? 0, 1),
                'totalReviews'   => $totalReviews,
                'friendCount'    => $friendCount,
                'specialization' => $specialization,
            ]);
        }

        return response()->json([
            'message' => 'Login successful',
            'role'    => $user->role,
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // public function register(Request $request)
    // {
    //     // Validate input
    //     $validator = Validator::make($request->all(), [
    //         'first_name'   => ['required', 'string', 'max:25'],
    //         'last_name'    => ['required', 'string', 'max:25'],
    //         'email'        => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:users,email'],
    //         'password'     => ['required', 'confirmed', Password::defaults()],
    //         'gender'       => ['required', 'string'],
    //         'is_adult'     => ['required', 'boolean'],
    //         'terms'        => ['required', 'boolean'],
    //         'device_token' => ['required', 'string'],
    //         'device_type'  => ['required', 'string'],
    //         'device_name'  => ['required', 'string'],
    //         'role'         => ['required', 'integer'],
    //         'refer_code'   => ['nullable', 'exists:users,refer_code'],
    //         'address'      => ['nullable'],
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Validation failed',
    //             'errors'  => $validator->errors(),
    //         ], 422);
    //     }

    //     $validated = $validator->validated();

    //     do {
    //         $userReferCode = strtolower($validated['first_name']) . '_' . rand(1000, 9999);
    //     } while (User::where('refer_code', $userReferCode)->exists());

    //     $referrer = null;
    //     if (! empty($validated['refer_code'])) {
    //         $referrer = User::where('refer_code', $validated['refer_code'])->first();
    //     }

    //     $user = User::create([
    //         'first_name'  => $validated['first_name'],
    //         'last_name'   => $validated['last_name'],
    //         'gender'      => $validated['gender'] ?? null,
    //         'email'       => $validated['email'],
    //         'password'    => Hash::make($validated['password']),
    //         'role'        => $validated['role'],
    //         'status'      => 1,
    //         'refer_code'  => $userReferCode,                   // user’s own code
    //         'referred_by' => $referrer ? $referrer->id : null, // who referred them
    //         'last_name'   => $validated['address'],
    //     ]);

    //     $user->devices()->create([
    //         'device_token' => $validated['device_token'],
    //         'device_type'  => $validated['device_type'] ?? 'unknown',
    //         'device_name'  => $validated['device_name'] ?? 'unknown',
    //     ]);

    //     event(new Registered($user));

    //     return response()->json([
    //         'status'  => 'success',
    //         'message' => 'Registration successful! Please verify your email.',
    //         'user'    => $user,
    //     ], 201);
    // }

    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'first_name'     => ['required', 'string', 'max:25'],
            'last_name'      => ['required', 'string', 'max:25'],
            'email'          => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:users,email'],
            'password'       => ['required', 'confirmed', Password::defaults()],
            'gender'         => ['required', 'string'],
            'is_adult'       => ['required', 'boolean'],
            'terms'          => ['required', 'boolean'],
            'device_token'   => ['required', 'string'],
            'device_type'    => ['required', 'string'],
            'device_name'    => ['required', 'string'],
            'role'           => ['required', 'integer'],
            'refer_code'     => ['nullable', 'exists:users,refer_code'],
            'address'        => ['nullable', 'string'],
            'specialization' => ['nullable', 'exists:specializations,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Generate unique refer code
        do {
            $userReferCode = strtolower($validated['first_name']) . '_' . rand(1000, 9999);
        } while (User::where('refer_code', $userReferCode)->exists());

        // Find referrer if provided
        $referrer = null;
        if (! empty($validated['refer_code'])) {
            $referrer = User::where('refer_code', $validated['refer_code'])->first();
        }

        // Create new user
        $user = User::create([
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'gender'            => $validated['gender'] ?? null,
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => $validated['role'],
            'status'            => 1,
            'refer_code'        => $userReferCode,
            'referred_by'       => $referrer ? $referrer->id : null,
            'address'           => $validated['address'] ?? null,
            'specialization_id' => $request->role == 1 ? $request->specialization : null,
        ]);

        // Device handling logic
        $deviceToken = $validated['device_token'];

        // Check if this device token already exists
        $existingDevice = \App\Models\UserDevice::where('device_token', $deviceToken)->first();

        if ($existingDevice) {
            // Reassign to new user (if another user previously had it)
            $existingDevice->update([
                'user_id'     => $user->id,
                'device_type' => $validated['device_type'],
                'device_name' => $validated['device_name'],
            ]);
        } else {
            // Otherwise, create a new device entry
            $user->devices()->create([
                'device_token' => $deviceToken,
                'device_type'  => $validated['device_type'] ?? 'unknown',
                'device_name'  => $validated['device_name'] ?? 'unknown',
            ]);
        }

        // Fire Registered event
        // event(new Registered($user));

        return response()->json([
            'status'  => 'success',
            'message' => 'Registration successful',
            'user'    => $user,
        ], 201);
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        // Get validated data
        $validated = $request->validated();

        // Handle password if provided
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Handle profile image
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $path               = $request->file('image')->store('profile_images', 'public');
            $validated['image'] = $path;
        }

        // Update user
        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();

        // Check current password
        if (! Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password does not match.',
            ], 422);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        // Auth::logout();
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully.',
        ], 200);
    }
}
