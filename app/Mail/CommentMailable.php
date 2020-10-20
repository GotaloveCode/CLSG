<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $description;
    public $user;
    public $subject;
    public $route;

    /**
     * Create a new message instance.
     *
     * @param $description
     * @param $subject
     * @param $route
     */
    public function __construct($description, $subject, $route)
    {
        $this->description = $description;
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
            ->markdown('emails.comments');
    }
}
