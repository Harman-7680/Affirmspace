<?php
namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Friendship;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DatingController extends Controller
{
    public function pages()
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;
        $details       = UserDetail::firstOrCreate(
            ['user_id' => $auth->id],
            [
                'onboarding_step'     => 1,
                'profile_completed'   => false,
                'verification_status' => 'not_uploaded',
            ]
        );

        $visibilityFilter = request('visibility', 'everyone');

        // Onboarding not completed
        if (! $details->profile_completed) {

            return view('user.dating.pages', [
                'user'          => $auth,
                'auth'          => $auth,
                'notifications' => $notifications,
                'details'       => $details,
            ]);
        }

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

        $allUsers = $this->getVisibleProfiles(
            $auth,
            $details,
            $hiddenUsers,
            $visibilityFilter
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

            // Relationship match
            if ($other->relationship_type == $details->relationship_type) {
                $score += 20;
            }

            // Interest match
            $myInterests    = $details->interest ?? [];
            $theirInterests = $other->interest ?? [];

            $common = count(
                array_intersect(
                    $myInterests ?? [],
                    $theirInterests ?? []
                )
            );

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

                $other->match_score = $score;

                $matches->push($other);
            }
        }

        $matches = $matches
            ->sortByDesc('match_score')
            ->take(50)
            ->values();

        if (request()->ajax()) {

            $data = $matches->map(function ($m) use ($auth) {

                $friendship = Friendship::where(function ($q) use ($auth, $m) {

                    $q->where('sender_id', $auth->id)
                        ->where('receiver_id', $m->user_id);

                })->orWhere(function ($q) use ($auth, $m) {

                    $q->where('sender_id', $m->user_id)
                        ->where('receiver_id', $auth->id);

                })->first();

                // Skip accepted & pending
                if ($friendship && in_array($friendship->status, ['accepted', 'pending'])) {
                    return null;
                }

                return [
                    'id'                => $m->user->id,
                    'first_name'        => $m->user->first_name,
                    'last_name'         => $m->user->last_name,
                    'image'             => $m->user->details?->photo1,
                    'identity'          => $m->identity,
                    'preference'        => $m->preference,
                    'interest'          => $m->interest,
                    'relationship_type' => $m->relationship_type,
                    'UserStatus'        => $m->user->UserStatus,

                    'friendship_status' => $friendship?->status,
                    'friendship_sender' => $friendship?->sender_id,

                    'friend_count'      => Friendship::where(function ($q) use ($m) {

                        $q->where('sender_id', $m->user->id)
                            ->orWhere('receiver_id', $m->user->id);

                    })
                        ->where('status', 'accepted')
                        ->count(),
                ];

            })
                ->filter()
                ->values();

            return response()->json([
                'matches' => $data,
            ]);
        }

        return view('user.dating.pages-matches', [
            'user'             => $auth,
            'notifications'    => $notifications,
            'matches'          => $matches,
            'details'          => $details,
            'visibilityFilter' => $visibilityFilter,
        ]);
    }

    private function getVisibleProfiles($auth, $details, $hiddenUsers, $visibilityFilter)
    {

        $currentLocation = session('current_location');

        if ($currentLocation) {

            // User ne browser location allow ki
            $myLat = (float) $currentLocation['lat'];
            $myLng = (float) $currentLocation['lng'];

        } else {

            // User ne location allow nahi ki
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

    public function updateDetails(Request $request)
    {
        $request->validate([
            'preference'        => 'required|string',
            'interest'          => 'required|array|min:1',
            'interest.*'        => 'string|max:50',
            'relationship_type' => 'required|string',
            'bio'               => 'nullable|string|max:300',
            'city'              => 'sometimes|nullable|string|max:255',
            'location_type'     => 'sometimes|in:manual,current',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',

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
                return back()->with('error', 'Unable to detect current location.');
            }

            $cityData = [
                'address' => $location['display_name'],
                'lat'     => $request->latitude,
                'lng'     => $request->longitude,
            ];

        }
// Manual
        elseif ($request->input('location_type') === 'manual') {

            $cityData = [
                'address' => $request->city,
                'lat'     => $request->latitude,
                'lng'     => $request->longitude,
            ];

        }
// Old Manual (fallback)
        else {

            $response = Http::get('https://us1.locationiq.com/v1/search.php', [
                'key'    => config('services.locationiq.key'),
                'q'      => $request->city,
                'format' => 'json',
                'limit'  => 1,
            ]);

            if ($response->successful() && ! empty($response[0])) {

                $cityData = [
                    'address' => $response[0]['display_name'],
                    'lat'     => $response[0]['lat'],
                    'lng'     => $response[0]['lon'],
                ];

            }

        }

        if (! $cityData) {
            return back()->with('error', 'City location not found');
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

        return back()->with(
            'success',
            'Dating profile updated successfully.'
        );
    }

    public function datingProfile($id)
    {
        $auth = Auth::user();

        abort_if($auth->role != 0, 403);

        $notifications = $auth->unreadNotifications;

        // Logged in user dating details
        $myDetails = UserDetail::where('user_id', $auth->id)->first();

        if (! $myDetails) {
            return redirect()->route('pages')
                ->with('error', 'Please complete your dating profile first.');
        }

        // Check if either user has blocked the other
        $blocked = Block::where(function ($q) use ($auth, $id) {
            $q->where('user_id', $auth->id)
                ->where('blocked_id', $id);
        })->orWhere(function ($q) use ($auth, $id) {
            $q->where('user_id', $id)
                ->where('blocked_id', $auth->id);
        })->exists();

        if ($blocked) {
            return redirect()->route('pages')
                ->with('error', 'This profile is not available.');
        }

        // Load dating profile
        $user = User::with('details')
            ->where('id', $id)
            ->whereHas('details')
            ->first();

        if (! $user) {
            return redirect()->route('pages')
                ->with('error', 'Profile not found.');
        }

        // Verified only profile check
        if (
            $auth->id != $user->id &&
            $user->details->profile_visibility == 'verified_only' &&
            $myDetails->verification_status != 'approved'
        ) {
            return redirect()->route('pages')
                ->with('error', 'This profile is visible to verified users only.');
        }

        // Friendship status
        $friendship = Friendship::where(function ($q) use ($auth, $id) {
            $q->where('sender_id', $auth->id)
                ->where('receiver_id', $id);
        })->orWhere(function ($q) use ($auth, $id) {
            $q->where('sender_id', $id)
                ->where('receiver_id', $auth->id);
        })->first();

        return view('user.dating.dating-profile', [
            'user'          => $user,
            'details'       => $user->details,
            'friendship'    => $friendship,
            'notifications' => $notifications,
        ]);
    }

    public function destroy()
    {
        $user = Auth::user();

        $details = UserDetail::where('user_id', $user->id)
            ->first();

        if ($details) {

            foreach (['photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'verification_selfie', 'verification_id'] as $photo) {
                if ($details->$photo) {
                    Storage::disk('public')
                        ->delete($details->$photo);
                }
            }

            $details->delete();

        }

        return redirect('/feed')
            ->with(
                'success',
                'Dating profile deleted successfully.'
            );
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
                        'city'                => 'required|string|max:100',
                        'latitude'            => 'nullable|numeric',
                        'longitude'           => 'nullable|numeric',
                        'location_type'       => 'required|in:manual,current',
                        'job_title'           => 'nullable|string|max:100',
                    ]);

                    $details->display_name  = $request->dating_display_name;
                    $details->date_of_birth = $request->dob;
                    $details->height        = $request->height;
                    $details->city          = [
                        'address' => $request->city,
                        'lat'     => $request->latitude,
                        'lng'     => $request->longitude,
                    ];
                    $details->job_title = $request->job_title;
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

            $nextStep = min((int) $request->step + 1, 12);

            $details->onboarding_step = max(
                $details->onboarding_step ?? 0,
                $nextStep
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

    public function verificationPage()
    {
        $user = Auth::user();

        abort_if($user->role != 0, 403, 'Unauthorized access');

        $notifications = $user->unreadNotifications;

        $userDetail = UserDetail::firstOrCreate(
            ['user_id' => $user->id],
            [
                'verification_status' => 'not_uploaded',
            ]
        );

        // Pending
        if ($userDetail->verification_status == 'pending') {
            return view('user.dating.verification-waiting', compact('userDetail', 'notifications'));
        }

        // Approved
        if ($userDetail->verification_status == 'approved') {

            // apna dating dashboard/profile route
            return redirect()->route('dating.profile', Auth::id());
        }

        // Rejected
        if ($userDetail->verification_status == 'rejected') {

            return view('user.dating.upload-photos', compact('userDetail', 'notifications'));
        }

        // Not Uploaded
        return view('user.dating.upload-photos', compact('userDetail', 'notifications'));
    }

    public function submitVerification(Request $request)
    {
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

        $user = Auth::user();

        $detail = UserDetail::where('user_id', $user->id)->firstOrFail();

        // Selfie Verification
        if ($request->verify_method == 'selfie') {

            $path = $request->file('selfie_file')
                ->store('verification/selfies', 'public');

            $detail->verification_selfie = $path;
            $detail->verification_id     = null;
        }

        // ID Verification
        if ($request->verify_method == 'id') {

            $path = $request->file('id_file')
                ->store('verification/ids', 'public');

            $detail->verification_id     = $path;
            $detail->verification_selfie = null;
        }

        $detail->verification_method = $request->verify_method;
        $detail->verification_status = 'pending';
        $detail->rejection_reason    = null;

        $detail->save();

        Mail::to($user->email)->send(new \App\Mail\PendingVerificationMail($user));

        return response()->json([
            'success' => true,
            'message' => 'Verification submitted successfully.',
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

        $response = Http::get('https://us1.locationiq.com/v1/search.php', [
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

        if ($request->filled(['lat', 'lng'])) {

            // Browser location allow
            session([
                'current_location' => [
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                ],
            ]);

        } else {

            // Browser location denied
            session()->forget('current_location');

        }

        $details = UserDetail::where('user_id', $auth->id)
            ->first();

        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(
            array_merge($blockedUsers, $blockedByUsers)
        );

        $visibilityFilter = $request->visibility ?? 'everyone';

        $matches = $this->getVisibleProfiles(
            $auth,
            $details,
            $hiddenUsers,
            $visibilityFilter
        );

        return response()->json([
            'success' => true,
            'matches' => $matches->map(function ($m) {

                return [
                    'id'                => $m->user->id,
                    'first_name'        => $m->user->first_name,
                    'last_name'         => $m->user->last_name,
                    'image'             => $m->photo1,
                    'identity'          => $m->identity,
                    'preference'        => $m->preference,
                    'interest'          => $m->interest,
                    'relationship_type' => $m->relationship_type,
                    'UserStatus'        => $m->user->UserStatus,
                    'friendship_status' => null,
                    'friendship_sender' => null,
                    'friend_count'      => 0,
                ];

            }),
        ]);
    }
}
