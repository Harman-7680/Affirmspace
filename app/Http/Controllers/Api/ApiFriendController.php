<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\User;
use App\Models\UserDevice;
use App\Notifications\FollowNotification;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiFriendController extends Controller
{
    // Send Friend Request
    public function sendRequest(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|not_in:' . Auth::id(),
        ]);

        $auth       = Auth::user();
        $receiverId = $request->receiver_id;

        // $existing = Friendship::where('sender_id', $auth->id)
        //     ->where('receiver_id', $receiverId)
        //     ->where('status', 'pending')
        //     ->first();

        // Both side check request not in pending status
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
            return response()->json(['error' => 'Friend request already pending!'], 400);
        }

        $friendship = Friendship::create([
            'sender_id'   => $auth->id,
            'receiver_id' => $receiverId,
            'status'      => 'pending',
        ]);

        $receiver = User::findOrFail($receiverId);
        $receiver->notify(new FollowNotification($auth));

        $tokens = UserDevice::where('user_id', $receiver->id)
            ->pluck('device_token');

        foreach ($tokens as $token) {
            try {
                app(FirebaseNotificationService::class)->send(
                    $token,
                    'New Friend Request 👋',
                    $auth->first_name . ' sent you a friend request',
                    [
                        'type'        => 'follow', // or friend_request
                        'sender_id'   => (string) $auth->id,
                        'sender_name' => $auth->first_name,
                    ]
                );
            } catch (\Throwable $e) {
                Log::error('Firebase Follow Push Error: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Friend request sent!',
            'data'    => $friendship,
        ], 201);
    }

    // Accept or Reject Request
    public function handleResponse(Request $request)
    {
        $friendship = Friendship::findOrFail($request->friendship_id);

        if ($friendship->receiver_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        if ($request->action == 'accept') {
            $friendship->status = 'accepted';
            $friendship->save();

            $friendship->sender->notify(new \App\Notifications\RequestAcceptedNotification(Auth::user()));

            $sender = $friendship->sender;

            $tokens = UserDevice::where('user_id', $sender->id)
                ->pluck('device_token');

            foreach ($tokens as $token) {
                try {
                    app(FirebaseNotificationService::class)->send(
                        $token,
                        'Friend Request Accepted',
                        Auth::user()->first_name . ' accepted your friend request',
                        [
                            'type'        => 'friend_request_accepted',
                            'receiver_id' => (string) Auth::id(),
                        ]
                    );
                } catch (\Throwable $e) {
                    Log::error('Firebase Request Accepted Error: ' . $e->getMessage());
                }
            }
        } else {
            $friendship->delete();
        }

        // Mark notification as read
        $notification = Auth::user()->notifications()
            ->where('data->follower_id', $friendship->sender_id)
            ->latest()->first();
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'message' => 'Request ' . $request->action . 'ed!',
        ]);
    }

    // Unfriend
    public function unfriend($id)
    {
        Friendship::where(function ($q) use ($id) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)->where('receiver_id', auth()->id());
        })->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unfriended successfully.',
        ]);
    }
}
