<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'transactions';
    protected $fillable = ['id','id_transaction','total','denda'];

    public function ItemTransaction()
    {
        return $this->hasMany(ItemTransaction::class,'id_transaction','id');
    }
    public static function getLastCode($prefix)
    {
        $lastNumber = Transaction::query()->where('code','like',$prefix.'%')
        ->withTrashed()
        ->get()->count();

        return $prefix . str_pad(($lastNumber + 1),4,'0',STR_PAD_LEFT);
    }
    public function bookings()
    {
        return $this->hasMany(bkuser::class, 'id_transactions');
    }

    public function calculateDenda()
    {
        Log::info("Memulai perhitungan denda untuk Transaction ID {$this->id}");

        // Ambil semua ItemTransaction yang terkait dengan transaksi ini
        foreach ($this->ItemTransaction as $itemTransaction) {
            // Log::info("Memproses ItemTransaction ID: {$itemTransaction->id}");

            // Ambil relasi booking dari ItemTransaction menggunakan query manual
            $bookings = bkuser::where('id', $itemTransaction->id_booking)->get();

            // Periksa jika bookings ada atau tidak
            if ($bookings->isEmpty()) {
                // Log::info("ItemTransaction ID {$itemTransaction->id} tidak memiliki relasi booking.");
                continue; // Langsung lanjutkan ke ItemTransaction berikutnya jika tidak ada booking
            }

            foreach ($bookings as $booking) {
                // Log::info("Memproses Booking ID: {$booking->id} untuk ItemTransaction ID {$itemTransaction->id}");

                $now = now();
                $endDate = $booking->booking_end;

                // Log::info("Tanggal sekarang: {$now}, Tanggal berakhir booking: {$endDate}");

                // Kalau lewat dari booking_end, hitung denda
                if ($now->greaterThan($endDate)) {
                    // Logika untuk nilai denda, misalnya 10% dari total transaksi
                    $dendaAmount = $this->total * 0.1; // contoh denda 10%

                    // Log::info("Denda dihitung: {$dendaAmount}");

                    // Update nilai denda di transaksi ini
                    $this->denda = $dendaAmount;
                    $this->save();

                    // Log untuk melihat apakah denda diterapkan
                    // Log::info("Denda diterapkan pada Transaction ID {$this->id}, Denda: {$dendaAmount}");
                } else {
                    // Log::info("Booking ID {$booking->id} belum lewat dari tanggal berakhir. Tidak ada denda.");
                }
            }
        }

        // Log::info("Perhitungan denda selesai untuk Transaction ID {$this->id}");
    }



    
    protected static function booted()
    {
        static::retrieved(function ($transaction) {
            $transaction->calculateDenda();
        });
    }



}
