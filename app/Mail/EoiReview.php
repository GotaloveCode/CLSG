<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EoiReview extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $user;
    public $wsp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content,$wsp)
    {
        $this->content = $content;
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
        return $this->subject("EOI Review")
         ->markdown('emails.eoi.review');
    }
}
