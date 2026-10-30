<?php
namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Block;
use App\Models\ChatMessage;
use App\Models\FriendChatGroup;
use App\Models\FriendChatGroupMessage;
use App\Models\Friendship;
use App\Models\Post;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PostShareController extends Controller
{
    /**
     * Return friends and friend groups available for sharing.
     */
    public function recipients()
    {
        $user = Auth::user();

        abort_if($user->role != 0, 403);

        $blockedIds = Block::where('user_id', $user->id)
            ->pluck('blocked_id')
            ->merge(
                Block::where('blocked_id', $user->id)->pluck('user_id')
            )
            ->unique()
            ->values();

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
            ->reject(function ($id) use ($blockedIds, $user) {
                return $id == $user->id || $blockedIds->contains($id);
            })
            ->unique()
            ->values();

        $friends = User::whereIn('id', $friendIds)
            ->where('role', 0)
            ->where('status', 1)
            ->orderBy('first_name')
            ->get()
            ->map(function ($friend) {
                return [
                    'id'    => $friend->id,
                    'name'  => trim(
                        ($friend->first_name ?? '') . ' ' .
                        ($friend->last_name ?? '')
                    ) ?: 'User',
                    'image' => $friend->image
                        ? asset('storage/' . $friend->image)
                        : null,
                ];
            });

        $groups = FriendChatGroup::whereHas('members', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
            ->orderBy('name')
            ->get(['id', 'name', 'image'])
            ->map(function ($group) {
                return [
                    'id'    => $group->id,
                    'name'  => $group->name,
                    'image' => $group->image
                        ? asset('storage/' . $group->image)
                        : null,
                ];
            });

        return response()->json([
            'success' => true,
            'friends' => $friends,
            'groups'  => $groups,
        ]);
    }

    /**
     * Share a post with selected friends and/or friend groups.
     */
    public function share(Request $request)
    {
        $user = Auth::user();

        abort_if($user->role != 0, 403);

        $validated = $request->validate([
            'post_id'      => ['required', 'integer', 'exists:posts,id'],
            'friend_ids'   => ['sometimes', 'array'],
            'friend_ids.*' => ['integer', 'distinct'],
            'group_ids'    => ['sometimes', 'array'],
            'group_ids.*'  => ['integer', 'distinct'],
        ]);

        $friendIds = array_values(array_unique(
            array_map('intval', $validated['friend_ids'] ?? [])
        ));

        $groupIds = array_values(array_unique(
            array_map('intval', $validated['group_ids'] ?? [])
        ));

        if (empty($friendIds) && empty($groupIds)) {
            throw ValidationException::withMessages([
                'recipients' => 'Select at least one friend or friend group.',
            ]);
        }

        $post = Post::with('user')->findOrFail($validated['post_id']);

        /*
         * Blocked users and blocked posts.
         * Keep these checks server-side; never trust only the modal.
         */
        $hiddenUserIds = Block::where('user_id', $user->id)
            ->pluck('blocked_id')
            ->merge(
                Block::where('blocked_id', $user->id)->pluck('user_id')
            )
            ->unique();

        if ($hiddenUserIds->contains((int) $post->user_id)) {
            abort(403, 'You cannot share this post.');
        }

        if (Block::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->exists()) {
            abort(403, 'You cannot share this post.');
        }

        // The post must have a media file available on the public disk.
        $sourcePath = ltrim((string) $post->post_image, '/');

        if (
            str_starts_with($sourcePath, 'storage/') ||
            ! Storage::disk('public')->exists($sourcePath)
        ) {
            abort(422, 'The post media file could not be found.');
        }

        $mime = Storage::disk('public')->mimeType($sourcePath)
            ?: 'application/octet-stream';

        if (
            ! str_starts_with($mime, 'image/') &&
            ! str_starts_with($mime, 'video/')
        ) {
            abort(422, 'Only image and video posts can be shared.');
        }

        $postUrl = route('post.show', $post->id);

        /*
         * Validate every selected friend is an active, accepted friend
         * and is not blocked by either side.
         */
        if (! empty($friendIds)) {
            if (in_array($user->id, $friendIds, true)) {
                throw ValidationException::withMessages([
                    'friend_ids' => 'You cannot share a post with yourself.',
                ]);
            }

            $acceptedFriendIds = Friendship::where('status', 'accepted')
                ->where(function ($query) use ($user, $friendIds) {
                    $query->where(function ($q) use ($user, $friendIds) {
                        $q->where('sender_id', $user->id)
                            ->whereIn('receiver_id', $friendIds);
                    })->orWhere(function ($q) use ($user, $friendIds) {
                        $q->where('receiver_id', $user->id)
                            ->whereIn('sender_id', $friendIds);
                    });
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
                ->values();

            if ($acceptedFriendIds->count() !== count($friendIds)) {
                abort(403, 'One or more selected users are not your friends.');
            }

            $validFriends = User::whereIn('id', $friendIds)
                ->where('role', 0)
                ->where('status', 1)
                ->whereNotIn('id', $hiddenUserIds)
                ->pluck('id')
                ->map(fn($id) => (int) $id);

            if ($validFriends->count() !== count($friendIds)) {
                abort(403, 'One or more selected friends are unavailable.');
            }
        }

        /*
         * Validate all selected groups belong to the current user.
         */
        $groups = collect();

        if (! empty($groupIds)) {
            $groups = FriendChatGroup::whereIn('id', $groupIds)
                ->whereHas('members', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->get();

            if ($groups->count() !== count($groupIds)) {
                abort(403, 'You are not a member of one or more selected groups.');
            }
        }

        $senderName = trim(
            ($user->first_name ?? '') . ' ' .
            ($user->last_name ?? '')
        );

        if ($senderName === '') {
            $senderName = 'Someone';
        }

        $sharedCount  = 0;
        $originalName = basename($sourcePath);

        /*
         * Direct messages: preserve the existing ChatMessage format
         * and use the existing MessageSent event.
         */
        foreach ($friendIds as $friendId) {
            $targetPath = 'friend-chat/' . $user->id . '/' .
            Str::uuid() . '-' . $originalName;

            Storage::disk('public')->makeDirectory(
                'friend-chat/' . $user->id
            );

            if (! Storage::disk('public')->copy($sourcePath, $targetPath)) {
                throw new \RuntimeException('Could not copy post media.');
            }

            $messageText = 'Shared a post: ' . $postUrl;

            $chatMessage = ChatMessage::create([
                'sender_id'       => $user->id,
                'receiver_id'     => $friendId,
                'message'         => Crypt::encryptString($messageText),
                'attachment_path' => $targetPath,
                'attachment_name' => $originalName,
                'attachment_mime' => $mime,
                'attachment_size' => Storage::disk('public')->size($targetPath),
            ]);

            event(new MessageSent(
                $messageText,
                $user->id,
                $friendId,
                $chatMessage->id,
                asset(Storage::disk('public')->url($targetPath)),
                $originalName,
                $mime,
                Storage::disk('public')->size($targetPath),
                $chatMessage->created_at?->toISOString()
            ));

            $this->sendFirebaseSafe(
                (int) $friendId,
                $senderName,
                'Shared a post with you',
                [
                    'type'        => 'post_share',
                    'sender_id'   => (string) $user->id,
                    'receiver_id' => (string) $friendId,
                    'post_id'     => (string) $post->id,
                ]
            );

            $sharedCount++;
        }

        /*
         * Friend-group messages use their existing database model.
         * The existing group-chat event is intentionally not modified.
         */
        foreach ($groups as $group) {
            $targetDirectory = 'friend-chat-groups/' .
            $group->id . '/attachments';

            $targetPath = $targetDirectory . '/' .
            Str::uuid() . '-' . $originalName;

            Storage::disk('public')->makeDirectory($targetDirectory);

            if (! Storage::disk('public')->copy($sourcePath, $targetPath)) {
                throw new \RuntimeException('Could not copy post media.');
            }

            FriendChatGroupMessage::create([
                'group_id'        => $group->id,
                'user_id'         => $user->id,
                'message'         => 'Shared a post: ' . $postUrl,
                'attachment_path' => $targetPath,
                'attachment_name' => $originalName,
                'attachment_mime' => $mime,
                'attachment_size' => Storage::disk('public')->size($targetPath),
            ]);

            $groupMemberIds = $group->members()
                ->where('users.id', '!=', $user->id)
                ->pluck('users.id');

            foreach ($groupMemberIds as $memberId) {

                $this->sendFirebaseSafe(
                    (int) $memberId,
                    $senderName,
                    'Shared a post in a group',
                    [
                        'type'        => 'post_share',
                        'sender_id'   => (string) $user->id,
                        'receiver_id' => (string) $memberId,
                        'post_id'     => (string) $post->id,
                        'group_id'    => (string) $group->id,
                    ]
                );
            }

            $sharedCount++;
        }

        return response()->json([
            'success'      => true,
            'message'      => 'Post shared successfully.',
            'shared_count' => $sharedCount,
            'redirect_url' => route('messages'),
        ]);
    }

    private function sendFirebaseSafe(
        int $userId,
        string $title,
        string $body,
        array $data = []
    ): void {

        $tokens = UserDevice::where('user_id', $userId)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token')
            ->unique();

        if ($tokens->isEmpty()) {
            return;
        }

        foreach ($tokens as $token) {
            try {
                app(FirebaseNotificationService::class)->send(
                    $token,
                    $title,
                    $body,
                    $data
                );

            } catch (\Throwable $e) {

                Log::warning('Post share Firebase notification failed', [
                    'user_id' => $userId,
                    'error'   => $e->getMessage(),
                ]);
            }
        }
    }
}
