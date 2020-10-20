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
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content,$subject)
    {
        $this->content = $content;
        $this->user = auth()->user();
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
         ->markdown('emails.eois.review');
    }
}
