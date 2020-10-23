<?php

namespace App\Notifications;

use App\Models\Wsp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    public $wsp, $url, $subject, $comment;

    /**
     * Create a new notification instance.
     *
     * @param Wsp $wsp
     * @param $url
     * @param $subject
     * @param $comment
     */
    public function __construct(Wsp $wsp, $url, $subject, $comment)
    {
        $this->wsp = $wsp;
        $this->url = $url;
        $this->subject = $subject;
        $this->comment = $comment;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->comment)
            ->action('View', url($this->url))
            ->line(config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'url' => $this->url,
            'title' => $this->subject,
            'details' => $this->comment
        ];
    }
}
