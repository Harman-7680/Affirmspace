<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string|null $reason
     */
    public function __construct($user, $reason = null)
    {
        $this->user   = $user;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Profile Verification was Rejected')
            ->view('emails.verification-rejected')
            ->with([
                'user'   => $this->user,
                'reason' => $this->reason,
            ]);
    }
}
