<?php

namespace App\Console\Commands;

use App\Models\bkuser;
use App\Models\Mobil;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class UpdateCarAvailability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'car:update-availability';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update availability of cars based on booking dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Mulai pengecekan availability mobil.');

        // Ambil semua mobil yang ada
        $mobils = Mobil::all();

        foreach ($mobils as $mobil) {
            Log::info("Cek mobil ID {$mobil->id}.");

            // Ambil semua booking untuk mobil ini berdasarkan mobil_id
            $bookings = bkuser::where('id_mobil', $mobil->id)->get();

            // Hitung total hari booking
            $totalDays = 0;
            foreach ($bookings as $booking) {
                $bookingStart = Carbon::parse($booking->booking_start);
                $bookingEnd = Carbon::parse($booking->booking_end);

                // Tambahkan jumlah hari dari booking ini ke total
                $totalDays += $bookingStart->diffInDays($bookingEnd);
            }

            Log::info("Total booking days for Mobil ID {$mobil->id}: {$totalDays} days.");

            // Update status mobil jika total hari booking lebih dari 30
            if ($totalDays === 30) {
                $mobil->update(['availability' => 'Sold Out']);
                $this->info("Mobil ID {$mobil->id} status updated to soldout.");
                Log::info("Mobil ID {$mobil->id} status updated to soldout.");
            } else {
                Log::info("Mobil ID {$mobil->id} tidak perlu di-update.");
            }
        }

        Log::info('Selesai pengecekan availability mobil.');
    }

}
