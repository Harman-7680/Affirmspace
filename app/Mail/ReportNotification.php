<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $reportData;

    /**
     * Create a new message instance.
     */
    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Report Submitted')
            ->view('emails.report_notification')
            ->with('reportData', $this->reportData);
    }
}
