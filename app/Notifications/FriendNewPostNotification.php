<?php
namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FriendNewPostNotification extends Notification
{
    use Queueable;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'     => 'new_post',
            'post_id'  => $this->post->id,
            'user_id'  => $this->post->user_id,
            'username' => $this->post->user->first_name,
            'caption'  => $this->post->caption,
            'image'    => $this->post->post_image,
            'message'  => $this->post->user->first_name . " uploaded a new post.",
        ];
    }
}
