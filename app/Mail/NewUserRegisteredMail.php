<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $totalCounselees;
    public $totalCounselors;

    public function __construct(
        User $user,
        $totalCounselees,
        $totalCounselors
    ) {
        $this->user            = $user;
        $this->totalCounselees = $totalCounselees;
        $this->totalCounselors = $totalCounselors;
    }

    public function build()
    {
        return $this->subject('New User Registered')
            ->view('emails.new-user-registered');
    }
}
