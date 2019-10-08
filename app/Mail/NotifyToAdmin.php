<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $maildata;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildata)
    {
        $this->maildata = $maildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->maildata['adminEmail'], $this->maildata['adminName'])
                    ->from($this->maildata['email'], $this->maildata['name'])
                    ->subject($this->maildata['adminSubject'])
                    ->view('emails.NotifyToAdmin')
                    ->with('maildata', $this->maildata);
    }
}
