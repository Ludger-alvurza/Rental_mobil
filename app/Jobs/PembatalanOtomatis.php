<?php

namespace App\Jobs;

use App\Models\bkuser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PembatalanOtomatis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bkuserId;

    /**
     * Create a new job instance.
     */
    public function __construct($bkuserId)
    {
        $this->bkuserId = $bkuserId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Job PembatalanOtomatis dijalankan untuk pesanan ID: ' . $this->bkuserId);

        $bkuser = bkuser::find($this->bkuserId);

        if ($bkuser) {
            Log::info('Status pembatalan saat ini untuk pesanan ID ' . $this->bkuserId . ': ' . $bkuser->pembatalan);

            // Cek apakah status pembatalan adalah "Terverifikasi"
            if ($bkuser->pembatalan === 'Terverifikasi') {
                // Logika untuk pembatalan
                $bkuser->pembatalan = 'Dibatalkan';

                if ($bkuser->save()) {
                    Log::info('Status pembatalan pesanan ID ' . $this->bkuserId . ' berhasil diubah menjadi Dibatalkan.');
                } else {
                    Log::error('Gagal menyimpan perubahan status pembatalan untuk pesanan ID ' . $this->bkuserId . '.');
                }
            } 
            // Cek apakah status pembatalan adalah "Dipesan"
            elseif ($bkuser->pembatalan === 'Dipesan') {
                // Logika untuk pembatalan
                $bkuser->pembatalan = 'Dibatalkan';

                if ($bkuser->save()) {
                    Log::info('Status pembatalan pesanan ID ' . $this->bkuserId . ' berhasil diubah menjadi Dibatalkan.');
                } else {
                    Log::error('Gagal menyimpan perubahan status pembatalan untuk pesanan ID ' . $this->bkuserId . '.');
                }
            } else {
                Log::info('Pesanan ID ' . $this->bkuserId . ' tidak dalam status Terverifikasi atau Dipesan, tidak perlu dibatalkan.');
            }
        } else {
            Log::error('Pesanan dengan ID ' . $this->bkuserId . ' tidak ditemukan.');
        }
    }
}
