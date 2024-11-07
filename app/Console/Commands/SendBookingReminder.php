<?php

namespace App\Console\Commands;

use App\Models\bkuser;
use App\Models\User;
use App\Notifications\ReminderBookingNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendBookingReminder extends Command
{
    protected $signature = 'booking:reminder';
    protected $description = 'Send reminder notifications for bookings';

    public function handle()
    {
        $dateReminder = now()->addDays(3)->toDateString(); // Ambil tanggal 3 hari ke depan
        $bookings = bkuser::whereDate('booking_start', $dateReminder)->get();

        if ($bookings->isEmpty()) {
            
            return;
        }

        foreach ($bookings as $booking) {
            $user = User::find($booking->id_user);
            if ($user) {
                Notification::send($user, new ReminderBookingNotification($booking));
            } else {

            }
        }
    }
}
