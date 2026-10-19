<?php
namespace App\Http\Controllers;

use App\Models\FriendChatGroup;
use App\Models\FriendChatGroupMessage;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendChatGroupController extends Controller
{
    /**
     * Show create group form.
     */
    public function create()
    {
        $user = auth()->user();

        $friendIds = Friendship::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->get()
            ->map(function ($friendship) use ($user) {
                return $friendship->sender_id == $user->id
                    ? $friendship->receiver_id
                    : $friendship->sender_id;
            })
            ->unique()
            ->values();

        $friends = User::whereIn('id', $friendIds)
            ->where('role', 0)
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('blocked_id')
                    ->from('blocks')
                    ->where('user_id', $user->id);
            })
            ->orderBy('first_name')
            ->get();

        $notifications = auth()->user()->unreadNotifications;

        return view('user.chat.create-group', compact('friends', 'notifications'));
    }

    /**
     * Create permanent friend group.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'members'   => 'required|array|min:1',
            'members.*' => 'required|integer|distinct|exists:users,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $friendIds = Friendship::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->get()
            ->map(function ($friendship) use ($user) {
                return (int) (
                    $friendship->sender_id == $user->id
                        ? $friendship->receiver_id
                        : $friendship->sender_id
                );
            })
            ->unique()
            ->values()
            ->all();

        $selectedIds = array_map('intval', $validated['members']);

        // The creator cannot be added again as a selected member.
        if (in_array((int) $user->id, $selectedIds, true)) {
            return back()
                ->withErrors(['members' => 'You are already the group creator.'])
                ->withInput();
        }

        // Every selected user must be an accepted friend.
        if (count(array_diff($selectedIds, $friendIds)) > 0) {
            return back()
                ->withErrors(['members' => 'You can only add your accepted friends.'])
                ->withInput();
        }

        $group = DB::transaction(function () use ($validated, $selectedIds, $user, $request) {
            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store('friend-chat-groups', 'public')
                : null;

            $group = FriendChatGroup::create([
                'name'       => $validated['name'],
                'image'      => $imagePath,
                'created_by' => $user->id,
            ]);

            // Creator is automatically an admin and member.
            $group->members()->attach($user->id, [
                'is_admin' => true,
            ]);

            // Add selected friends.
            foreach ($selectedIds as $memberId) {
                $group->members()->attach($memberId, [
                    'is_admin' => false,
                ]);
            }

            return $group;
        });

        return redirect()
            ->route('friend-chat-groups.show', $group->id)
            ->with('success', 'Group created successfully!');
    }

    /**
     * Show group chat.
     */
    public function show($groupId)
    {
        $user = auth()->user();

        $group = FriendChatGroup::with('members')
            ->findOrFail($groupId);

        // Only group members can access the group
        $isMember = $group->members()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($isMember, 403, 'You are not a member of this group.');

        $notifications = $user->unreadNotifications;

        $messages = $group->messages()
            ->with('user')
            ->orderBy('created_at')
            ->get();

        return view('user.friend-group-chat', compact(
            'group',
            'user',
            'notifications',
            'messages'
        ));
    }

    public function sendMessage(Request $request, $groupId)
    {
        $user = auth()->user();

        $group = FriendChatGroup::findOrFail($groupId);

        // Check group membership
        $isMember = $group->members()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($isMember, 403, 'You are not a member of this group.');

        // At least a message or attachment is required
        $request->validate([
            'message'    => 'nullable|string|max:10000',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $messageText = trim((string) $request->input('message'));

        if ($messageText === '' && ! $request->hasFile('attachment')) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a message or select a file.',
            ], 422);
        }

        $attachmentPath = null;
        $attachmentName = null;
        $attachmentMime = null;
        $attachmentSize = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $attachmentPath = $file->store(
                'friend-chat-groups/' . $group->id . '/attachments',
                'public'
            );

            $attachmentName = $file->getClientOriginalName();
            $attachmentMime = $file->getMimeType();
            $attachmentSize = $file->getSize();
        }

        $message = FriendChatGroupMessage::create([
            'group_id'        => $group->id,
            'user_id'         => $user->id,
            'message'         => $messageText !== '' ? $messageText : null,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
        ]);

        $message->load('user');

        return response()->json([
            'success' => true,
            'data'    => [
                'id'              => $message->id,
                'user_id'         => $message->user_id,
                'user_name'       => trim(
                    ($message->user->first_name ?? '') . ' ' .
                    ($message->user->last_name ?? '')
                ),
                'message'         => $message->message,
                'attachment_name' => $message->attachment_name,
                'attachment_mime' => $message->attachment_mime,
                'attachment_url'  => $message->attachment_path
                    ? asset('storage/' . $message->attachment_path)
                    : null,
                'created_at'      => $message->created_at->format('h:i A'),
            ],
        ]);
    }

    public function fetchMessages($groupId)
    {
        $user = auth()->user();

        $group = FriendChatGroup::findOrFail($groupId);

        $isMember = $group->members()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($isMember, 403, 'You are not a member of this group.');

        $messages = FriendChatGroupMessage::where('group_id', $group->id)
            ->with('user')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id'              => $message->id,
                    'user_id'         => $message->user_id,
                    'user_name'       => trim(
                        ($message->user->first_name ?? '') . ' ' .
                        ($message->user->last_name ?? '')
                    ),
                    'message'         => $message->message,
                    'attachment_name' => $message->attachment_name,
                    'attachment_mime' => $message->attachment_mime,
                    'attachment_url'  => $message->attachment_path
                        ? asset('storage/' . $message->attachment_path)
                        : null,
                    'created_at'      => $message->created_at->format('h:i A'),
                ];
            })
            ->values();

        return response()->json([
            'success'  => true,
            'messages' => $messages,
        ]);
    }
}
