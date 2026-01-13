<?php
namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\CounselorAvailability;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\Post;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CounselorController extends Controller
{
    public function profile()
    {
        abort_if(Auth::user()->role != 1, 403, 'Unauthorized access');
        $counselor = Auth::user();

        // Notifications
        $notifications = $counselor->unreadNotifications;

        // Availabilities (future dates only)
        $counselor->load(['availabilities' => function ($query) {
            $query->where('available_date', '>=', now()->toDateString())
                ->orderBy('available_date')
                ->orderBy('start_time');
        }]);

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        // Ratings
        $averageRating = $counselor->ratingsReceived()->avg('rating');
        $totalReviews  = $counselor->ratingsReceived()->count();
                                                       // Friend count (optional)
        $friendCount = $counselor->friends()->count(); // Ensure you have a friends() relation

        return view('counselor.profile1', [
            'message'       => $messages,
            'user'          => $counselor,
            'notifications' => $notifications,
            'averageRating' => round($averageRating ?? 0, 1),
            'totalReviews'  => $totalReviews,
            'friendCount'   => $friendCount,
        ]);
    }

    public function counseler()
    {
        abort_if(Auth::user()->role != 1, 403, 'Unauthorized access');
        $auth = Auth::user();

        $availabilities = $auth->availabilities()
            ->where('available_date', '>=', now()->toDateString())
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        $notifications = $auth->unreadNotifications;

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        $appointments = Message::with('availability')
            ->where(function ($query) use ($auth) {
                $query->where('sender_id', $auth->id)
                    ->orWhere('receiver_id', $auth->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($appointments,$messages,$availabilities);

        return view('counselor.counseler', [
            'user'           => $auth,
            'notifications'  => $notifications,
            'message'        => $messages,
            'availabilities' => $availabilities,
            'appointments'   => $appointments,
        ]);
    }

    public function show($id)
    {
        $notifications = Auth::user()->unreadNotifications;

        $user = User::where('role', 1)
            ->with(['availabilities' => function ($query) {
                $query->where('available_date', '>=', now()->toDateString())
                    ->orderBy('available_date')
                    ->orderBy('start_time');
            }])
            ->findOrFail($id);

        $averageRating = $user->ratingsReceived()->avg('rating');
        $totalReviews  = $user->ratingsReceived()->count();

        // Fetch the actual reviews to display
        $reviews = $user->ratingsReceived()->with('user')->get();

        return view('counselor.profile', [
            'user'          => $user,
            'notifications' => $notifications,
            'averageRating' => round($averageRating ?? 0, 1),
            'totalReviews'  => $totalReviews,
            'reviews'       => $reviews,
        ]);
    }

    public function contact(Request $request, $id)
    {
        $request->validate(
            [
                'subject'         => 'required|string|max:255',
                'message'         => 'required|string',
                'email'           => 'required|email',
                'availability_id' => 'required|exists:counselor_availabilities,id',
            ],
            [
                'availability_id.required' => 'Please select counselor availability.',
                'availability_id.exists'   => 'Selected availability is not valid or no longer available.',
            ]
        );

        $availability = CounselorAvailability::findOrFail($request->availability_id);

        // $alreadyBooked = Message::where('sender_id', auth()->id())
        //     ->where('availability_id', $request->availability_id)
        //     ->exists();

        // if ($alreadyBooked) {
        //     return back()->with('success', 'You already booked this appointment!');
        // }

        $booking = Message::where('sender_id', auth()->id())
            ->where('availability_id', $request->availability_id)
            ->first();

        if ($booking) {

            // If booking is still pending
            if ($booking->status === 'pending') {
                return back()->with('success', 'Your appointment request is pending approval.');
            }

            // If booking already approved
            if ($booking->status === 'approved') {
                return back()->with('success', 'You have already booked this appointment.');
            }
        }

        Message::create([
            'sender_id'       => auth()->id(),
            'receiver_id'     => $id,
            'subject'         => $request->subject,
            'email'           => $request->email,
            'message_body'    => $request->message,
            'availability_id' => $request->availability_id,
        ]);

        // email logic
        $messageModel = Message::create([
            'sender_id'       => auth()->id(),
            'receiver_id'     => $id,
            'subject'         => $request->subject,
            'email'           => $request->email,
            'message_body'    => $request->message,
            'availability_id' => $request->availability_id,
        ]);

        $counselor = User::findOrFail($id);
        $sender    = auth()->user();

        Mail::send('emails.new_appointment', [
            'counselor'    => $counselor,
            'sender'       => $sender,
            'subject'      => $request->subject,
            'messageBody'  => $request->message,
            'availability' => $availability,
        ], function ($mail) use ($counselor) {
            $mail->to($counselor->email)
                ->subject('You have a new appointment request');
        });

        return back()->with('success', 'Message sent successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating'       => 'required|integer|min:1|max:5',
            'review'       => 'nullable|string',
            'counselor_id' => 'required|exists:users,id',
        ]);

        // Prevent duplicate ratings
        $existing = Rating::where('user_id', auth()->id())
            ->where('counselor_id', $request->counselor_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You already rated this counselor.');
        }

        Rating::create([
            'user_id'      => auth()->id(),
            'counselor_id' => $request->counselor_id,
            'rating'       => $request->rating,
            'review'       => $request->review,
        ]);
        return back()->with('success', 'Rating submitted!');
    }

    public function showUserProfile($id)
    {
        abort_if(Auth::user()->role != 1, 403, 'Unauthorized access');
        // Get selected user
        $user = User::findOrFail($id);

        // Load posts with comments, replies, likes
        $posts = Post::with([
            'user',
            'likes',
            'comments' => function ($q) {
                $q->whereNull('parent_id')
                    ->with([
                        'user',
                        'replies' => function ($r) {
                            $r->with('user'); // reply user
                        },
                    ]);
            },
        ])
            ->withCount(['likes', 'comments'])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Logged in counselor
        $auth = Auth::user();

        // Notifications (optional)
        $notifications = $auth->unreadNotifications;

        // Friends (followers)
        $friends = Friendship::where(function ($query) use ($id) {
            $query->where('sender_id', $id)
                ->orWhere('receiver_id', $id);
        })
            ->where('status', 'accepted')
            ->with(['sender', 'receiver'])
            ->get();

        $friendList = $friends->map(function ($friendship) use ($id) {
            return $friendship->sender_id == $id
                ? $friendship->receiver
                : $friendship->sender;
        });

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        $followersCount = $friendList->count();

        $isPrivate = $user->is_private ?? 0;

        return view('counselor.user_profile', [
            'userProfile'    => $user,
            'message'        => $messages,
            'isPrivate'      => $isPrivate,
            'posts'          => $posts,
            'notifications'  => $notifications,
            'followersCount' => $followersCount,
            'followers'      => $friendList,
        ]);
    }

    public function messages($user_id = null)
    {
        // abort_if(auth()->user()->role !== 1, 403);

        $counselor     = auth()->user();
        $notifications = $counselor->unreadNotifications;

        /* ---------------- ACCEPTED APPOINTMENTS ---------------- */
        $appointmentUserIds = Message::where('receiver_id', $counselor->id)
            ->where('status', 'accepted')
            ->pluck('sender_id')
            ->unique()
            ->values();

        /* ---------------- BLOCKS ---------------- */
        $blockedUsers = Block::where('user_id', $counselor->id)
            ->pluck('blocked_id');

        $blockedByUsers = Block::where('blocked_id', $counselor->id)
            ->pluck('user_id');

        $hiddenUsers = $blockedUsers
            ->merge($blockedByUsers)
            ->unique()
            ->values();

        $appointmentUserIds = $appointmentUserIds->diff($hiddenUsers);

        /* ---------------- COUNSELEE LIST ---------------- */
        $appointments = User::whereIn('id', $appointmentUserIds)
            ->where('role', 0) // counselee
            ->get();

        /* ---------------- RECEIVER CHECK ---------------- */
        $receiver = null;
        if ($user_id) {
            $isAllowed = Message::where('receiver_id', $counselor->id)
                ->where('sender_id', $user_id)
                ->where('status', 'accepted')
                ->exists();

            abort_if(! $isAllowed, 403);

            $receiver = User::findOrFail($user_id);
        }
        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
        // ->take(4) // only latest 4
            ->get();

        return view('counselor.messages', [
            'appointments'  => $appointments,
            'receiver'      => $receiver,
            'notifications' => $notifications,
            'message'       => $messages,
            'hiddenUsers'   => $hiddenUsers,
        ]);
    }

    public function contactus()
    {
        // abort_if(auth()->user()->role !== 1, 403);

        $counselor     = auth()->user();
        $notifications = $counselor->unreadNotifications;

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        return view('counselor.contact-us', [
            'user'          => $counselor,
            'notifications' => $notifications,
            'message'       => $messages,
        ]);
    }
}
