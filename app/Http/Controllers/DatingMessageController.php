<?php
namespace App\Http\Controllers;

use App\Models\DatingMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatingMessageController extends Controller
{
    /* ===============================
       SEND MESSAGE (Dating Profile)
    =============================== */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string',
        ]);

        DatingMessage::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

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
