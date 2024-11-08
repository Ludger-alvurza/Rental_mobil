<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;

class CalculateDenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-denda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghitung dan menerapkan denda untuk transaksi yang melewati tanggal booking_end';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil semua transaksi dengan relasi bookings
        $transactions = Transaction::with('bookings')->get();

        foreach ($transactions as $transaction) {
            // Panggil method calculateDenda di setiap transaksi
            $transaction->calculateDenda();
        }

        // Tampilkan pesan sukses di console
        $this->info('Denda berhasil dihitung dan diterapkan untuk semua transaksi.');
    }
}
