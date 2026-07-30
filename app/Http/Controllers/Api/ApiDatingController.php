<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiDatingController extends Controller
{
    public function status()
    {
        $auth = Auth::user();

        if ($auth->role != 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $details = UserDetail::firstOrCreate(
            [
                'user_id' => $auth->id,
            ],
            [
                'onboarding_step'     => 1,
                'profile_completed'   => false,
                'verification_status' => 'not_uploaded',
            ]
        );

        if (
            ! $details->identity ||
            ! $details->preference ||
            ! $details->interest
        ) {

            return response()->json([
                'status'       => 'profile_not_started',

                'current_step' => 1,

                'next_action'  => 'start_onboarding',

                'message'      => 'Start your dating profile.',
            ]);
        }

        $resumeStep = min(
            ($details->onboarding_step ?? 1) + 1,
            12
        );

        if (! $details->profile_completed) {

            return response()->json([

                'status'       => 'profile_incomplete',

                // Last saved step
                'current_step' => $details->onboarding_step ?? 1,

                // App yaha se continue karega
                'resume_step'  => $resumeStep,

                'next_action'  => 'complete_profile',

                'message'      => 'Complete your dating profile.',

            ]);
        }

        switch ($details->verification_status) {

            case 'not_uploaded':

                return response()->json([

                    'status'              => 'verification_required',

                    'current_step'        => 12,

                    'verification_status' => 'not_uploaded',

                    'next_action'         => 'upload_verification',

                    'message'             => 'Please upload verification photos.',

                ]);

            case 'pending':

                return response()->json([

                    'status'              => 'verification_pending',

                    'current_step'        => 12,

                    'verification_status' => 'pending',

                    'next_action'         => 'wait',

                    'message'             => 'Your verification is under review.',

                ]);

            case 'rejected':

                return response()->json([

                    'status'              => 'verification_rejected',

                    'current_step'        => 12,

                    'verification_status' => 'rejected',

                    'next_action'         => 'upload_again',

                    'rejection_reason'    => $details->rejection_reason,

                    'message'             => 'Verification rejected. Upload again.',

                ]);

            case 'approved':

                return response()->json([

                    'status'              => 'approved',

                    'current_step'        => 12,

                    'verification_status' => 'approved',

                    'next_action'         => 'open_dating',

                    'message'             => 'Dating profile approved.',

                ]);

        }

        return response()->json([
            'status'       => 'unknown',
            'current_step' => $details->onboarding_step,
            'message'      => 'Unknown status.',
        ]);
    }

    public function updateDetails(Request $request)
    {
        $request->validate([
            'preference'        => 'required|string',
            'interest'          => 'required|array|min:1',
            'interest.*'        => 'string|max:50',
            'relationship_type' => 'required|string',
            'bio'               => 'nullable|string|max:300',

            'photo1'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo2'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo3'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo4'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo5'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo6'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        $details = UserDetail::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                // Basic
                'display_name'       => $request->display_name,
                'date_of_birth'      => $request->date_of_birth,
                'height'             => $request->height,
                'city'               => $request->city,
                'job_title'          => $request->job_title,
                'education'          => $request->education,
                'languages'          => $request->languages,

                // Dating
                'preference'         => $request->preference,
                'interest'           => $request->interest
                    ? json_encode($request->interest)
                    : null,
                'relationship_type'  => $request->relationship_type,

                // Gender
                'gender'             => $request->gender,
                'pronouns'           => $request->pronouns,

                // Lifestyle
                'smoking'            => $request->smoking,
                'drinking'           => $request->drinking,
                'workout'            => $request->workout,
                'diet'               => $request->diet,
                'pets'               => $request->pets,

                // Privacy
                'profile_visibility' => $request->profile_visibility,
                'who_can_message'    => $request->who_can_message,

                // Matching preference
                'min_age'            => $request->min_age,
                'max_age'            => $request->max_age,
                'max_distance'       => $request->max_distance,
                'hide_distance'      => $request->has('hide_distance') ? 1 : 0,
                'hide_online_status' => $request->has('hide_online_status') ? 1 : 0,
                // Bio
                'bio'                => $request->bio,
                'identity'           => $request->gender,
            ]
        );

        // Photo Upload
        for ($i = 1; $i <= 6; $i++) {

            if ($request->hasFile('photo' . $i)) {

                if ($details->{'photo' . $i}) {
                    Storage::disk('public')
                        ->delete($details->{'photo' . $i});
                }

                $details->{'photo' . $i} =
                $request->file('photo' . $i)
                    ->store('dating_photos', 'public');

            }

        }

        $details->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Details updated.',
        ]);
    }

    public function matches()
    {
        $auth = Auth::user();

        if ($auth->role != 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $details = UserDetail::firstOrCreate(
            ['user_id' => $auth->id],
            [
                'onboarding_step'     => 1,
                'profile_completed'   => false,
                'verification_status' => 'not_uploaded',
            ]
        );

        // Onboarding not completed
        if (! $details->profile_completed) {
            return response()->json([
                'status'  => 'profile_incomplete',
                'details' => $details,
                'message' => 'Please complete your dating profile.',
            ]);
        }

        // Blocked users
        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        // Users
        $allUsers = $this->getVisibleProfiles(
            $auth,
            $details,
            $hiddenUsers
        );

        $matches = collect();

        foreach ($allUsers as $other) {

            $score = 0;

            // Preference match
            if (
                $other->identity == $details->preference &&
                $details->identity == $other->preference
            ) {
                $score += 40;
            }

            // City
            if ($details->city && $details->city == $other->city) {
                $score += 20;
            }

            // Relationship
            if ($other->relationship_type == $details->relationship_type) {
                $score += 20;
            }

            // Interests
            $myInterests    = $details->interest ?? [];
            $theirInterests = $other->interest ?? [];

            if (is_string($myInterests)) {
                $myInterests = json_decode($myInterests, true) ?? [$myInterests];
            }

            if (is_string($theirInterests)) {
                $theirInterests = json_decode($theirInterests, true) ?? [$theirInterests];
            }

            $common = count(array_intersect(
                $myInterests ?? [],
                $theirInterests ?? []
            ));

            if ($common >= 3) {
                $score += 30;
            } elseif ($common == 2) {
                $score += 20;
            } elseif ($common == 1) {
                $score += 10;
            }

            // Verified bonus
            if ($other->verification_status == 'approved') {
                $score += 20;
            }

            if ($score >= 40) {

                $user = $other->user;

                // Friend count
                $user->friend_count = Friendship::where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })
                    ->where('status', 'accepted')
                    ->count();

                // Friendship status
                $friendship = Friendship::where(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $auth->id)
                        ->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $user->id)
                        ->where('receiver_id', $auth->id);
                })->first();

                // Skip accepted & pending
                if ($friendship && in_array($friendship->status, ['accepted', 'pending'])) {
                    continue;
                }

                $user->friendship_status = $friendship?->status;
                $user->friendship_sender = (int) ($friendship->sender_id ?? 0);

                $other->match_score = $score;

                $matches->push($other);
            }
        }

        $matches = $matches
            ->sortByDesc('match_score')
            ->take(50)
            ->values();

        return response()->json([
            'status'  => 'success',
            'user'    => $auth,
            'details' => $details,
            'matches' => $matches,
        ]);
    }

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

        $details = UserDetail::where('user_id', $user->id)
            ->first();

        if ($details) {

            foreach (
                [
                    'photo1',
                    'photo2',
                    'photo3',
                    'photo4',
                    'photo5',
                    'photo6',
                    'verification_selfie',
                    'verification_id',
                ] as $photo
            ) {
                if ($details->$photo) {
                    Storage::disk('public')->delete($details->$photo);
                }
            }

            $details->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dating profile deleted successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No dating profile found.',
        ], 404);
    }

    public function saveStep(Request $request)
    {
        try {

            $user = Auth::user();

            $details = UserDetail::firstOrCreate([
                'user_id' => $user->id,
            ]);

            switch ((int) $request->step) {

                // Welcome
                case 1:
                    break;

                // Verification intro
                case 2:
                    break;

                // Identity + Preference
                case 3:

                    $request->validate([
                        'identity'          => 'required|string|in:male,female,non_binary,transgender',
                        'preference'        => 'required|string',
                        'relationship_type' => 'required|string',
                    ]);

                    $details->identity          = $request->identity;
                    $details->preference        = $request->preference;
                    $details->relationship_type = $request->relationship_type;

                    break;

                // Basic Information
                case 4:

                    $request->validate([
                        'dating_display_name' => 'required|string|max:50',
                        'dob'                 => 'required|date|before:-18 years',
                        'height'              => 'nullable|numeric|min:100|max:250',
                        'city'                => 'required|string|max:100',
                        'occupation'          => 'nullable|string|max:100',
                    ]);

                    $details->display_name  = $request->dating_display_name;
                    $details->date_of_birth = $request->dob;
                    $details->height        = $request->height;
                    $details->city          = $request->city;
                    $details->job_title     = $request->occupation;

                    break;

                // Gender
                case 5:

                    $request->validate([
                        'gender'   => 'required|string',
                        'pronouns' => 'nullable|string|max:30',
                    ]);

                    $details->gender   = $request->gender;
                    $details->pronouns = $request->pronouns;

                    break;

                // Photos
                case 6:

                    $request->validate([
                        'photos'   => 'required|array|min:4|max:6',
                        'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
                    ]);

                    if ($request->hasFile('photos')) {

                        $photos = $request->file('photos');

                        foreach ($photos as $key => $photo) {

                            if ($key >= 6) {
                                break;
                            }

                            $photoPath = $photo->store(
                                'dating_photos',
                                'public'
                            );

                            $column = 'photo' . ($key + 1);

                            // delete old image
                            if ($details->$column) {

                                \Storage::disk('public')
                                    ->delete($details->$column);

                            }

                            $details->$column = $photoPath;

                        }

                    }

                    break;

                // Bio
                case 7:

                    $request->validate([
                        'bio' => 'required|string|min:20|max:500',
                    ]);

                    $details->bio = $request->bio;

                    break;

                // Interests
                case 8:

                    $request->validate([
                        'interests'   => 'required|array|min:1',
                        'interests.*' => 'string|max:50',
                    ]);

                    $details->interest = json_encode($request->interests);

                    break;

                // Lifestyle
                case 9:

                    $request->validate([
                        'lifestyle_smoking'  => 'required|string',
                        'lifestyle_drinking' => 'required|string',
                        'lifestyle_pets'     => 'nullable|string',
                        'workout'            => 'nullable|string',
                        'diet'               => 'nullable|string',
                    ]);

                    $details->smoking = $request->lifestyle_smoking;

                    $details->drinking = $request->lifestyle_drinking;

                    $details->pets = $request->lifestyle_pets;

                    // extra fields
                    $details->workout = $request->workout;

                    $details->diet = $request->diet;

                    break;

                // Privacy
                case 10:

                    $request->validate([
                        'privacy_profile_view' => 'required|in:everyone,verified_only',
                        'who_can_message'      => 'required|in:everyone,verified_only',
                    ]);

                    $details->profile_visibility = $request->privacy_profile_view ?? 'everyone';

                    $details->who_can_message = $request->who_can_message ?? 'everyone';

                    $details->hide_distance = $request->hide_distance ? 1 : 0;

                    $details->hide_online_status = $request->hide_online ? 1 : 0;

                    break;

                // Match Preferences
                case 11:

                    $request->validate([
                        'min_age'      => 'required|integer|min:18|max:99',
                        'max_age'      => 'required|integer|gte:min_age|max:99',
                        'max_distance' => 'required|integer|min:1|max:500',
                    ]);

                    $details->min_age =
                    $request->min_age;

                    $details->max_age =
                    $request->max_age;

                    $details->max_distance =
                    $request->max_distance;

                    $details->verified_only =
                    $request->verified_only ? 1 : 0;

                    $details->people_with_photos =
                    $request->people_with_photos ? 1 : 0;

                    $details->similar_interests =
                    $request->similar_interests ? 1 : 0;

                    break;

                // Complete Profile
                case 12:

                    $details->profile_completed = 1;

                    break;

            }

            $details->onboarding_step = max(
                $details->onboarding_step ?? 0,
                (int) $request->step
            );

            $details->save();

            return response()->json([
                'success' => true,
                'message' => 'Step saved successfully',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    private function getVisibleProfiles($auth, $details, $hiddenUsers)
    {
        $visibilityFilter = request('visibility', 'everyone');

        $query = UserDetail::with('user')
            ->where('user_id', '!=', $auth->id)
            ->whereNotIn('user_id', $hiddenUsers);

        $isVerified = $details->verification_status === 'approved';

        if (! $isVerified) {

            if ($visibilityFilter == 'verified') {

                $query->where('verification_status', 'approved')
                    ->where('profile_visibility', 'everyone');

            } else {

                $query->where(function ($q) {

                    $q->where('verification_status', '!=', 'approved')

                        ->orWhere(function ($q2) {

                            $q2->where('verification_status', 'approved')
                                ->where('profile_visibility', 'everyone');

                        });

                });

            }

        } else {

            if ($visibilityFilter == 'verified') {

                $query->where('verification_status', 'approved')
                    ->whereIn('profile_visibility',
                        [
                            'everyone',
                            'verified_only',
                        ]);

            } else {

                $query->where(function ($q) {

                    $q->where('verification_status', '!=', 'approved')

                        ->orWhere(function ($q2) {

                            $q2->where('verification_status', 'approved')
                                ->whereIn('profile_visibility',
                                    [
                                        'everyone',
                                        'verified_only',
                                    ]);

                        });

                });

            }

        }

        return $query->limit(300)->get();
    }

    public function uploadVerification(Request $request)
    {
        $auth = Auth::user();

        if ($auth->role != 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $details = UserDetail::where('user_id', $auth->id)
            ->first();

        if (! $details) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Dating profile not found.',
            ], 404);
        }

        // Profile complete check
        if (! $details->profile_completed) {

            return response()->json([
                'status'  => 'profile_incomplete',
                'message' => 'Complete your dating profile first.',
            ], 422);

        }

        $request->validate([

            'verification_selfie' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'verification_id'     => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

        ]);

        if ($details->verification_selfie) {

            Storage::disk('public')
                ->delete($details->verification_selfie);

        }

        if ($details->verification_id) {

            Storage::disk('public')
                ->delete($details->verification_id);

        }

        if ($request->hasFile('verification_selfie')) {

            $details->verification_selfie =
            $request->file('verification_selfie')
                ->store('verification', 'public');

        }

        if ($request->hasFile('verification_id')) {

            $details->verification_id =
            $request->file('verification_id')
                ->store('verification', 'public');

        }

        $details->verification_method =
        $request->hasFile('verification_id')
            ? 'id'
            : 'selfie';

        $details->verification_status = 'pending';

        $details->onboarding_step = 12;

        $details->profile_completed = 1;

        // old rejection clear
        $details->rejection_reason = null;

        $details->save();

        return response()->json([

            'status'              => 'success',

            'verification_status' => 'pending',

            'message'             => 'Verification uploaded successfully. Waiting for approval.',

        ]);

    }
}
