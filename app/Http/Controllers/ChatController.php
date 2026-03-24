<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $fcm;

    public function __construct(FirebaseNotificationService $fcm)
    {
        $this->fcm = $fcm;
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string',
        ]);

        $sender   = auth()->user();
        $receiver = User::findOrFail($request->receiver_id);

        // Get receiver device token
        $tokens = UserDevice::where('user_id', $receiver->id)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token');

        foreach ($tokens as $token) {
            $this->fcm->send(
                $token,
                "New Message from {$sender->first_name}",
                $request->message,
                [
                    'sender_id' => $sender->id,
                    'type'      => 'chat',
                ]
            );
        }

        return response()->json([
            'status'  => true,
            'message' => 'Message sent & notification triggered',
        ]);
    }

    public function sendCallNotification(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'room_name'   => 'required|string',
        ]);

        $sender   = auth()->user();
        $receiver = User::findOrFail($request->receiver_id);

        // Receiver device tokens
        $tokens = UserDevice::where('user_id', $receiver->id)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token');

        foreach ($tokens as $token) {
            $this->fcm->send(
                $token,
                "Incoming call from {$sender->first_name}",
                "Open app or website to answer the call",
                [
                    'sender_id'   => $sender->id,
                    'receiver_id' => $receiver->id,
                    'room_name'   => $request->room_name,
                    'type'        => 'call',
                ]
            );
        }

        return response()->json([
            'status'  => true,
            'message' => 'Call notification sent successfully',
        ]);
    }
}
