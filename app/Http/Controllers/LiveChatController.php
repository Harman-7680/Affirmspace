<?php
// namespace App\Http\Controllers;

// use App\Events\MessageSent;
// use App\Models\ChatMessage;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Crypt;

// class LiveChatController extends Controller
// {
//     public function send(Request $request)
//     {
//         $request->validate([
//             'receiver_id' => 'required',
//             'message'     => 'required',
//         ]);

//         $plainMessage = $request->message;

//         $msg = ChatMessage::create([
//             'sender_id'   => auth()->id(),
//             'receiver_id' => $request->receiver_id,
//             'message'     => Crypt::encryptString($plainMessage),
//         ]);

//         try {
//             event(new MessageSent(
//                 $plainMessage,
//                 $msg->sender_id,
//                 $msg->receiver_id,
//                 $msg->id
//             ));
//         } catch (\Throwable $e) {
//             \Log::error($e->getMessage());
//         }

//         return response()->json($msg);
//     }

//     public function fetch($userId)
//     {
//         return ChatMessage::where(function ($q) use ($userId) {
//             $q->where('sender_id', auth()->id())
//                 ->where('receiver_id', $userId);
//         })
//             ->orWhere(function ($q) use ($userId) {
//                 $q->where('sender_id', $userId)
//                     ->where('receiver_id', auth()->id());
//             })
//             ->orderBy('id')
//             ->get()
//             ->map(function ($msg) {

//                 try {
//                     $msg->message = Crypt::decryptString($msg->message);
//                 } catch (\Throwable $e) {
//                     $msg->message = $msg->message;
//                 }

//                 return $msg;
//             });
//     }
// }

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LiveChatController extends Controller
{
    /**
     * Send a text message, attachment, or both.
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => [
                'required',
                'integer',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if ((int) $value === (int) auth()->id()) {
                        $fail('You cannot send a message to yourself.');
                    }
                },
            ],

            'message'     => [
                'nullable',
                'string',
                'max:5000',
                'required_without:attachment',
            ],

            'attachment'  => [
                'nullable',
                'file',
                'max:51200',
                'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,txt,mp4,webm,mov,mp3,wav',
                'required_without:message',
            ],
        ]);

        $attachmentPath = null;
        $attachmentName = null;
        $attachmentMime = null;
        $attachmentSize = null;

        /*
         * Upload attachment.
         */
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $attachmentPath = $file->store(
                'friend-chat/' . auth()->id(),
                'public'
            );

            $attachmentName = $file->getClientOriginalName();
            $attachmentMime = $file->getMimeType();
            $attachmentSize = $file->getSize();
        }

        /*
         * Preserve existing message encryption.
         */
        $plainMessage = $request->input('message');

        $msg = ChatMessage::create([
            'sender_id'       => auth()->id(),
            'receiver_id'     => $request->receiver_id,

            'message'         => ($plainMessage !== null && $plainMessage !== '')
                ? Crypt::encryptString($plainMessage)
                : null,

            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
        ]);

        $payload = [
            'id'              => $msg->id,
            'sender_id'       => $msg->sender_id,
            'receiver_id'     => $msg->receiver_id,
            'message'         => $plainMessage,

            'attachment_url'  => $attachmentPath
                ? asset('storage/' . $attachmentPath)
                : null,

            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
            'created_at'      => $msg->created_at->toDateTimeString(),
        ];

        /*
         * Broadcast text and attachment information.
         */
        try {
            event(new MessageSent(
                $payload['message'],
                $payload['sender_id'],
                $payload['receiver_id'],
                $payload['id'],
                $payload['attachment_url'],
                $payload['attachment_name'],
                $payload['attachment_mime'],
                $payload['attachment_size'],
                $payload['created_at']
            ));
        } catch (\Throwable $e) {
            Log::error('Friend chat broadcast failed', [
                'message_id' => $msg->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => $payload,
        ]);
    }

    /**
     * Fetch conversation history.
     */
    public function fetch($userId)
    {
        $messages = ChatMessage::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('id')
            ->get()
            ->map(function ($msg) {
                try {
                    $message = $msg->message !== null
                        ? Crypt::decryptString($msg->message)
                        : null;
                } catch (\Throwable $e) {
                    // Preserve compatibility with older plaintext records.
                    $message = $msg->message;
                }

                return [
                    'id'              => $msg->id,
                    'sender_id'       => $msg->sender_id,
                    'receiver_id'     => $msg->receiver_id,
                    'message'         => $message,

                    'attachment_url'  => $msg->attachment_path
                        ? asset('storage/' . $msg->attachment_path)
                        : null,

                    'attachment_name' => $msg->attachment_name,
                    'attachment_mime' => $msg->attachment_mime,
                    'attachment_size' => $msg->attachment_size,
                    'created_at'      => $msg->created_at->toDateTimeString(),
                ];
            });

        return response()->json($messages);
    }
}
