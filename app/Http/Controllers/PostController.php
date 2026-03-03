<?php
namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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

class PostController extends Controller
{
    public function store(Request $request)
    {
        $auth = Auth::user();

        $request->validate([
            'media'   => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:102400',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('media')->store('posts', 'public');

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

        return redirect()->back()->with('success', 'Post uploaded successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|',
        ]);

        $post          = Post::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $post->caption = $request->caption;

        if ($request->hasFile('image')) {
            if ($post->post_image && Storage::disk('public')->exists($post->post_image)) {
                Storage::disk('public')->delete($post->post_image);
            }

            $path             = $request->file('image')->store('post_images', 'public');
            $post->post_image = $path;
        }

        $post->save();

        return back()->with('success', 'Post updated successfully!');
    }

    public function post_destroy($id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', Auth::id()) // only allow owner
            ->first();

        if (! $post) {
            return redirect()->back()->with('error', 'Post not found or unauthorized.');
        }

        // Delete image if exists
        if ($post->post_image && Storage::disk('public')->exists($post->post_image)) {
            Storage::disk('public')->delete($post->post_image);
        }

        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }

    public function toggleLike(Request $request)
    {
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

                if ($post->user_id != $user->id) {

                    $alreadyNotified = \DB::table('notifications')
                        ->where('notifiable_id', $post->user_id)
                        ->where('type', 'App\Notifications\PostLikedNotification')
                        ->where('data->post_id', $post->id)
                        ->where('data->liker_id', $user->id)
                        ->exists();

                    if (! $alreadyNotified) {

                        // DB notification
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
                'status'      => $status,
                'likes_count' => $post->likes()->count(),
            ]);

        } catch (\Throwable $e) {
            Log::error('Like Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

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

            // Create comment
            $comment = Comment::create([
                'user_id'   => $user->id,
                'post_id'   => $post->id,
                'body'      => $request->comment,
                'parent_id' => $request->parent_id,
            ]);

            $comment->load('user');

            $totalComments = Comment::where('post_id', $post->id)->count();

            /*
        |-----------------------------------------------------------
        | CASE 1: Reply Notification  (parent_id != null)
        |-----------------------------------------------------------
        */
            if ($comment->parent_id) {
                $parentComment = Comment::find($comment->parent_id);

                // Do NOT notify yourself
                if ($parentComment && $parentComment->user_id != $user->id) {

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
        |-----------------------------------------------------------
        | CASE 2: Post Comment Notification (not a reply)
        |-----------------------------------------------------------
        */
            else if ($post->user_id != $user->id) {

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

            // Return API response
            return response()->json([
                'success'        => true,
                'comment'        => [
                    'id'         => $comment->id,
                    'body'       => $comment->body,
                    'first_name' => $comment->user->first_name,
                    'last_name'  => $comment->user->last_name,
                    'image'      => $comment->user->image
                        ? asset('storage/' . $comment->user->image)
                        : asset('images/avatars/avatar-1.jpg'),
                    'parent_id'  => $comment->parent_id,
                ],
                'total_comments' => $totalComments,
            ]);

        } catch (\Throwable $e) {

            Log::error("Comment Error: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function destroy(Comment $comment)
    {
        $postId = $comment->post_id;
        $comment->delete();
        $totalComments = \App\Models\Comment::where('post_id', $postId)->count();

        return response()->json([
            'success'        => true,
            'total_comments' => $totalComments,
            'message'        => 'Comment deleted successfully',
        ]);
    }

    public function show($id)
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403);

        $notifications = $auth->unreadNotifications;
        $friends       = $auth->friendsList()->pluck('id')->toArray();

        // Individually blocked post
        if (Block::where('user_id', $auth->id)
            ->where('post_id', $id)
            ->exists()) {

            return redirect()->route('feed')
                ->with('error', 'You have blocked this post.');
        }

        $blockedUsers = Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        $post = Post::with(['user', 'likes', 'comments.user', 'comments.replies.user'])
            ->where('id', $id)
            ->first();

        if (! $post) {
            return redirect()->route('feed')
                ->with('error', 'Post not found.');
        }

        if (in_array($post->user_id, $hiddenUsers)) {
            return redirect()->route('feed')
                ->with('error', 'You cannot view this post.');
        }

        if ($post->user->is_private) {

            $isFriend = in_array($post->user->id, $friends);

            if ($post->user_id !== $auth->id && ! $isFriend) {
                return redirect()->route('feed')
                    ->with('error', 'This account is private.');
            }
        }

        if (
            Block::where('user_id', $post->user_id)
            ->where('blocked_id', $auth->id)
            ->exists()
        ) {
            return redirect()->route('feed')
                ->with('error', 'This user has blocked you.');
        }

        $post->total_comments =
        $post->comments->count() +
        $post->comments->sum(fn($c) => $c->replies->count());

        return view('user.post', [
            'user'          => $auth,
            'notifications' => $notifications,
            'post'          => $post,
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
