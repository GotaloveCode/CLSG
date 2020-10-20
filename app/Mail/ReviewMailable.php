<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $user;
    public $subject;
    public $route;

    /**
     * Create a new message instance.
     *
     * @param $status
     * @param $subject
     * @param $route
     */
    public function __construct($status, $subject, $route)
    {
        $this->status = $status;
        $this->route = $route;
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
            ->markdown('emails.review');
    }
}
