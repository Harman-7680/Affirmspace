<?php
namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DatingController extends Controller
{
    public function pages()
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;
        $details       = $auth->details;

        // If user has not filled dating details → show details form
        if (! $details || ! $details->identity || ! $details->interest || ! $details->preference) {
            return view('user.dating.pages', compact('auth', 'notifications', 'details'))
                ->with('user', $auth);
        }

        /* ---------------------------------------------
        NEW: Verification Logic
        ----------------------------------------------*/

        // 1) NOT UPLOADED → Force photo upload
        if ($details->verification_status === 'not_uploaded') {
            return redirect()->route('dating.upload.photos')
                ->with('error', 'Please upload your verification photos.');
        }

        // 2) PENDING → Show waiting page
        if ($details->verification_status === 'pending') {
            return redirect()->route('dating.verification.wait');
        }

        // 3) REJECTED → Force re-upload photos
        if ($details->verification_status === 'rejected') {
            return redirect()->route('dating.upload.photos')
                ->with('error', 'Your verification was rejected. Please upload again.');
        }

        // 4) APPROVED → Continue to normal matching
        // NO NEED TO REDIRECT — just continue

        /* ---------------------------------------------
        Your original matching code starts here
        ----------------------------------------------*/

        // Get all BLOCKED users
        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        // STEP 1 → Get all other users with details
        // $allUsers = UserDetail::with('user')
        //     ->where('user_id', '!=', $auth->id)
        //     ->whereNotIn('user_id', $hiddenUsers)
        //     ->get();

        $allUsers = UserDetail::with('user')
            ->where('user_id', '!=', $auth->id)
            ->where('verification_status', 'approved')
            ->whereNotIn('user_id', $hiddenUsers)
            ->inRandomOrder()
            ->get();

        $matches = collect();

        // STEP 2 → Loop and find matching users
        foreach ($allUsers as $other) {

            $matchCount = 0;

            if ($other->identity === $details->preference) {
                $matchCount++;
            }

            if ($other->relationship_type === $details->relationship_type) {
                $matchCount++;
            }

            if ($other->interest === $details->interest) {
                $matchCount++;
            }

            if ($matchCount >= 2) {

                $user = $other->user;

                // Friend count
                $friendCount = \App\Models\Friendship::where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })->where('status', 'accepted')->count();

                $user->friend_count = $friendCount;

                // Friendship status
                $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
                })->first();

                // if ($friendship && $friendship->status === 'accepted') {
                //     continue;
                // }

                $user->friendship_status = $friendship?->status;
                $user->friendship_sender = (int) ($friendship->sender_id ?? 0);

                $user->UserStatus = $user->UserStatus;

                // push into matches
                $matches->push($other);
            }
        }

        return view('user.dating.pages-matches', [
            'user'          => $auth,
            'notifications' => $notifications,
            'matches'       => $matches,
            'details'       => $details,
        ]);
    }

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
                'identity'          => $request->gender,
                'interest'          => $request->interest,
                'preference'        => $request->preference,
                'relationship_type' => $request->relationship_type,
                'bio'               => $request->bio,
            ]
        );

        return redirect()->back()->with('success', 'Details saved successfully');
    }

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

        $user = Auth::user();

        $details = UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                // 'identity'          => $request->identity,
                'interest'          => $request->interest,
                'preference'        => $request->preference,
                'relationship_type' => $request->relationship_type,
                'bio'               => $request->bio,
            ]
        );

        // Handle photo uploads
        for ($i = 1; $i <= 4; $i++) {
            $photo = $request->file('photo' . $i);
            if ($photo) {
                // Delete old photo if exists
                if ($details->{'photo' . $i}) {
                    \Storage::delete('public/' . $details->{'photo' . $i});
                }

                $path                    = $photo->store('user_photos', 'public');
                $details->{'photo' . $i} = $path;
            }
        }

        $details->save();

        return redirect()->back()->with('success', 'Your details updated successfully.');
    }

    public function uploadPhotosPage()
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;
        $details       = $auth->details;

        // If no dating details → force fill details first
        if (! $details || ! $details->identity || ! $details->interest || ! $details->preference) {
            abort(403, 'Unauthorized access');
        }

        if ($details->verification_status == 'pending') {
            return redirect()->route('dating.verification.wait');
        }

        if ($details->verification_status == 'approved') {
            return redirect()->route('pages');
        }

        $user = Auth::user();
        return view('user.dating.upload-photos', compact('auth', 'details', 'notifications', 'user'));
    }

    public function saveUploadedPhotos(Request $request)
    {
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

        // Save images
        $details->photo1 = $request->file('photo1')->store('dating_photos', 'public');
        $details->photo2 = $request->file('photo2')->store('dating_photos', 'public');
        $details->photo3 = $request->file('photo3')->store('dating_photos', 'public');
        $details->photo4 = $request->file('photo4')->store('dating_photos', 'public');
        $details->selfie = $request->file('selfie')->store('dating_selfies', 'public');

        // Set status pending
        $details->verification_status = 'pending';
        $details->save();

        // Send pending email
        Mail::to($user->email)->send(new \App\Mail\PendingVerificationMail($user));

        return redirect()->route('dating.verification.wait');
    }

    public function verificationWait()
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        // If no details or status not pending → unauthorized
        // $details = $auth->details;
        // if (! $details || $details->verification_status !== 'pending') {
        //     abort(403, 'Unauthorized access');
        // }

        $notifications = $auth->unreadNotifications;

        return view('user.dating.verification-waiting', compact('auth', 'notifications'));
    }

    public function datingProfile($id)
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;

        // Load the user and details
        $user    = User::with('details')->findOrFail($id);
        $details = $user->details;

        // Check if details exist and status is approved
        if (! $details || $details->verification_status !== 'approved') {
            abort(403, 'Unauthorized access');
        }

        // Friendship status check
        $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $id) {
            $q->where('sender_id', $auth->id)
                ->where('receiver_id', $id);
        })->orWhere(function ($q) use ($auth, $id) {
            $q->where('sender_id', $id)
                ->where('receiver_id', $auth->id);
        })->first();

        return view('user.dating.dating-profile', compact('user', 'notifications', 'details', 'friendship'));
    }

    public function destroy()
    {
        $user = Auth::user();

        // Delete dating profile
        UserDetail::where('user_id', $user->id)->delete();
        return redirect('/feed')->with('success', 'Dating profile deleted successfully.');
    }
}
