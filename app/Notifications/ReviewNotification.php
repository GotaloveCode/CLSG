<?php

namespace App\Notifications;

use App\Models\Wsp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewNotification extends Notification
{
    use Queueable;

    public $wsp, $url, $subject, $body;

    /**
     * Create a new notification instance.
     *
     * @param Wsp $wsp
     * @param $url
     * @param $subject
     * @param $body
     */
    public function __construct(Wsp $wsp, $url, $subject, $body)
    {
        $this->wsp = $wsp;
        $this->url = $url;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->body)
            ->action('View', url($this->url))
            ->line(config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'url' => $this->url,
            'title' => $this->subject,
            'details' => strip_tags($this->body)
        ];
    }
}
