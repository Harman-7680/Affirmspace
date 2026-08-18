<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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

        $details = UserDetail::where('user_id', $auth->id)->first();

        if (! $details) {

            return response()->json([
                'status'       => 'profile_not_started',
                'current_step' => 1,
                'next_action'  => 'start_onboarding',
                'message'      => 'Start your dating profile.',
            ]);
        }

        if (! $details->profile_completed) {
            $currentStep = $details->onboarding_step ?? 1;

            return response()->json([
                'status'       => 'profile_incomplete',
                'current_step' => $currentStep,
                'resume_step'  => min($currentStep + 1, 12),
                'next_action'  => 'complete_profile',
                'message'      => 'Complete your dating profile.',
            ]);
        }

        switch ($details->verification_status) {

            case 'not_uploaded':

                return response()->json([

                    'status'              => 'verification_required',

                    'current_step'        => 12,

                    'next_step'           => 13,

                    'verification_status' => 'not_uploaded',

                    'next_action'         => 'upload_verification',

                    'message'             => 'Please upload verification photos.',

                    "redirect_to_profile" => true,

                ]);

            case 'pending':

                return response()->json([

                    'status'              => 'verification_pending',

                    'current_step'        => 12,

                    'next_step'           => 13,

                    'verification_status' => 'pending',

                    'next_action'         => 'wait',

                    'message'             => 'Your verification is under review.',

                ]);

            case 'rejected':

                return response()->json([

                    'status'              => 'verification_rejected',

                    'current_step'        => 12,

                    'next_step'           => 13,

                    'verification_status' => 'rejected',

                    'next_action'         => 'upload_again',

                    'rejection_reason'    => $details->rejection_reason,

                    'message'             => 'Verification rejected. Upload again.',

                ]);

            case 'approved':

                return response()->json([

                    'status'              => 'approved',

                    'current_step'        => 12,

                    'next_step'           => 13,

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
            'city'              => 'required_if:location_type,manual|nullable|string|max:100',
            'location_type'     => 'sometimes|in:manual,current',
            'latitude'          => 'required|numeric',
            'longitude'         => 'required|numeric',
            'photo1'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo2'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo3'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo4'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo5'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo6'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        $cityData = null;

// Current Location
        if ($request->input('location_type') === 'current') {

            $location = $this->getAddressFromLatLng(
                $request->latitude,
                $request->longitude
            );

            if (! $location || empty($location['display_name'])) {

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unable to detect current location.',
                ], 422);

            }

            $cityData = [
                'address' => $location['display_name'],
                'lat'     => $request->latitude,
                'lng'     => $request->longitude,
            ];

        }
// Manual Location
        else {

            $cityData = [
                'address' => $request->city,
                'lat'     => $request->latitude,
                'lng'     => $request->longitude,
            ];

        }

        $details = UserDetail::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                // Basic
                'display_name'       => $request->display_name,
                'date_of_birth'      => $request->date_of_birth,
                'height'             => $request->height,
                'city'               => $cityData,
                'job_title'          => $request->job_title,
                'education'          => $request->education,
                'languages'          => $request->languages,

                // Dating
                'preference'         => $request->preference,
                'interest'           => $request->interest,
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
                'verified_only' => $request->has('verified_only') ? 1 : 0,
                
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
            $hiddenUsers,
            request('visibility', 'everyone')
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

            // Relationship
            if ($other->relationship_type == $details->relationship_type) {
                $score += 20;
            }

            // Interests
            $myInterests    = $details->interest ?? [];
            $theirInterests = $other->interest ?? [];

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
            'matches' => $matches->map(function ($m) {

                return [
                    'id'                => $m->user->id,
                    'first_name'        => $m->user->first_name,
                    'last_name'         => $m->user->last_name,
                    'image'             => $m->photo1
                        ? asset('storage/' . $m->photo1)
                        : null,
                    'identity'          => $m->identity,
                    'preference'        => $m->preference,
                    'interest'          => $m->interest,
                    'relationship_type' => $m->relationship_type,
                    'UserStatus'        => $m->user->UserStatus,

                    'friendship_status' => $m->user->friendship_status ?? null,
                    'friendship_sender' => $m->user->friendship_sender ?? null,

                    'friend_count'      => $m->user->friend_count ?? 0,

                    'match_score'       => $m->match_score ?? 0,
                ];

            }),
        ]);
    }

    public function viewProfile($id)
    {
        $auth    = Auth::user();
        $blocked = \App\Models\Block::where(function ($q) use ($auth, $id) {

            $q->where('user_id', $auth->id)
                ->where('blocked_id', $id);

        })->orWhere(function ($q) use ($auth, $id) {

            $q->where('user_id', $id)
                ->where('blocked_id', $auth->id);

        })->exists();

        if ($blocked) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Profile not available.',
            ], 403);

        }

        $details = $auth->details;

        if (! $details) {
            return response()->json([
                'status'  => 'error',
                'message' => 'You do not have a dating account.',
            ]);
        }

        $user = User::with('details')
            ->where('id', $id)
            ->whereHas('details')
            ->firstOrFail();

        $profile = $user->details;

        $canMessage    = false;
        $messageReason = null;

        if ($auth->id != $user->id) {

            if ($profile->who_can_message === 'everyone') {

                $canMessage = true;

            } elseif (
                $profile->who_can_message === 'matches_only' &&
                $details->verification_status === 'approved'
            ) {

                $canMessage = true;

            } else {

                $messageReason = 'Only verified users can message this user.';

            }

        }

        if (
            $auth->id != $id &&
            $profile->profile_visibility == 'verified_only' &&
            $details->verification_status != 'approved'
        ) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This profile is visible to verified users only.',
            ], 403);
        }

        $friendship = Friendship::where(function ($q) use ($auth, $id) {
            $q->where('sender_id', $auth->id)->where('receiver_id', $id);
        })->orWhere(function ($q) use ($auth, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $auth->id);
        })->first();

        return response()->json([
            'status'         => 'success',

            'profile'        => [
                // User
                'id'                  => $user->id,
                'first_name'          => $user->first_name,
                'last_name'           => $user->last_name,
                'email'               => $user->email,

                // Basic Info
                'display_name'        => $profile->display_name,
                'date_of_birth'       => $profile->date_of_birth,
                'height'              => $profile->height,
                'city'                => $profile->city,
                'job_title'           => $profile->job_title,
                'education'           => $profile->education,
                'languages'           => $profile->languages,

                // Gender
                'gender'              => $profile->gender,
                'pronouns'            => $profile->pronouns,

                // Dating
                'identity'            => $profile->identity,
                'preference'          => $profile->preference,
                'interest'            => $profile->interest,
                'relationship_type'   => $profile->relationship_type,

                // About
                'bio'                 => $profile->bio,

                // Lifestyle
                'smoking'             => $profile->smoking,
                'drinking'            => $profile->drinking,
                'workout'             => $profile->workout,
                'diet'                => $profile->diet,
                'pets'                => $profile->pets,

                // Privacy
                'profile_visibility'  => $profile->profile_visibility,
                'who_can_message'     => $profile->who_can_message,
                'hide_distance'       => $profile->hide_distance,
                'hide_online_status'  => $profile->hide_online_status,

                // Match Preferences
                'min_age'             => $profile->min_age,
                'max_age'             => $profile->max_age,
                'max_distance'        => $profile->max_distance,
                'verified_only'       => $profile->verified_only,
                'people_with_photos'  => $profile->people_with_photos,
                'similar_interests'   => $profile->similar_interests,

                // Verification
                'verification_status' => $profile->verification_status,
                'verification_method' => $profile->verification_method,
                'verified_at'         => $profile->verified_at,

                // Photos
                'image'               => $profile->photo1
                    ? asset('storage/' . $profile->photo1)
                    : null,

                'photos'              => collect([
                    $profile->photo1,
                    $profile->photo2,
                    $profile->photo3,
                    $profile->photo4,
                    $profile->photo5,
                    $profile->photo6,
                ])->filter()->map(function ($photo) {
                    return asset('storage/' . $photo);
                })->values(),
            ],

            'friendship'     => $friendship,

            'can_message'    => $canMessage,

            'message_reason' => $messageReason,

            'is_own_profile' => $auth->id == $user->id,

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

    public function saveDetails(Request $request)
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
                        'identity'          => 'required|string|in:Man,Woman,Non-binary,Transgender',
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
                        'height'              => [
                            'required',
                            'regex:/^([4-8])\'([0-9]|1[0-1])("?|\'\')?$/',
                        ],
                        'location_type'       => 'required|in:manual,current',
                        'city'                => 'sometimes|nullable|string|max:255',
                        'latitude'            => 'required|numeric',
                        'longitude'           => 'required|numeric',
                        'occupation'          => 'nullable|string|max:100',
                    ]);

                    $details->display_name  = $request->dating_display_name;
                    $details->date_of_birth = $request->dob;
                    $details->height        = $request->height;
                    $address                = $request->city;

                    if ($request->location_type === 'current') {

                        $location = $this->getAddressFromLatLng(
                            $request->latitude,
                            $request->longitude
                        );

                        if (! $location || empty($location['display_name'])) {
                            throw ValidationException::withMessages([
                                'location' => ['Unable to detect current location.'],
                            ]);
                        }

                        $address = $location['display_name'];
                    }

                    $details->city = [
                        'address' => $address,
                        'lat'     => $request->latitude,
                        'lng'     => $request->longitude,
                    ];
                    $details->job_title = $request->occupation;

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

                    $details->interest = $request->interests;

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

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    private function getVisibleProfiles($auth, $details, $hiddenUsers, $visibilityFilter)
    {

        if (request()->filled(['lat', 'lng'])) {

            // Mobile app current location bhej rahi hai
            $myLat = (float) request('lat');
            $myLng = (float) request('lng');

        } else {

            // Fallback to saved city
            $myLocation = $details->city;

            if (
                ! $myLocation ||
                empty($myLocation['lat']) ||
                empty($myLocation['lng'])
            ) {
                return collect();
            }

            $myLat = (float) $myLocation['lat'];
            $myLng = (float) $myLocation['lng'];
        }

        $radius = $details->max_distance ?? 50;

        $query = UserDetail::with('user')
            ->where('user_id', '!=', $auth->id)
            ->whereNotIn('user_id', $hiddenUsers);

        $query->selectRaw("
    user_details.*,

    (
        6371 *
        acos(
            cos(radians(?))
            *
            cos(
                radians(
                    CAST(
                        JSON_UNQUOTE(
                            JSON_EXTRACT(city,'$.lat')
                        ) AS DECIMAL(10,8)
                    )
                )
            )
            *
            cos(
                radians(
                    CAST(
                        JSON_UNQUOTE(
                            JSON_EXTRACT(city,'$.lng')
                        ) AS DECIMAL(11,8)
                    )
                ) - radians(?)
            )
            +
            sin(radians(?))
            *
            sin(
                radians(
                    CAST(
                        JSON_UNQUOTE(
                            JSON_EXTRACT(city,'$.lat')
                        ) AS DECIMAL(10,8)
                    )
                )
            )
        )
    ) AS distance
", [
            $myLat,
            $myLng,
            $myLat,
        ]);

        $query->whereBetween('date_of_birth', [
            now()->subYears($details->max_age)->toDateString(),
            now()->subYears($details->min_age)->toDateString(),
        ]);

        // $query->having('distance', '<=', $radius)
        //     ->orderBy('distance');

        $isVerified = $details->verification_status === 'approved';

        if (! $isVerified) {

            // ===========================
            // CURRENT USER = UNVERIFIED
            // ===========================

            if ($visibilityFilter === 'verified') {

                // Show only verified users who allow everyone
                $query->where('verification_status', 'approved')
                    ->where('profile_visibility', 'everyone');

            } else {

                // Show all unverified
                // + verified users whose visibility = everyone
                $query->where(function ($q) {

                    $q->where('verification_status', '!=', 'approved')

                        ->orWhere(function ($q2) {

                            $q2->where('verification_status', 'approved')
                                ->where('profile_visibility', 'everyone');

                        });

                });

            }

        } else {

            // ===========================
            // CURRENT USER = VERIFIED
            // ===========================

            if ($visibilityFilter === 'verified') {

                $query->where('verification_status', 'approved')
                    ->whereIn('profile_visibility', [
                        'everyone',
                        'verified_only',
                    ]);

            } else {

                $query->where(function ($q) {

                    $q->where('verification_status', '!=', 'approved')

                        ->orWhere(function ($q2) {

                            $q2->where('verification_status', 'approved')
                                ->whereIn('profile_visibility', [
                                    'everyone',
                                    'verified_only',
                                ]);

                        });

                });
            }
        }

        if ($details->similar_interests) {

            $myInterests = $details->interest ?? [];

            if (! empty($myInterests)) {

                $query->where(function ($q) use ($myInterests) {

                    foreach ($myInterests as $interest) {
                        $q->orWhereJsonContains('interest', $interest);
                    }

                });

            }
        }

        if ($details->verified_only) {
            $query->where('verification_status', 'approved');
        }

        $query->having('distance', '<=', $radius)
            ->orderBy('distance');

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

        $details = UserDetail::where('user_id', $auth->id)->first();

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
            'verify_method' => 'required|in:selfie,id',

            'selfie_file'   => [
                'required_if:verify_method,selfie',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],

            'id_file'       => [
                'required_if:verify_method,id',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
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

        if ($request->verify_method === 'selfie') {

            $path = $request->file('selfie_file')
                ->store('verification/selfies', 'public');

            $details->verification_selfie = $path;
            $details->verification_id     = null;
        }

        if ($request->verify_method === 'id') {

            $path = $request->file('id_file')
                ->store('verification/ids', 'public');

            $details->verification_id     = $path;
            $details->verification_selfie = null;
        }

        $details->verification_method = $request->verify_method;
        $details->verification_status = 'pending';
        $details->rejection_reason    = null;
        $details->save();

        Mail::to($auth->email)
            ->send(new \App\Mail\PendingVerificationMail($auth));

        return response()->json([
            'status'              => 'success',
            'verification_status' => 'pending',
            'message'             => 'Verification submitted successfully. Waiting for approval.',
        ]);
    }

    private function getAddressFromLatLng($lat, $lng)
    {
        $apiKey = env('LOCATIONIQ_KEY');

        $response = \Http::get("https://us1.locationiq.com/v1/reverse.php", [
            'key'    => $apiKey,
            'lat'    => $lat,
            'lon'    => $lng,
            'format' => 'json',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function geocode(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
        ]);

        $response = \Http::get('https://us1.locationiq.com/v1/search.php', [
            'key'    => config('services.locationiq.key'),
            'q'      => $request->address,
            'format' => 'json',
            'limit'  => 1,
        ]);

        if (! $response->successful() || empty($response[0])) {

            return response()->json([
                'success' => false,
                'message' => 'Location not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'address' => $response[0]['display_name'],
            'lat'     => $response[0]['lat'],
            'lng'     => $response[0]['lon'],
        ]);
    }

    public function matchesLocation(Request $request)
    {
        $auth = Auth::user();

        $details = UserDetail::where('user_id', $auth->id)
            ->first();

        if (! $details) {

            return response()->json([
                'success' => false,
                'message' => 'Dating profile not found',
            ], 404);

        }

        if ($request->filled(['lat', 'lng'])) {

            $details->temp_lat = $request->lat;
            $details->temp_lng = $request->lng;

        }

        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(
            array_merge(
                $blockedUsers,
                $blockedByUsers
            )
        );

        $matches = $this->getVisibleProfiles(
            $auth,
            $details,
            $hiddenUsers,
            $request->visibility ?? 'everyone'
        );

        return response()->json([
            'success' => true,
            'matches' => $matches->map(function ($m) {

                return [
                    'id'                => $m->user->id,
                    'first_name'        => $m->user->first_name,
                    'last_name'         => $m->user->last_name,
                    'image'             => $m->photo1
                        ? asset('storage/' . $m->photo1)
                        : null,
                    'identity'          => $m->identity,
                    'preference'        => $m->preference,
                    'interest'          => $m->interest,
                    'relationship_type' => $m->relationship_type,
                ];

            }),
        ]);

    }
}
