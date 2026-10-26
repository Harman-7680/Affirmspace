<?php
namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LiveChatApiController extends Controller
{
    /**
     * Send text message, attachment, or both.
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => [
                'required',
                'integer',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if ((int) $value === (int) Auth::id()) {
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

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $attachmentPath = $file->store(
                'friend-chat/' . Auth::id(),
                'public'
            );

            $attachmentName = $file->getClientOriginalName();
            $attachmentMime = $file->getMimeType();
            $attachmentSize = $file->getSize();
        }

        $plainMessage = $request->input('message');

        $msg = ChatMessage::create([
            'sender_id'       => Auth::id(),
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

        // Reverb broadcast
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
            Log::error('API chat broadcast failed', [
                'message_id' => $msg->id,
                'error'      => $e->getMessage(),
            ]);
        }

        /*
 * Firebase push notification for API chat.
 */
        try {
            $sender = Auth::user();

            $senderName = trim(
                ($sender->first_name ?? '') . ' ' .
                ($sender->last_name ?? '')
            );

            if ($senderName === '') {
                $senderName = 'Someone';
            }

            // Prepare notification body.
            if ($plainMessage !== null && trim($plainMessage) !== '') {
                $notificationBody = $plainMessage;
            } elseif ($attachmentName !== null) {
                $notificationBody = 'Sent an attachment: ' . $attachmentName;
            } else {
                $notificationBody = 'You received a new message.';
            }

            // Avoid excessively long push notification text.
            if (mb_strlen($notificationBody) > 200) {
                $notificationBody = mb_substr($notificationBody, 0, 197) . '...';
            }

            // Fetch all registered devices of the receiver.
            $tokens = UserDevice::where('user_id', $msg->receiver_id)
                ->whereNotNull('device_token')
                ->where('device_token', '!=', '')
                ->pluck('device_token')
                ->unique();

            foreach ($tokens as $token) {
                try {
                    app(FirebaseNotificationService::class)->send(
                        $token,
                        $senderName,
                        $notificationBody,
                        [
                            'type'        => 'chat_message',
                            'sender_id'   => (string) $msg->sender_id,
                            'receiver_id' => (string) $msg->receiver_id,
                            'message_id'  => (string) $msg->id,
                        ]
                    );
                } catch (\Throwable $e) {
                    Log::warning('API chat Firebase notification failed', [
                        'message_id'  => $msg->id,
                        'receiver_id' => $msg->receiver_id,
                        'error'       => $e->getMessage(),
                    ]);
                }
            }

        } catch (\Throwable $e) {
            Log::error('API chat notification processing failed', [
                'message_id' => $msg->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data'    => $payload,
        ], 201);
    }

    /**
     * Fetch conversation history.
     */
    public function fetch($userId)
    {
        $currentUserId = Auth::id();

        // Validate receiver
        if (
            ! User::where('id', $userId)->exists()
            || (int) $userId === (int) $currentUserId
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid receiver.',
            ], 422);
        }

        $messages = ChatMessage::where(function ($query) use ($userId, $currentUserId) {
            $query->where('sender_id', $currentUserId)
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($userId, $currentUserId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $currentUserId);
            })
            ->orderBy('id')
            ->get()
            ->map(function ($msg) {
                try {
                    $message = $msg->message !== null
                        ? Crypt::decryptString($msg->message)
                        : null;
                } catch (\Throwable $e) {
                    // Support old plaintext messages.
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

        return response()->json([
            'success' => true,
            'data'    => $messages,
        ]);
    }
}
