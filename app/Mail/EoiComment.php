<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EoiComment extends Mailable
{
    use Queueable, SerializesModels;

    public $description;
    public $user;
    public $wsp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($description,$wsp)
    {
        $this->description = $description;
        $this->user = auth()->user();
        $this->wsp = $wsp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Eoi Comment")
        ->markdown('emails.eoi.comments');
    }
}
