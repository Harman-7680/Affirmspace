<?php
namespace App\Http\Controllers;

use App\Mail\ContactAdminMail;
use App\Mail\VerificationRejectedMail;
use App\Models\Comment;
use App\Models\CounselorAvailability;
use App\Models\Event;
use App\Models\Friendship;
use App\Models\Like;
use App\Models\Message;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Status;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        abort_if(Auth::user()->role != 2, 403, 'Unauthorized access');

        $totalUsers       = User::where('role', '0')->count();
        $totalCounselors  = User::where('role', '1')->count();
        $totalPosts       = Post::count();
        $totalComments    = Comment::count();
        $totalLikes       = Like::count();
        $totalStatuses    = Status::count();
        $totalFriendships = Friendship::count();
        $totalRatings     = Rating::count();
        $totalEvents      = Event::count();

        return view('admin.index', compact(
            'totalUsers',
            'totalCounselors',
            'totalPosts',
            'totalComments',
            'totalLikes',
            'totalStatuses',
            'totalFriendships',
            'totalRatings',
            'totalEvents'
        ));
    }

    public function counselee(Request $request)
    {
        abort_if(Auth::user()->role != 2, 403, 'Unauthorized access');

        $totalUsers       = User::where('role', '0')->count();
        $totalCounselors  = User::where('role', '1')->count();
        $totalPosts       = Post::count();
        $totalComments    = Comment::count();
        $totalLikes       = Like::count();
        $totalStatuses    = Status::count();
        $totalFriendships = Friendship::count();
        $totalRatings     = Rating::count();

        $users = User::where('role', 0)->get()->map(function ($u) {
            // Friend count (accepted friendships)
            $sentFriends     = $u->sentFriendships()->where('status', 'accepted')->count();
            $receivedFriends = $u->receivedFriendships()->where('status', 'accepted')->count();
            $friend_count    = $sentFriends + $receivedFriends;

            // Referral count (how many users used this user's refer_code)
            $referral_count = User::where('referred_by', $u->id)->count();
            $report_count   = \App\Models\Report::where('reported_user_id', $u->id)->count();

            $post_report_count = \App\Models\Report::whereIn(
                'post_id',
                Post::where('user_id', $u->id)->pluck('id')
            )->count();

            return [
                'id'                => $u->id,
                'first_name'        => $u->first_name,
                'last_name'         => $u->last_name,
                'email'             => $u->email,
                'gender'            => $u->gender,
                'is_paid'           => (bool) $u->is_paid,
                'payment_id'        => $u->payment_id,
                'created_at'        => $u->created_at->format('d M Y'),
                'image'             => $u->image ? asset('storage/' . $u->image) : asset('images/avatars/avatar-1.jpg'),
                'last_seen_human'   => $u->last_seen ? $u->last_seen->diffForHumans() : 'Never',
                'is_online'         => $u->isOnline(),
                'status'            => $u->status,
                'UserStatus'        => $u->UserStatus,
                'friend_count'      => $friend_count,
                'referral_count'    => $referral_count,
                'report_count'      => $report_count,
                'post_report_count' => $post_report_count,
            ];
        });

        return view('admin.counselee', compact(
            'totalCounselors',
            'totalPosts',
            'totalComments',
            'totalLikes',
            'totalStatuses',
            'totalFriendships',
            'totalRatings',
            'users'
        ));
    }

    public function counselor(Request $request)
    {
        abort_if(Auth::user()->role != 2, 403, 'Unauthorized access');

        $totalUsers       = User::where('role', '0')->count();
        $totalCounselors  = User::where('role', '1')->count();
        $totalPosts       = Post::count();
        $totalComments    = Comment::count();
        $totalLikes       = Like::count();
        $totalStatuses    = Status::count();
        $totalFriendships = Friendship::count();
        $totalRatings     = Rating::count();

        $users = User::where('role', 1)->get()->map(function ($u) {
            return [
                'id'                    => $u->id,
                'first_name'            => $u->first_name,
                'last_name'             => $u->last_name,
                'bio'                   => $u->bio,
                'email'                 => $u->email,
                'gender'                => $u->gender,
                'is_paid'               => (bool) $u->is_paid,
                'payment_id'            => $u->payment_id,
                'razorpay_account_id'   => $u->razorpay_account_id,
                'bank_status'           => $u->bank_status,
                'bank_rejection_reason' => $u->bank_rejection_reason,
                'created_at'            => $u->created_at->format('d M Y'),
                'image'                 => $u->image ? asset('storage/' . $u->image) : asset('images/avatars/avatar-1.jpg'),
                'last_seen_human'       => $u->last_seen ? $u->last_seen->diffForHumans() : 'Never',
                'is_online'             => $u->isOnline(),
                'status'                => $u->status,
            ];
        });

        return view('admin.counselor', compact(
            'totalUsers',
            'totalCounselors',
            'totalPosts',
            'totalComments',
            'totalLikes',
            'totalStatuses',
            'totalFriendships',
            'totalRatings',
            'users'
        ));
    }

    public function toggleStatus($id)
    {
        $user         = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return response()->json([
            'success'    => true,
            'new_status' => $user->status,
        ]);
    }

    public function toggleStatusUser($id)
    {
        $user             = \App\Models\User::findOrFail($id);
        $user->UserStatus = $user->UserStatus == 0 ? 1 : 0;
        $user->save();

        return response()->json([
            'success'    => true,
            'new_status' => $user->UserStatus,
        ]);
    }

    public function userPosts($id)
    {
        abort_if(Auth::user()->role != 2, 403, 'Unauthorized access');

        $totalUsers       = User::where('role', '0')->count();
        $totalCounselors  = User::where('role', '1')->count();
        $totalPosts       = Post::count();
        $totalComments    = Comment::count();
        $totalLikes       = Like::count();
        $totalStatuses    = Status::count();
        $totalFriendships = Friendship::count();
        $totalRatings     = Rating::count();
        $user             = User::findOrFail($id);
        $posts            = Post::where('user_id', $id)->get();
        // dd($posts);
        // die;

        return view('admin.user-posts', compact(
            'totalUsers',
            'totalCounselors',
            'totalPosts',
            'totalComments',
            'totalLikes',
            'totalStatuses',
            'totalFriendships',
            'totalRatings',
            'user',
            'posts'
        ));
    }

    public function show($id)
    {
        abort_if(Auth::user()->role != 2, 403, 'Unauthorized access');

        $user = \App\Models\User::findOrFail($id);

        $posts = \App\Models\Post::with(['user', 'comments.user', 'likes'])
            ->withCount(['likes', 'comments'])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $auth          = Auth::user();
        $notifications = $auth->unreadNotifications;

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

        // dd($friendList, $friends);die;

        $followersCount = $friendList->count();
        return view('admin.user_profile', [
            'userProfile'    => $user,
            'posts'          => $posts,
            'notifications'  => $notifications,
            'followersCount' => $followersCount,
            'followers'      => $friendList,
        ]);
    }

    public function show_counselor($id)
    {
        abort_if(Auth::user()->role != 2, 403, 'Unauthorized access');

        $notifications = Auth::user()->unreadNotifications;
        $user          = User::where('role', 1)->findOrFail($id);

        $averageRating = $user->ratingsReceived()->avg('rating');
        $totalReviews  = $user->ratingsReceived()->count();

        // Get all availability IDs for this counselor
        $availabilityIds = CounselorAvailability::where('counselor_id', $id)->pluck('id');

        // Get all messages linked to those availabilities
        $appointments = Message::with('availability')
            ->whereIn('availability_id', $availabilityIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.counselor_profile', [
            'user'          => $user,
            'notifications' => $notifications,
            'averageRating' => $averageRating,
            'totalReviews'  => $totalReviews,
            'appointments'  => $appointments,
        ]);
    }

    public function index()
    {
        // Only allow admin (role = 2)
        abort_if(Auth::user()->role != 2, 403, 'Unauthorized access');

        // Load paid events and include the user who created each event
        $events = Event::with('user')
            ->latest()
            ->get()
            ->map(function ($event) {
                $event->is_paid   = (bool) $event->is_paid;
                $event->image_url = $event->image
                    ? asset('storage/' . $event->image)
                    : null;
                return $event;
            });

        // Add unread notifications for admin
        $notifications = Auth::user()->unreadNotifications;

        return view('admin.events.index', compact('events', 'notifications'));
    }

    public function approve($id)
    {
        $event         = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();

        Mail::send('emails.event_approved', ['event' => $event, 'user' => $event->user], function ($message) use ($event) {
            $message->to($event->user->email)
                ->subject(" Event Approved: {$event->name}");
        });

        return back()->with('success', 'Event approved and email sent successfully!');
    }

    public function reject($id)
    {
        $event         = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        Mail::send('emails.event_rejected', ['event' => $event, 'user' => $event->user], function ($message) use ($event) {
            $message->to($event->user->email)
                ->subject("Event Rejected: {$event->name}");
        });

        return back()->with('error', 'Event rejected and email sent successfully!');
    }

    public function verificationList()
    {
        $users         = UserDetail::with('user')->get();
        $notifications = Auth::user()->unreadNotifications;

        return view('admin.verify-user', compact('users', 'notifications'));
    }

    public function approveVerification($id)
    {
        $details = UserDetail::findOrFail($id);

        // GET USER (important)
        $user = $details->user;

        // Update status
        $details->verification_status = 'approved';
        $details->save();

        // Send email
        Mail::to($user->email)->send(new \App\Mail\VerificationApprovedMail($user));

        return back()->with('success', 'Verification Approved Successfully');
    }

    public function rejectVerification($id)
    {
        $details = UserDetail::findOrFail($id);
        $user    = $details->user;

        // optional reason
        $reason = request()->input('rejection_reason') ?? null;

        // Send email
        Mail::to($user->email)->send(new VerificationRejectedMail($user, $reason));

        // Update verification status only
        $details->verification_status = 'rejected';
        $details->save();

        return back()->with('error', 'User verification rejected successfully.');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $adminEmail = 'admin@gmail.com';

        Mail::to($adminEmail)->send(new ContactAdminMail($validated));

        // If request comes from MOBILE APP (API)
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => true,
                'message' => 'Your message has been sent successfully.',
            ], 200);
        }

        // If request comes from WEBSITE (Web form)
        return back()->with('success', 'Your message has been sent successfully.');
    }

    public function contactWithAdmin(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $adminEmail = 'admin@gmail.com';

        Mail::to($adminEmail)->send(new ContactAdminMail($validated));

        // If request comes from MOBILE APP (API)
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => true,
                'message' => 'Your message has been sent successfully.',
            ], 200);
        }

        // If request comes from WEBSITE (Web form)
        return back()->with('success', 'Your message has been sent successfully.');
    }

    public function releasePayment($id)
    {
        abort_if(Auth::user()->role != 2, 403);

        $appointment = Message::findOrFail($id);

        if ($appointment->payment_status !== 'paid') {
            return back()->with('error', 'Payment not completed.');
        }

        if ($appointment->release_status) {
            return back()->with('error', 'Already released.');
        }

        // Future me yaha Razorpay transfer API call lagegi

        $appointment->update([
            'release_status'       => true,
            'released_at'          => now(),
            'razorpay_transfer_id' => 'temp_transfer_id_' . rand(10000, 99999),
        ]);

        return back()->with('success', 'Payment released successfully!');
    }
}
