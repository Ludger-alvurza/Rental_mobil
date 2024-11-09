<?php

namespace App\Console;

use App\Models\bkuser;
use App\Models\User;
use App\Notifications\ReminderBookingNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Notification;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->command('booking:reminder')->daily();
    $schedule->command('app:calculate-denda')->dailyAt('00:00');
    $schedule->command('car:update-availability')->daily();
}




    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
