<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    use Queueable;

    protected $follower;

    public function __construct($follower)
    {
        $this->follower = $follower;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'follower_id'    => $this->follower->id,
            'follower_name'  => $this->follower->first_name,
            'follower_image' => $this->follower->image,
            'message'        => $this->follower->first_name . ' sent you a friend request',
        ];
    }
}
