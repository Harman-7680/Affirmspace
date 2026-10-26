<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FriendChatGroup;
use App\Models\FriendChatGroupMessage;
use App\Models\Friendship;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FriendChatGroupApiController extends Controller
{
    /**
     * Check whether the logged-in user belongs to the group.
     */
    private function checkGroupAccess($groupId)
    {
        $group = FriendChatGroup::findOrFail($groupId);

        $isMember = $group->members()
            ->where('users.id', auth()->id())
            ->exists();

        abort_unless(
            $isMember,
            403,
            'You are not a member of this group.'
        );

        return $group;
    }

    /**
     * Get the public URL for a stored file.
     */
    private function fileUrl($path)
    {
        return $path ? asset('storage/' . $path) : null;
    }

    /**
     * Format a user for API responses.
     */
    private function formatUser($user)
    {
        return [
            'id'    => $user->id,
            'name'  => trim(
                ($user->first_name ?? '') . ' ' .
                ($user->last_name ?? '')
            ),
            'image' => $this->fileUrl($user->image ?? null) ?? asset('images/avatars/avatar-1.jpg'),
        ];
    }

    /**
     * Format group details.
     */
    private function formatGroup($group)
    {
        return [
            'id'            => $group->id,
            'name'          => $group->name,
            'image'         => $this->fileUrl($group->image),
            'created_by'    => $group->created_by,
            'members_count' => $group->members->count(),
            'members'       => $group->members->map(function ($member) {
                return array_merge(
                    $this->formatUser($member),
                    [
                        'is_admin' => (bool) $member->pivot->is_admin,
                    ]
                );
            })->values(),
            'created_at'    => $group->created_at?->toDateTimeString(),
        ];
    }

    /**
     * Format a chat message.
     */
    private function formatMessage($message)
    {
        return [
            'id'              => $message->id,
            'group_id'        => $message->group_id,
            'user_id'         => $message->user_id,
            'user_name'       => trim(
                ($message->user->first_name ?? '') . ' ' .
                ($message->user->last_name ?? '')
            ),
            'user_image'      => $this->fileUrl(
                $message->user->image ?? null
            ) ?? asset('images/avatars/avatar-1.jpg'),
            'message'         => $message->message,
            'attachment_url'  => $this->fileUrl(
                $message->attachment_path
            ),
            'attachment_name' => $message->attachment_name,
            'attachment_mime' => $message->attachment_mime,
            'attachment_size' => $message->attachment_size,
            'created_at'      => $message->created_at?->toDateTimeString(),
            'time'            => $message->created_at?->format('h:i A'),
        ];
    }

    /**
     * Get the logged-in user's accepted friends.
     * GET /api/friend-chat-groups/friends
     */
    public function friends()
    {
        $user = auth()->user();

        $friendIds = Friendship::where('status', 'accepted')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
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

        $friends = User::whereIn('id', $friendIds)
            ->where('role', 0)
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('blocked_id')
                    ->from('blocks')
                    ->where('user_id', $user->id);
            })
            ->orderBy('first_name')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $friends->map(function ($friend) {
                return $this->formatUser($friend);
            })->values(),
        ]);
    }

    /**
     * List groups where the logged-in user is a member.
     * GET /api/friend-chat-groups
     */
    public function index()
    {
        $groups = FriendChatGroup::whereHas('members', function ($query) {
            $query->where('users.id', auth()->id());
        })
            ->with([
                'members:id,first_name,last_name,image',
                'messages' => function ($query) {
                    $query->latest('id')->limit(1);
                },
                'messages.user:id,first_name,last_name,image',
            ])
            ->latest('updated_at')
            ->get();

        $data = $groups->map(function ($group) {
            $lastMessage = $group->messages->first();

            return [
                'id'            => $group->id,
                'name'          => $group->name,
                'image'         => $this->fileUrl($group->image),
                'created_by'    => $group->created_by,
                'members_count' => $group->members->count(),
                'last_message'  => $lastMessage
                    ? $this->formatMessage($lastMessage)
                    : null,
                'created_at'    => $group->created_at?->toDateTimeString(),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Create a group.
     * POST /api/friend-chat-groups
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

        $selectedIds = array_map(
            'intval',
            $validated['members']
        );

        if (in_array((int) $user->id, $selectedIds, true)) {
            return response()->json([
                'success' => false,
                'message' => 'You are already the group creator.',
            ], 422);
        }

        // Get accepted friends of the current user.
        $friendIds = Friendship::where('status', 'accepted')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
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

        if (count(array_diff($selectedIds, $friendIds)) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'You can only add your accepted friends.',
            ], 422);
        }

        // Only normal users can be added.
        $validUsersCount = User::whereIn('id', $selectedIds)
            ->where('role', 0)
            ->count();

        if ($validUsersCount !== count($selectedIds)) {
            return response()->json([
                'success' => false,
                'message' => 'One or more selected members are invalid.',
            ], 422);
        }

        // Blocked users should not be added.
        $blockedIds = DB::table('blocks')
            ->where('user_id', $user->id)
            ->whereIn('blocked_id', $selectedIds)
            ->pluck('blocked_id')
            ->map(fn($id) => (int) $id)
            ->all();

        if (! empty($blockedIds)) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot add a user you have blocked.',
            ], 422);
        }

        $group = DB::transaction(function () use (
            $request,
            $validated,
            $selectedIds,
            $user
        ) {
            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store(
                'friend-chat-groups',
                'public'
            )
                : null;

            $group = FriendChatGroup::create([
                'name'       => $validated['name'],
                'image'      => $imagePath,
                'created_by' => $user->id,
            ]);

            // Creator is an admin and member.
            $group->members()->attach($user->id, [
                'is_admin' => true,
            ]);

            // Add selected accepted friends.
            foreach ($selectedIds as $memberId) {
                $group->members()->attach($memberId, [
                    'is_admin' => false,
                ]);
            }

            return $group;
        });

        $group->load([
            'members:id,first_name,last_name,image',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Group created successfully.',
            'data'    => $this->formatGroup($group),
        ], 201);
    }

    /**
     * Get group details and members.
     * GET /api/friend-chat-groups/{groupId}
     */
    public function show($groupId)
    {
        $group = $this->checkGroupAccess($groupId);

        $group->load([
            'members:id,first_name,last_name,image',
        ]);

        return response()->json([
            'success' => true,
            'data'    => $this->formatGroup($group),
        ]);
    }

    /**
     * Fetch group messages.
     * GET /api/friend-chat-groups/{groupId}/messages
     */
    public function fetchMessages($groupId)
    {
        $group = $this->checkGroupAccess($groupId);

        $messages = FriendChatGroupMessage::where(
            'group_id',
            $group->id
        )
            ->with('user:id,first_name,last_name,image')
            ->orderBy('id', 'asc')
            ->limit(100)
            ->get()
            ->map(function ($message) {
                return $this->formatMessage($message);
            })
            ->values();

        return response()->json([
            'success' => true,
            'data'    => $messages,
        ]);
    }

    /**
     * Send a group message or attachment.
     * POST /api/friend-chat-groups/{groupId}/messages
     */
    public function sendMessage(Request $request, $groupId)
    {
        $group = $this->checkGroupAccess($groupId);
        $user  = auth()->user();

        $validated = $request->validate([
            'message'    => 'nullable|string|max:10000',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $messageText = trim((string) ($validated['message'] ?? ''));

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

        try {
            $message = FriendChatGroupMessage::create([
                'group_id'        => $group->id,
                'user_id'         => $user->id,
                'message'         => $messageText !== ''
                    ? $messageText
                    : null,
                'attachment_path' => $attachmentPath,
                'attachment_name' => $attachmentName,
                'attachment_mime' => $attachmentMime,
                'attachment_size' => $attachmentSize,
            ]);
        } catch (\Throwable $e) {
            // Avoid leaving an orphaned attachment if saving fails.
            if ($attachmentPath) {
                Storage::disk('public')->delete($attachmentPath);
            }

            throw $e;
        }

        $message->load('user:id,first_name,last_name,image');

        /*
 * Firebase push notifications for group members.
 */
        try {
            $senderName = trim(
                ($user->first_name ?? '') . ' ' .
                ($user->last_name ?? '')
            );

            if ($senderName === '') {
                $senderName = 'Someone';
            }

            // Prepare notification body.
            if ($messageText !== '') {
                $notificationBody = $messageText;
            } elseif ($attachmentName !== null) {
                $notificationBody = 'Shared an attachment: ' . $attachmentName;
            } else {
                $notificationBody = 'Sent a new message.';
            }

            // Keep notification body reasonably short.
            if (mb_strlen($notificationBody) > 200) {
                $notificationBody = mb_substr($notificationBody, 0, 197) . '...';
            }

            // Get all group members except the sender.
            $memberIds = $group->members()
                ->where('users.id', '!=', $user->id)
                ->pluck('users.id');

            foreach ($memberIds as $memberId) {
                $tokens = UserDevice::where('user_id', $memberId)
                    ->whereNotNull('device_token')
                    ->where('device_token', '!=', '')
                    ->pluck('device_token')
                    ->unique();

                foreach ($tokens as $token) {
                    try {
                        app(FirebaseNotificationService::class)->send(
                            $token,
                            $group->name,
                            $senderName . ': ' . $notificationBody,
                            [
                                'type'       => 'friend_group_message',
                                'group_id'   => (string) $group->id,
                                'message_id' => (string) $message->id,
                                'sender_id'  => (string) $user->id,
                            ]
                        );
                    } catch (\Throwable $e) {
                        Log::warning('API friend group FCM notification failed', [
                            'group_id'   => $group->id,
                            'message_id' => $message->id,
                            'user_id'    => $memberId,
                            'error'      => $e->getMessage(),
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('API friend group notification processing failed', [
                'group_id'   => $group->id,
                'message_id' => $message->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Group message sent successfully.',
            'data'    => $this->formatMessage($message),
        ], 201);
    }
}
