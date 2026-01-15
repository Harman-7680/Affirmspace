<?php
namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use App\Models\UserDevice;
use App\Notifications\FollowNotification;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FriendController extends Controller
{
    public function sendRequest(Request $request)
    {
        $auth       = Auth::user();
        $receiverId = $request->receiver_id;
        Log::info('Friend request initiated by user ID: ' . $auth->id . ' to user ID: ' . $receiverId);

        // Check if already sent
        // $existing = Friendship::where('sender_id', $auth->id)
        //     ->where('receiver_id', $receiverId)
        //     ->where('status', 'pending')
        //     ->first();

        // if ($existing) {
        //     return response()->json([
        //         'status'  => 'error',
        //         'message' => 'Request already sent!',
        //     ], 400);
        // }

        // Check if a pending request exists in ANY direction
        $existing = Friendship::where(function ($q) use ($auth, $receiverId) {
            $q->where('sender_id', $auth->id)
                ->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($q) use ($auth, $receiverId) {
                $q->where('sender_id', $receiverId)
                    ->where('receiver_id', $auth->id);
            })
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Friend request already pending!',
            ], 400);
        }

        // Save friendship request
        $friendship = Friendship::create([
            'sender_id'   => $auth->id,
            'receiver_id' => $receiverId,
            'status'      => 'pending',
        ]);

        Log::info('Friendship created with ID: ' . $friendship->id);

        // Notify the receiver
        $receiver = User::findOrFail($receiverId);

        Log::info('Sending notification to user ID: ' . $receiver->id);
        $receiver->notify(new FollowNotification($auth));
        Log::info('Notification sent.');

        $this->sendFirebaseSafe(
            $receiver->id,
            'New Friend Request 👋',
            $auth->first_name . ' sent you a friend request',
            [
                'type'        => 'follow',
                'sender_id'   => (string) $auth->id,
                'sender_name' => $auth->first_name,
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Friend request sent successfully!',
        ]);
    }

    public function handleResponse(Request $request)
    {
        $friendship = Friendship::findOrFail($request->friendship_id);

        if ($friendship->receiver_id != Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized action.'], 403);
        }

        if ($request->action == 'accept') {
            $friendship->status = 'accepted';
            $friendship->save();
            $friendship->sender->notify(new \App\Notifications\RequestAcceptedNotification(Auth::user()));

            $sender = $friendship->sender;

            $this->sendFirebaseSafe(
                $sender->id,
                'Friend Request Accepted',
                Auth::user()->first_name . ' accepted your friend request',
                [
                    'type'        => 'friend_request_accepted',
                    'receiver_id' => (string) Auth::id(),
                ]
            );

            $message = 'Request accepted';
        } else {
            $friendship->delete();
            $message = 'Request rejected';
        }

        // Mark notification as read
        $notification = Auth::user()->notifications()
            ->where('data->follower_id', $friendship->sender_id)
            ->latest()->first();
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function unfriend($id, Request $request)
    {
        Friendship::where(function ($q) use ($id) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)->where('receiver_id', auth()->id());
        })->delete();

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Unfriended successfully',
            ]);
        }

        // Fallback for normal requests
        return back()->with('success', 'Unfriended successfully.');
    }

    public function withdraw($id)
    {
        $sender = auth()->user();

        // Find the pending friendship
        $friendship = Friendship::where('sender_id', $sender->id)
            ->where('receiver_id', $id)
            ->where('status', 'pending')
            ->first();

        if (! $friendship) {
            return response()->json(['status' => 'error', 'message' => 'No pending request found']);
        }

        // Delete the friendship
        $friendship->delete();

        // Delete notification from the receiver's notifications
        $receiver = \App\Models\User::find($id);

        if ($receiver) {
            $notification = $receiver->notifications()
                ->where('data->follower_id', $sender->id)
                ->first();

            if ($notification) {
                $notification->delete();
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function sendFirebaseSafe($userId, $title, $body, array $data = [])
    {
        $tokens = UserDevice::where('user_id', $userId)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token');

        if ($tokens->isEmpty()) {
            return; // No device → silently skip
        }

        foreach ($tokens as $token) {
            try {
                app(FirebaseNotificationService::class)->send(
                    $token,
                    $title,
                    $body,
                    $data
                );
            } catch (\Throwable $e) {
                Log::warning(
                    "Firebase push skipped (user {$userId}): " . $e->getMessage()
                );
            }
        }
    }
}
