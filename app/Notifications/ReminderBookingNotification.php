<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class ReminderBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     *
     * @param mixed $booking
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail']; // 'nexmo' untuk SMS
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Reminder Booking')
        ->view('content.notifications.reminder_booking', [
            'user' => $notifiable,
            'booking' => $this->booking,
        ]);
    }

    /**
     * Get the SMS representation of the notification.
     */
    // public function toNexmo($notifiable): NexmoMessage
    // {
    //     return (new NexmoMessage)
    //                 ->content('Reminder: Anda memiliki jadwal rental pada ' . $this->booking->tanggal_rental . '. Cek detail di aplikasi.');
    // }
}
