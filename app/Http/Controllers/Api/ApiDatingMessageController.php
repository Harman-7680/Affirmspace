<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DatingMessage;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiDatingMessageController extends Controller
{
    /* ===============================
       SEND MESSAGE (Dating Profile)
    =============================== */
    public function send(Request $request, FirebaseNotificationService $fcm)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string',
        ]);

        $sender = auth()->user();

        // Save message
        DatingMessage::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        // NOTIFICATION PART START

        $tokens = UserDevice::where('user_id', $request->receiver_id)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token');

        foreach ($tokens as $token) {
            try {
                $fcm->send(
                    $token,
                    "💌 {$sender->first_name} sent you a message",
                    \Str::limit($request->message, 50),
                    [
                        'sender_id' => $sender->id,
                        'type'      => 'dating_chat',
                    ]
                );
            } catch (\Throwable $e) {
                Log::warning("Dating FCM failed: " . $e->getMessage());
            }
        }

        // NOTIFICATION PART END

        return response()->json([
            'success' => true,
            'message' => 'Message sent',
        ], 200);
    }

    /* ===============================
       FETCH CHAT (Messages Page)
    =============================== */
    public function chat($user_id)
    {
        $authId = auth()->id();

        $messages = DatingMessage::where(function ($q) use ($authId, $user_id) {
            $q->where('sender_id', $authId)
                ->where('receiver_id', $user_id);
        })
            ->orWhere(function ($q) use ($authId, $user_id) {
                $q->where('sender_id', $user_id)
                    ->where('receiver_id', $authId);
            })
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    /* ===============================
       USERS LIST (Messages Sidebar)
    =============================== */
    public function conversations()
    {
        $authId = auth()->id();

        $userIds = DatingMessage::where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->get()
            ->map(function ($msg) use ($authId) {
                return $msg->sender_id == $authId
                    ? $msg->receiver_id
                    : $msg->sender_id;
            })
            ->unique()
            ->values();

        $users = User::whereIn('id', $userIds)->get();

        return $users;
    }
}
