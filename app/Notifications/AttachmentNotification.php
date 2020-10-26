<?php

namespace App\Notifications;

use App\Models\Attachment;
use App\Models\Wsp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttachmentNotification extends Notification
{
    use Queueable;

    public $attachment, $url, $wsp;

    /**
     * Create a new notification instance.
     *
     * @param Attachment $attachment
     * @param Wsp $wsp
     * @param $url
     */
    public function __construct(Attachment $attachment,Wsp $wsp, $url)
    {
        $this->wsp = $wsp;
        $this->attachment = $attachment;
        $this->url = $url;
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
            ->subject($this->attachment->document_type . ' Uploaded')
            ->line($this->attachment->document_type .' has been uploaded by ' . $this->wsp->name)
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
            'title' => $this->attachment->document_type . ' Uploaded',
            'details' => $this->attachment->document_type . ' has been uploaded by ' . $this->wsp->name
        ];
    }
}
