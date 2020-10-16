<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WspCreatedMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $wsp, $password;


    public function __construct($wsp, $password)
    {
        $this->wsp = $wsp;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('WSP Account Created')->markdown('emails.wsp_created');
    }
}
