<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentStatusNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $status;

    public function __construct($message, $status)
    {
        $this->message = $message;
        $this->status  = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $counselor = $this->message->receiver;

        return [
            'type'            => 'appointment_status',
            'message_id'      => $this->message->id,
            'status'          => $this->status,

            // IMPORTANT
            'counselor_id'    => $counselor->id,
            'counselor_image' => $counselor->image ?? null,
            'counselor_name'  => $counselor->first_name ?? 'Counselor',

            'title'           => 'Appointment Update',
            'body'            => "{$this->status} your appointment",
        ];
    }
}
