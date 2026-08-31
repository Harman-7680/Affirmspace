<?php
namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LiveChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message'     => 'required',
        ]);

        $plainMessage = $request->message;

        $msg = ChatMessage::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message'     => Crypt::encryptString($plainMessage),
        ]);

        try {
            event(new MessageSent(
                $plainMessage,
                $msg->sender_id,
                $msg->receiver_id,
                $msg->id
            ));
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
        }

        return response()->json($msg);
    }

    public function fetch($userId)
    {
        return ChatMessage::where(function ($q) use ($userId) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('id')
            ->get()
            ->map(function ($msg) {

                try {
                    $msg->message = Crypt::decryptString($msg->message);
                } catch (\Throwable $e) {
                    $msg->message = $msg->message;
                }

                return $msg;
            });
    }
}
