<?php
namespace App\Http\Controllers;

use App\Mail\ReportNotification;
use App\Models\Block;
use App\Models\Bookmark;
use App\Models\Report;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostActionController extends Controller
{
    public function blockUser(Request $request)
    {
        $authId    = Auth::id();
        $blockedId = $request->blocked_id;

        // Check if already blocked
        $alreadyBlocked = \App\Models\Block::where('user_id', $authId)
            ->where('blocked_id', $blockedId)
            ->exists();

        if ($alreadyBlocked) {
            return response()->json(['status' => 'info', 'message' => 'User already blocked']);
        }

        // Create block record
        \App\Models\Block::create([
            'user_id'    => $authId,
            'blocked_id' => $blockedId,
        ]);

        // Remove friendship if exists (both directions) as per need
        \App\Models\Friendship::where(function ($query) use ($authId, $blockedId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $blockedId);
        })
            ->orWhere(function ($query) use ($authId, $blockedId) {
                $query->where('sender_id', $blockedId)
                    ->where('receiver_id', $authId);
            })
            ->delete();

        return response()->json(['status' => 'success', 'message' => 'User blocked Successfully.']);
    }

    public function blockPost(Request $request)
    {
        Block::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Post blocked successfully']);
    }

    public function reportPost(Request $request)
    {
        // Create the report
        $report = Report::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'reason'  => $request->reason ?? 'Spam',
        ]);

        // Reporter details
        $reporter = Auth::user();

        // Get the post owner (the user who uploaded the post)
        $post      = \App\Models\Post::find($request->post_id);
        $postOwner = $post ? $post->user : null;

        $reportData = [
            'reporter_id'         => $reporter->id,
            'reporter_name'       => $reporter->first_name,
            'reporter_email'      => $reporter->email,
            'reported_user_id'    => $postOwner->id ?? null,
            'reported_user_name'  => $postOwner->first_name ?? 'N/A',
            'reported_user_email' => $postOwner->email ?? 'N/A',
            'post_id'             => $request->post_id,
            'reason'              => $request->reason ?? 'Spam',
        ];

        Mail::to('admin@gmail.com')->send(new ReportNotification($reportData));

        return response()->json(['status' => 'success', 'message' => 'Post reported']);
    }

    public function reportUser(Request $request)
    {
        $report = Report::create([
            'user_id'          => Auth::id(),
            'reported_user_id' => $request->reported_user_id,
            'reason'           => $request->reason ?? 'Abuse',
        ]);

        $reporter     = Auth::user();
        $reportedUser = User::find($request->reported_user_id);

        $reportData = [
            'reporter_id'         => $reporter->id,
            'reporter_name'       => $reporter->first_name,
            'reporter_email'      => $reporter->email,
            'reported_user_id'    => $reportedUser->id ?? null,
            'reported_user_name'  => $reportedUser->first_name ?? 'N/A',
            'reported_user_email' => $reportedUser->email ?? 'N/A',
            'post_id'             => null,
            'reason'              => $request->reason ?? 'Abuse',
        ];

        Mail::to('admin@gmail.com')->send(new ReportNotification($reportData));

        return response()->json(['status' => 'success', 'message' => 'User reported']);
    }

    public function bookmark(Request $request)
    {
        $exists = Bookmark::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->first();

        if ($exists) {
            $exists->delete();
            return response()->json(['status' => 'removed']);
        }

        Bookmark::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        return response()->json(['status' => 'added']);
    }

    public function getBookmarks()
    {
        $user = Auth::user();

        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with([
                'post.user',
                'post.likes',
                'post.comments' => function ($q) {
                    $q->whereNull('parent_id')
                        ->with(['user', 'replies.user']);
                },
            ])
            ->latest()
            ->get()
            ->pluck('post')
            ->filter()
            ->values();

        // Add total comments and replies count for each post
        $bookmarks->transform(function ($post) {
            $post->total_comments = $post->comments->count() + $post->comments->sum(fn($c) => $c->replies->count());
            return $post;
        });

        return response()->json([
            'success'   => true,
            'bookmarks' => $bookmarks,
        ]);
    }

    public function muteUser(Request $request, $id)
    {
        $auth = auth()->user();
        if (! $auth) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($auth->id == (int) $id) {
            return response()->json(['message' => 'You cannot mute yourself'], 400);
        }

        $exists = $auth->mutedUsers()->where('users.id', $id)->exists();

        if ($exists) {
            // already muted -> unmute
            $auth->mutedUsers()->detach($id);
            return response()->json(['status' => 'unmuted', 'message' => 'User unmuted']);
        }

        // mute
        $auth->mutedUsers()->attach($id);
        return response()->json(['status' => 'muted', 'message' => 'User muted']);
    }

    public function unblockUser($id)
    {
        $authId    = auth()->id(); // currently logged-in user
        $blockedId = $id;          // user to unblock

        // Delete the block entry
        \App\Models\Block::where('user_id', $authId)
            ->where('blocked_id', $blockedId)
            ->delete();

        // Optional: Remove friendship if exists (both directions)
        // \App\Models\Friendship::where(function ($query) use ($authId, $blockedId) {
        //     $query->where('sender_id', $authId)
        //         ->where('receiver_id', $blockedId);
        // })
        //     ->orWhere(function ($query) use ($authId, $blockedId) {
        //         $query->where('sender_id', $blockedId)
        //             ->where('receiver_id', $authId);
        //     })
        //     ->delete();

        return response()->json(['success' => true, 'message' => 'User unblocked successfully']);
    }

    public function unmuteUser($id)
    {
        $userId = auth()->id();
        \App\Models\Mute::where('user_id', $userId)
            ->where('muted_user_id', $id)
            ->delete();

        return response()->json(['success' => true]);
    }
}
