<?php
namespace App\Http\Controllers\Api;

use App\Events\GroupMessageSent;
use App\Http\Controllers\Controller;
use App\Models\GroupChatMessage;
use App\Models\JitsiRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class GroupChatApiController extends Controller
{
    /**
     * Check room access.
     */
    private function checkRoomAccess($roomId)
    {
        $room = JitsiRoom::findOrFail($roomId);

        $isMember = $room->users()
            ->where('users.id', Auth::id())
            ->exists();

        abort_unless(
            $isMember,
            403,
            'You are not a member of this room.'
        );

        abort_if(
            now()->greaterThanOrEqualTo($room->end_time),
            403,
            'This room has expired.'
        );

        return $room;
    }

    /**
     * Join a group.
     */
    public function joinGroup($roomId)
    {
        $room = JitsiRoom::findOrFail($roomId);

        if (now()->greaterThanOrEqualTo($room->end_time)) {
            return response()->json([
                'success' => false,
                'message' => 'This room has expired.',
            ], 403);
        }

        $isMember = $room->users()
            ->where('users.id', Auth::id())
            ->exists();

        if ($isMember) {
            return response()->json([
                'success' => true,
                'message' => 'You are already a member of this room.',
                'data'    => [
                    'room_id'   => $room->id,
                    'is_member' => true,
                ],
            ]);
        }

        if ($room->users()->count() >= $room->max_users) {
            return response()->json([
                'success' => false,
                'message' => 'This room is full.',
            ], 403);
        }

        $room->users()->attach(Auth::id(), [
            'is_admin' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You joined the group successfully.',
            'data'    => [
                'room_id'   => $room->id,
                'is_member' => true,
            ],
        ], 201);
    }

    /**
     * Fetch the latest 100 group messages.
     */
    public function fetch($roomId)
    {
        $this->checkRoomAccess($roomId);

        $messages = GroupChatMessage::with(
            'user:id,first_name,last_name,image'
        )
            ->where('room_id', $roomId)
            ->orderByDesc('id')
            ->limit(100)
            ->get()
            ->sortBy('id')
            ->values()
            ->map(function ($msg) {
                try {
                    $plainMessage = $msg->message !== null
                        ? Crypt::decryptString($msg->message)
                        : null;
                } catch (\Throwable $e) {
                    // Support older plaintext messages.
                    $plainMessage = $msg->message;
                }

                return [
                    'id'              => $msg->id,
                    'room_id'         => $msg->room_id,
                    'user_id'         => $msg->user_id,

                    'user_name'       => trim(
                        ($msg->user->first_name ?? '') . ' ' .
                        ($msg->user->last_name ?? '')
                    ),

                    'user_image'      => $msg->user && $msg->user->image
                        ? asset('storage/' . $msg->user->image)
                        : asset('images/avatars/avatar-1.jpg'),

                    'message'         => $plainMessage,

                    'attachment_url'  => $msg->attachment_path
                        ? asset('storage/' . $msg->attachment_path)
                        : null,

                    'attachment_name' => $msg->attachment_name,
                    'attachment_mime' => $msg->attachment_mime,
                    'attachment_size' => $msg->attachment_size,

                    'created_at'      => $msg->created_at
                        ? $msg->created_at->toDateTimeString()
                        : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $messages,
        ]);
    }

    /**
     * Send a text message, attachment, or both.
     */
    public function send(Request $request, $roomId)
    {
        $room = $this->checkRoomAccess($roomId);

        $request->validate([
            'message'    => [
                'nullable',
                'string',
                'max:5000',
                'required_without:attachment',
            ],

            'attachment' => [
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
                'group-chat/' . $room->id,
                'public'
            );

            $attachmentName = $file->getClientOriginalName();
            $attachmentMime = $file->getMimeType();
            $attachmentSize = $file->getSize();
        }

        $plainMessage = $request->input('message');

        $msg = GroupChatMessage::create([
            'room_id'         => $room->id,
            'user_id'         => Auth::id(),

            'message'         => ($plainMessage !== null && $plainMessage !== '')
                ? Crypt::encryptString($plainMessage)
                : null,

            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
        ]);

        $user = Auth::user();

        $payload = [
            'id'              => $msg->id,
            'room_id'         => $room->id,
            'user_id'         => $user->id,

            'user_name'       => trim(
                $user->first_name . ' ' . $user->last_name
            ),

            'user_image'      => $user->image
                ? asset('storage/' . $user->image)
                : asset('images/avatars/avatar-1.jpg'),

            'message'         => $plainMessage,

            'attachment_url'  => $attachmentPath
                ? asset('storage/' . $attachmentPath)
                : null,

            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,

            'created_at'      => $msg->created_at->toDateTimeString(),
        ];

        // Broadcast to existing group-chat listeners.
        try {
            event(new GroupMessageSent($payload));
        } catch (\Throwable $e) {
            Log::error('Group chat API broadcast failed', [
                'message_id' => $msg->id,
                'room_id'    => $room->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Group message sent successfully.',
            'data'    => $payload,
        ], 201);
    }
}
