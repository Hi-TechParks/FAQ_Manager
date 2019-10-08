<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyToVisitor extends Mailable
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
        return $this->to($this->maildata['email'], $this->maildata['name'])
                    ->from($this->maildata['appMail'], $this->maildata['appName'])
                    ->subject($this->maildata['subject'])
                    ->view('emails.NotifyToVisitor')
                    ->with('maildata', $this->maildata);
    }
}
