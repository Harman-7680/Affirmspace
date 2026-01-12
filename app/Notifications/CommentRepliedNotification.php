<?php
namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentRepliedNotification extends Notification
{
    use Queueable;

    public $reply;
    public $actor;

    public function __construct(Comment $reply, $actor)
    {
        $this->reply = $reply;
        $this->actor = $actor;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'comment_replied',
            'post_id'    => $this->reply->post_id,
            'reply_id'   => $this->reply->id,
            'actor_id'   => $this->actor->id,
            'actor_name' => $this->actor->first_name,
            'parent_id'  => $this->reply->parent_id,
            'reply_body' => $this->reply->body,
            'message'    => $this->actor->first_name . ' replied to your comment',
        ];
    }
}
