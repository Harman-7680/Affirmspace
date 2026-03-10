<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Comment;
use App\Models\Post;
use App\Models\UserDevice;
use App\Notifications\CommentRepliedNotification;
use App\Notifications\FriendNewPostNotification;
use App\Notifications\PostCommentedNotification;
use App\Notifications\PostLikedNotification;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiPostController extends Controller
{
    public function store(Request $request)
    {
        $auth = Auth::user();

        $request->validate([
            'media'   => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:102400',
            'caption' => 'nullable|string|max:255',
        ]);

        // Upload media
        $path = $request->file('media')->store('posts', 'public');

        // Create post
        $post = Post::create([
            'user_id'    => $auth->id,
            'caption'    => $request->caption,
            'post_image' => $path,
        ]);

        $friends = $auth->friendsList();

        foreach ($friends as $friend) {
            $friend->notify(new FriendNewPostNotification($post));

            $this->sendFirebaseSafe(
                $friend->id,
                'New Post 📸',
                $auth->first_name . ' shared a new post',
                [
                    'type'    => 'new_post',
                    'post_id' => (string) $post->id,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Post uploaded successfully.',
            'post'    => $post,
        ], 201);
    }

    /**
     * Update an existing post (caption + optional new image).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $post = Post::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (! $post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found or unauthorized.',
            ], 404);
        }

        $post->caption = $request->caption;

        if ($request->hasFile('image')) {
            if ($post->post_image && Storage::disk('public')->exists($post->post_image)) {
                Storage::disk('public')->delete($post->post_image);
            }

            $path             = $request->file('image')->store('post_images', 'public');
            $post->post_image = $path;
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully.',
            'post'    => $post,
        ]);
    }

    /**
     * Delete a post.
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (! $post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found or unauthorized.',
            ], 404);
        }

        if ($post->post_image && Storage::disk('public')->exists($post->post_image)) {
            Storage::disk('public')->delete($post->post_image);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.',
        ]);
    }

    /**
     * List all posts of logged-in user.
     */
    public function myPosts()
    {
        $auth  = Auth::user();
        $posts = Post::where('user_id', $auth->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'user'    => $auth,
            'posts'   => $posts,
        ]);
    }

    public function toggleLike(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        try {
            $post = Post::findOrFail($request->post_id);
            $user = auth()->user();

            $existing = $post->likes()->where('user_id', $user->id)->first();

            if ($existing) {

                // Unlike
                $existing->delete();
                $status = 'unliked';

            } else {

                // Like
                $post->likes()->create(['user_id' => $user->id]);
                $status = 'liked';

                // Send notification only if:
                // 1. Not liking own post
                // 2. Notification not already sent before
                if ($post->user_id != $user->id) {

                    $alreadyNotified = \DB::table('notifications')
                        ->where('notifiable_id', $post->user_id)
                        ->where('type', 'App\\Notifications\\PostLikedNotification')
                        ->where('data->post_id', $post->id)
                        ->where('data->liker_id', $user->id)
                        ->exists();

                    if (! $alreadyNotified) {
                        $post->user->notify(new PostLikedNotification($post, $user));

                        $this->sendFirebaseSafe(
                            $post->user_id,
                            'Post Liked ❤️',
                            $user->first_name . ' liked your post',
                            [
                                'type'    => 'post_liked',
                                'post_id' => (string) $post->id,
                            ]
                        );
                    }
                }
            }

            return response()->json([
                'success'     => true,
                'status'      => $status,
                'likes_count' => $post->likes()->count(),
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Like Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    // Store a new comment
    public function comment_store(Request $request)
    {
        $request->validate([
            'comment'   => 'required|string|max:1000',
            'post_id'   => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        try {

            $user = auth()->user();
            $post = Post::findOrFail($request->post_id);

            // Create comment or reply
            $comment = Comment::create([
                'user_id'   => $user->id,
                'post_id'   => $post->id,
                'body'      => $request->comment,
                'parent_id' => $request->parent_id,
            ]);

            $comment->load('user');

            /*
        |---------------------------------------------------------------
        | CASE 1: Reply Notification (if parent_id is NOT null)
        |---------------------------------------------------------------
        */
            if ($comment->parent_id) {

                $parentComment = Comment::find($comment->parent_id);

                // Do NOT notify yourself
                if ($parentComment && $parentComment->user_id != $user->id) {

                    // Avoid duplicate notifications
                    $alreadyNotifiedReply = \DB::table('notifications')
                        ->where('notifiable_id', $parentComment->user_id)
                        ->where('type', 'App\\Notifications\\CommentRepliedNotification')
                        ->where('data->reply_id', $comment->id)
                        ->exists();

                    if (! $alreadyNotifiedReply) {
                        $parentComment->user->notify(
                            new CommentRepliedNotification($comment, $user)
                        );

                        $this->sendFirebaseSafe(
                            $parentComment->user_id,
                            'New Reply 💬',
                            $user->first_name . ' replied to your comment',
                            [
                                'type'       => 'comment_reply',
                                'comment_id' => (string) $comment->id,
                                'post_id'    => (string) $post->id,
                            ]
                        );
                    }
                }
            }

            /*
        |---------------------------------------------------------------
        | CASE 2: Post Comment Notification (only for fresh comments)
        |---------------------------------------------------------------
        */
            else if ($post->user_id != $user->id) {

                // Avoid duplicates for same user on same post
                $alreadyNotified = \DB::table('notifications')
                    ->where('notifiable_id', $post->user_id)
                    ->where('type', 'App\\Notifications\\PostCommentedNotification')
                    ->where('data->post_id', $post->id)
                    ->where('data->actor_id', $user->id)
                    ->exists();

                if (! $alreadyNotified) {
                    $post->user->notify(new PostCommentedNotification($comment, $user));

                    $this->sendFirebaseSafe(
                        $post->user_id,
                        'New Comment 💬',
                        $user->first_name . ' commented on your post',
                        [
                            'type'       => 'post_comment',
                            'comment_id' => (string) $comment->id,
                            'post_id'    => (string) $post->id,
                        ]
                    );
                }
            }

            /*
        |---------------------------------------------------------------
        | API JSON RESPONSE
        |---------------------------------------------------------------
        */
            return response()->json([
                'success' => true,
                'comment' => [
                    'id'         => $comment->id,
                    'body'       => $comment->body,
                    'first_name' => $comment->user->first_name,
                    'last_name'  => $comment->user->last_name,
                    'image'      => $comment->user->image
                        ? asset('storage/' . $comment->user->image)
                        : asset('images/avatars/avatar-1.jpg'),
                    'parent_id'  => $comment->parent_id,
                ],
            ], 201);

        } catch (\Throwable $e) {

            \Log::error('API Comment Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    // Delete a comment
    public function comment_destroy($id)
    {
        $comment = Comment::where('id', $id)
            ->where('user_id', auth()->id()) // Ensure only owner can delete
            ->firstOrFail();

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
        ]);
    }

    public function showApi($id)
    {
        $auth = Auth::user();

        if ($auth->role != 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Blocked post
        if (Block::where('user_id', $auth->id)
            ->where('post_id', $id)
            ->exists()) {

            return response()->json([
                'status'  => false,
                'message' => 'You have blocked this post.',
            ]);
        }

        $blockedUsers = Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        $post = Post::with([
            'user',
            'likes',
            'comments.user',
            'comments.replies.user',
        ])->where('id', $id)->first();

        if (! $post) {
            return response()->json([
                'status'  => false,
                'message' => 'Post not found.',
            ]);
        }

        if (in_array($post->user_id, $hiddenUsers)) {
            return response()->json([
                'status'  => false,
                'message' => 'You cannot view this post.',
            ]);
        }

        if ($post->user->is_private) {

            $friends  = $auth->friendsList()->pluck('id')->toArray();
            $isFriend = in_array($post->user->id, $friends);

            if ($post->user_id !== $auth->id && ! $isFriend) {
                return response()->json([
                    'status'  => false,
                    'message' => 'This account is private.',
                ]);
            }
        }

        if (
            Block::where('user_id', $post->user_id)
            ->where('blocked_id', $auth->id)
            ->exists()
        ) {
            return response()->json([
                'status'  => false,
                'message' => 'This user has blocked you.',
            ]);
        }

        $post->total_comments =
        $post->comments->count() +
        $post->comments->sum(fn($c) => $c->replies->count());

        return response()->json([
            'status' => true,
            'post'   => $post,
        ]);
    }

    private function sendFirebaseSafe($userId, $title, $body, array $data = [])
    {
        $tokens = UserDevice::where('user_id', $userId)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token');

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
                Log::warning("Firebase push skipped (user {$userId}): " . $e->getMessage());
            }
        }
    }
}
