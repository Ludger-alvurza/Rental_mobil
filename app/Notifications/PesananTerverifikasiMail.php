<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PesananTerverifikasiMail extends Notification
{
    use Queueable;
    protected $bkuser;
    /**
     * Create a new notification instance.
     */
    public function __construct($bkuser)
    {
        $this->bkuser = $bkuser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pesanan Anda Berhasil Diverifikasi')
            ->view('content.notifications.pesanan_terverifikasi', ['bkuser' => $this->bkuser]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
