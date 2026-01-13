<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminBroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $messageText;
    public string $userName;

    public function __construct(string $messageText, string $userName)
    {
        $this->messageText = $messageText;
        $this->userName    = $userName;
    }

    public function build()
    {
        return $this->subject('📢 Message from Admin')
            ->view('emails.admin_broadcast');
    }
}
