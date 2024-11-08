<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeminjamanSelesaiNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $peminjaman;

    /**
     * Create a new notification instance.
     *
     * @param mixed $peminjaman
     */
    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
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
            ->view('content.notifications.peminjaman_selesai', [
                'user' => $notifiable,
                'peminjaman' => $this->peminjaman,
            ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'peminjaman_id' => $this->peminjaman->id,
            'mobil_id' => $this->peminjaman->mobil->id,
            'message' => 'Pengembalian mobil telah dikonfirmasi.'
        ];
    }
}
