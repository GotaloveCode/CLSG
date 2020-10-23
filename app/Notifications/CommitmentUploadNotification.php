<?php

namespace App\Notifications;

use App\Models\Wsp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommitmentUploadNotification extends Notification
{
    use Queueable;

    public $uploader, $wsp, $url;

    /**
     * Create a new notification instance.
     *
     * @param Wsp $wsp
     * @param $uploader
     */
    public function __construct(Wsp $wsp, $uploader)
    {
        $this->wsp = $wsp;
        $this->uploader = $uploader;
        $this->url = route('eois.commitment_letter', $wsp->eoi->id);
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
            ->subject('Commitment Letter Uploaded')
            ->line('A commitment letter for ' . $this->wsp->name . ' has been uploaded by ' . $this->uploader)
            ->action('View Commitment', url($this->url))
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
            'wsp' => $this->wsp->name,
            'url' => $this->url,
            'title' => 'Commitment Letter Uploaded',
            'details' => 'A commitment letter for ' . $this->wsp->name . ' has been uploaded by ' . $this->uploader
        ];
    }
}
