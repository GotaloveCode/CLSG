<?php

namespace App\Notifications;

use App\Models\Eoi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EoiSubmittedNotification extends Notification
{
    use Queueable;

    public $eoi;

    /**
     * Create a new notification instance.
     *
     * @param Eoi $eoi
     */
    public function __construct(Eoi $eoi)
    {
        $this->eoi = $eoi;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
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
            ->subject('Expression of Interest Submitted')
            ->line('The Expression of interest by ' . $this->eoi->wsp->name)
            ->action('Review', route('eois.show', $this->eoi->id))
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
            'wsp' => $this->eoi->wsp->name,
            'url' => $this->url,
            'title' => 'Expression of Interest Submitted',
            'details' => 'The Expression of interest by ' . $this->wsp->name . ' has been uploaded by ' . $this->uploader
        ];
    }
}
