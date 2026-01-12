<?php
namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCommentedNotification extends Notification
{
    use Queueable;

    public $comment;
    public $actor; // the user who commented

    public function __construct(Comment $comment, $actor)
    {
        $this->comment = $comment;
        $this->actor   = $actor;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'post_commented',
            'post_id'      => $this->comment->post_id,
            'comment_id'   => $this->comment->id,
            'actor_id'     => $this->actor->id,
            'actor_name'   => $this->actor->first_name,
            'comment_body' => $this->comment->body,
            'message'      => $this->actor->first_name . ' commented on your post',
        ];
    }
}
