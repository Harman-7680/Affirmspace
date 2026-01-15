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

            $this->sendFirebaseSafe(
                $sender->id,
                'Friend Request Accepted',
                Auth::user()->first_name . ' accepted your friend request',
                [
                    'type'        => 'friend_request_accepted',
                    'receiver_id' => (string) Auth::id(),
                ]
            );

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
