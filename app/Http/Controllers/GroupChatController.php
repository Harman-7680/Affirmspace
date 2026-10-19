<?php
namespace App\Http\Controllers;

use App\Events\GroupMessageSent;
use App\Models\GroupChatMessage;
use App\Models\JitsiRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class GroupChatController extends Controller
{
    /**
     * Check room access.
     */
    private function checkRoomAccess($roomId)
    {
        $room = JitsiRoom::findOrFail($roomId);

        $isMember = $room->users()
            ->where('users.id', auth()->id())
            ->exists();

        abort_unless($isMember, 403, 'You are not a member of this room.');

        abort_if(
            now()->greaterThanOrEqualTo($room->end_time),
            403,
            'This room has expired.'
        );

        return $room;
    }

    /**
     * Show group chat page.
     */
    public function show($roomId)
    {
        $room = $this->checkRoomAccess($roomId);

        $user          = auth()->user();
        $notifications = $user->unreadNotifications;

        return view('user.group-chat', compact(
            'room',
            'user',
            'notifications'
        ));
    }

    /**
     * Fetch previous messages.
     */
    public function fetch($roomId)
    {
        $this->checkRoomAccess($roomId);

        $messages = GroupChatMessage::with('user:id,first_name,last_name,image')
            ->where('room_id', $roomId)
            ->orderBy('id')
            ->limit(100)
            ->get()
            ->map(function ($msg) {
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
                    'message'         => $msg->message
                        ? Crypt::decryptString($msg->message)
                        : null,
                    'attachment_url'  => $msg->attachment_path
                        ? asset('storage/' . $msg->attachment_path)
                        : null,
                    'attachment_name' => $msg->attachment_name,
                    'attachment_mime' => $msg->attachment_mime,
                    'created_at'      => $msg->created_at->toDateTimeString(),
                ];
            });

        return response()->json($messages);
    }

    /**
     * Send text message or attachment.
     */
    public function send(Request $request, $roomId)
    {
        $room = $this->checkRoomAccess($roomId);

        $request->validate([
            'message'    => 'nullable|string|max:5000|required_without:attachment',
            'attachment' => 'nullable|file|max:51200|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,txt,mp4,webm,mov,mp3,wav|required_without:message',
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
            'user_id'         => auth()->id(),
            'message'         => $plainMessage !== null && $plainMessage !== ''
                ? Crypt::encryptString($plainMessage)
                : null,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
        ]);

        $user = auth()->user();

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
            'created_at'      => $msg->created_at->toDateTimeString(),
        ];

        event(new GroupMessageSent($payload));

        return response()->json([
            'success' => true,
            'data'    => $payload,
        ]);
    }

    public function joinGroup($roomId)
    {
        $room = JitsiRoom::findOrFail($roomId);

        // Room expire check
        if (now()->greaterThanOrEqualTo($room->end_time)) {
            return redirect()->route('groups')
                ->with('error', 'This room has expired.');
        }

        // Check whether user is already a member
        $isMember = $room->users()
            ->where('users.id', auth()->id())
            ->exists();

        // Already joined: open chat directly
        if ($isMember) {
            return redirect()->route('group-chat.show', $room->id);
        }

        // Check room capacity
        if ($room->users()->count() >= $room->max_users) {
            return redirect()->route('groups')
                ->with('error', 'This room is full.');
        }

        // Add user to room
        $room->users()->attach(auth()->id(), [
            'is_admin' => false,
        ]);

        // Open group chat
        return redirect()->route('group-chat.show', $room->id);
    }
}
