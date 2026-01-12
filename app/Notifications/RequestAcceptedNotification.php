<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RequestAcceptedNotification extends Notification
{
    use Queueable;

    protected $receiver;

    public function __construct($receiver)
    {
        $this->receiver = $receiver;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'           => 'friend_request_accepted',
            'receiver_id'    => $this->receiver->id,
            'receiver_name'  => $this->receiver->first_name,
            'receiver_image' => $this->receiver->image,
            'message'        => "{$this->receiver->first_name} accepted your friend request.",
        ];

    }
}
