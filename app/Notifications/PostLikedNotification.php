<?php
namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostLikedNotification extends Notification
{
    use Queueable;

    public $post;
    public $liker;

    public function __construct(Post $post, $liker)
    {
        $this->post  = $post;
        $this->liker = $liker;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'post_liked',
            'post_id'    => $this->post->id,
            'liker_id'   => $this->liker->id,
            'liker_name' => $this->liker->first_name,
            'message'    => $this->liker->first_name . ' liked your post',
        ];
    }
}
