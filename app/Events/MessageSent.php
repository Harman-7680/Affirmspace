<?php
// namespace App\Events;

// use Illuminate\Broadcasting\Channel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
// use Illuminate\Queue\SerializesModels;

// class MessageSent implements ShouldBroadcastNow
// {
//     use SerializesModels;

//     public $message;
//     public $sender_id;
//     public $receiver_id;
//     public $id;

//     public function __construct($message, $sender_id, $receiver_id, $id)
//     {
//         $this->message     = $message;
//         $this->sender_id   = $sender_id;
//         $this->receiver_id = $receiver_id;
//         $this->id          = $id;
//     }

//     public function broadcastOn()
//     {
//         $room = $this->sender_id < $this->receiver_id
//             ? $this->sender_id . '_' . $this->receiver_id
//             : $this->receiver_id . '_' . $this->sender_id;

//         return new Channel('chat.' . $room);
//     }

//     public function broadcastAs()
//     {
//         return 'MessageSent';
//     }
// }

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use SerializesModels;

    public $message;
    public $sender_id;
    public $receiver_id;
    public $id;

    public $attachment_url;
    public $attachment_name;
    public $attachment_mime;
    public $attachment_size;
    public $created_at;

    public function __construct(
        $message,
        $sender_id,
        $receiver_id,
        $id,
        $attachment_url = null,
        $attachment_name = null,
        $attachment_mime = null,
        $attachment_size = null,
        $created_at = null
    ) {
        $this->message         = $message;
        $this->sender_id       = $sender_id;
        $this->receiver_id     = $receiver_id;
        $this->id              = $id;
        $this->attachment_url  = $attachment_url;
        $this->attachment_name = $attachment_name;
        $this->attachment_mime = $attachment_mime;
        $this->attachment_size = $attachment_size;
        $this->created_at      = $created_at;
    }

    public function broadcastOn()
    {
        $room = $this->sender_id < $this->receiver_id
            ? $this->sender_id . '_' . $this->receiver_id
            : $this->receiver_id . '_' . $this->sender_id;

        return new Channel('chat.' . $room);
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
}
