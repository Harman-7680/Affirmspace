<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Friendship;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApiDatingController extends Controller
{
    /**
     * ---------------------------------------------------------
     * 1. CHECK USER STATUS → WHAT TO DO NEXT
     * ---------------------------------------------------------
     */
    public function status()
    {
        $auth = Auth::user();

        if ($auth->role != 0) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $details = $auth->details;

        // No details filled
        if (! $details || ! $details->identity || ! $details->interest || ! $details->preference) {
            return response()->json([
                'status'  => 'no_details',
                'message' => 'Please fill your dating details.',
            ]);
        }

        // Status check
        return response()->json([
            'status'  => $details->verification_status,
            'message' => match ($details->verification_status) {
                'not_uploaded' => 'Please upload your verification photos.',
                'pending'      => 'Verification in review.',
                'rejected'     => 'Verification rejected. Upload again.',
                'approved'     => 'Verification approved. Continue.',
                default        => 'Unknown status'
            },
        ]);
    }

    /**
     * ---------------------------------------------------------
     * 2. SAVE BASIC USER DETAILS
     * ---------------------------------------------------------
     */
    public function saveDetails(Request $request)
    {
        $request->validate([
            'gender'            => 'required|string',
            'interest'          => 'required|string',
            'preference'        => 'required|string',
            'relationship_type' => 'required|string',
            'bio'               => 'nullable|string',
        ]);

        UserDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'identity'            => $request->gender,
                'interest'            => $request->interest,
                'preference'          => $request->preference,
                'relationship_type'   => $request->relationship_type,
                'bio'                 => $request->bio,
                'verification_status' => 'not_uploaded',
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Details saved successfully.',
            'next'    => '/api/dating/photos/upload',
        ]);
    }

    /**
     * ---------------------------------------------------------
     * 3. UPLOAD VERIFICATION PHOTOS
     * ---------------------------------------------------------
     */
    public function uploadPhotos(Request $request)
    {
        // $request->validate([
        //     'photo1' => 'required|image',
        //     'photo2' => 'required|image',
        //     'photo3' => 'required|image',
        //     'photo4' => 'required|image',
        //     'selfie' => 'required|image',
        // ]);

        $request->validate([
            'photo1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photo2' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photo3' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photo4' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'selfie' => 'required|image|max:2048',
        ], [
            'photo1.max' => 'Photo must be less than 2MB.',
            'photo2.max' => 'Photo must be less than 2MB.',
            'photo3.max' => 'Photo must be less than 2MB.',
            'photo4.max' => 'Photo must be less than 2MB.',
            'selfie.max' => 'Selfie must be less than 2MB.',
        ]);

        $user    = Auth::user();
        $details = $user->details;

        $details->photo1 = $request->file('photo1')->store('dating_photos', 'public');
        $details->photo2 = $request->file('photo2')->store('dating_photos', 'public');
        $details->photo3 = $request->file('photo3')->store('dating_photos', 'public');
        $details->photo4 = $request->file('photo4')->store('dating_photos', 'public');
        $details->selfie = $request->file('selfie')->store('dating_selfies', 'public');

        $details->verification_status = 'pending';
        $details->save();

        // Send email
        Mail::to($user->email)->send(new \App\Mail\PendingVerificationMail($user));

        return response()->json([
            'status'  => 'success',
            'message' => 'Photos uploaded. Verification pending.',
            'next'    => '/api/dating/status',
        ]);
    }

    /**
     * ---------------------------------------------------------
     * 4. UPDATE DETAILS + REUPLOAD PHOTOS IF NEEDED
     * ---------------------------------------------------------
     */
    public function updateDetails(Request $request)
    {
        $request->validate([
            'identity'          => 'required|string',
            'interest'          => 'required|string',
            'preference'        => 'required|string',
            'relationship_type' => 'required|string',
            'bio'               => 'nullable|string|max:300',
            'photo1'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photo2'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photo3'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photo4'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'photo1.max'   => 'Photo 1 must be less than 2MB.',
            'photo2.max'   => 'Photo 2 must be less than 2MB.',
            'photo3.max'   => 'Photo 3 must be less than 2MB.',
            'photo4.max'   => 'Photo 4 must be less than 2MB.',
            'photo1.mimes' => 'Photo 1 must be an image (jpeg, png, jpg, gif, webp).',
            'photo2.mimes' => 'Photo 2 must be an image (jpeg, png, jpg, gif, webp).',
            'photo3.mimes' => 'Photo 3 must be an image (jpeg, png, jpg, gif, webp).',
            'photo4.mimes' => 'Photo 4 must be an image (jpeg, png, jpg, gif, webp).',
        ]);

        $details = UserDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                // 'identity'          => $request->identity,
                'interest'          => $request->interest,
                'preference'        => $request->preference,
                'relationship_type' => $request->relationship_type,
                'bio'               => $request->bio,
            ]
        );

        for ($i = 1; $i <= 4; $i++) {
            $photo = $request->file("photo$i");
            if ($photo) {
                if ($details->{"photo$i"}) {
                    \Storage::delete('public/' . $details->{"photo$i"});
                }
                $details->{"photo$i"} = $photo->store('dating_photos', 'public');
            }
        }

        $details->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Details updated.',
        ]);
    }

    /**
     * ---------------------------------------------------------
     * 5. GET MATCHED USERS (Main Feed)
     * ---------------------------------------------------------
     */

    public function matches()
    {
        $auth    = Auth::user();
        $details = $auth->details;

        if (! $details) {
            return response()->json([
                'status'  => 'error',
                'message' => 'You do not have a dating account.',
            ]);
        }

        if ($details->verification_status !== 'approved') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Your verification is not approved yet. Matches are available only after approval.',
            ]);
        }

        // Hidden users (blocked)
        $blockedUsers = Block::where('user_id', $auth->id)
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $hidden = array_unique(array_merge($blockedUsers, $blockedByUsers));

        // All other users
        // $users = UserDetail::with('user')
        //     ->where('user_id', '!=', $auth->id)
        //     ->whereNotIn('user_id', $hidden)
        //     ->get();

        $users = UserDetail::with('user')
            ->where('user_id', '!=', $auth->id)
            ->where('verification_status', 'approved')
            ->whereNotIn('user_id', $hidden)
            ->inRandomOrder()
            ->get();

        $matches = [];

        foreach ($users as $other) {
            $count = 0;

            if ($other->identity === $details->preference) {
                $count++;
            }

            if ($other->relationship_type === $details->relationship_type) {
                $count++;
            }

            if ($other->interest === $details->interest) {
                $count++;
            }

            if ($count >= 2) {
                $u = $other->user;

                // Friend count
                $u->friend_count = Friendship::where(function ($q) use ($u) {
                    $q->where('sender_id', $u->id)->orWhere('receiver_id', $u->id);
                })->where('status', 'accepted')->count();

                // Friendship status
                $friendship = Friendship::where(function ($q) use ($auth, $u) {
                    $q->where('sender_id', $auth->id)->where('receiver_id', $u->id);
                })->orWhere(function ($q) use ($auth, $u) {
                    $q->where('sender_id', $u->id)->where('receiver_id', $auth->id);
                })->first();

                if ($friendship && $friendship->status === 'accepted') {
                    continue;
                }

                if ($friendship && $friendship->status === 'pending') {
                    continue;
                }

                $u->friendship_status = $friendship?->status;
                $u->friendship_sender = (int) ($friendship->sender_id ?? 0);

                $matches[] = $other;
            }
        }

        return response()->json([
            'status'  => 'success',
            'user'    => $auth,
            'matches' => $matches,
        ]);
    }

    /**
     * ---------------------------------------------------------
     * 6. VIEW PROFILE OF ANY USER
     * ---------------------------------------------------------
     */

    public function viewProfile($id)
    {
        $auth    = Auth::user();
        $details = $auth->details;

        if (! $details) {
            return response()->json([
                'status'  => 'error',
                'message' => 'You do not have a dating account.',
            ]);
        }

        if ($details->verification_status !== 'approved') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Your verification is not approved yet. Users available only after approval.',
            ]);
        }

        $user = User::with('details')->findOrFail($id);

        $friendship = Friendship::where(function ($q) use ($auth, $id) {
            $q->where('sender_id', $auth->id)->where('receiver_id', $id);
        })->orWhere(function ($q) use ($auth, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $auth->id);
        })->first();

        return response()->json([
            'status'     => 'success',
            'user'       => $user,
            'details'    => $user->details,
            'friendship' => $friendship,
        ]);
    }

    public function destroy()
    {
        $user = Auth::user();

        $deleted = UserDetail::where('user_id', $user->id)->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Dating profile deleted successfully.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No dating profile found.',
        ], 404);
    }
}
