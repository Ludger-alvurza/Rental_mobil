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
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Pengembalian mobil dengan nama "' . $this->peminjaman->mobil->name . '" telah berhasil dikonfirmasi.')
                    ->line('Anda dapat memberikan rating untuk pengalaman peminjaman ini.')
                    ->action('Berikan Rating', url('/message_ratings/review/' . $this->peminjaman->mobil->id))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
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
