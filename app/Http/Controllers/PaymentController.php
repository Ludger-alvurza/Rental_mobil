<?php

namespace App\Http\Controllers;

use App\Models\bkuser;
use App\Models\ItemTransaction;
use App\Notifications\PaymentSuccess;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function createPayment(Request $request, $id)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil data pesanan
        $order = bkuser::findOrFail($id);
        $denda = ItemTransaction::where('id_booking', $id)->with('transaction', 'booking.user')->first();

        // Cek jika $denda atau $denda->transaction adalah null
        if ($denda && $denda->transaction) {
            $totalPrice = $denda->transaction->total;
        } else {
            // Redirect back dengan pesan jika totalPrice null
            return redirect()->back()->with('error', 'Tunggu sampai pesanan Anda diproses.');
        }

        // Cek jika totalPrice null
        if (is_null($totalPrice)) {
            return redirect()->back()->with('error', 'Tunggu sampai pesanan Anda diproses.');
        }

        $email = $denda->booking->user->email;
        // Data untuk request ke Midtrans
        $transaction = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . uniqid(),
                'gross_amount' => $totalPrice, // Ganti dengan harga pesanan
            ],
            'customer_details' => [
                'first_name' => $denda->booking->name,
                'email' => $email, // Ganti dengan email user
            ],
            'item_details' => [
                [
                    'id' => $order->id,
                    'price' => $totalPrice, // Ganti dengan harga item
                    'quantity' => 1,
                    'long_rental' => $order->lama_sewa,
                    'name' => $denda->booking->name_mobil,
                ]
            ]
        ];

        // Request ke Midtrans
        $snapToken = Snap::getSnapToken($transaction);
        return view('content.payments.checkout', compact('snapToken','order'));
    }

    public function notificationHandler(Request $request)
    {
        $payload = $request->all();
    
        // Verifikasi status pembayaran
        if ($payload['transaction_status'] === 'settlement') {
            // Ambil ID pesanan dari payload
            $orderId = $payload['order_id'];
    
            // Temukan pemesan berdasarkan ID pesanan
            $order = bkuser::where('order_id', $orderId)->first();
    
            if ($order) {
                // Kirim notifikasi ke pengguna
                $user = $order->booking->user; // Asumsi ada relasi booking ke user
                $user->notify(new PaymentSuccess($order)); // Ganti dengan notifikasi yang kamu buat
    
                // Perbarui status pesanan di database
                $order->update(['payment_status' => 'paid']);
            } else {
                // Log jika order tidak ditemukan
                // \Log::warning("Order tidak ditemukan untuk ID: $orderId");
            }
        } else {
            // Log jika status transaksi tidak 'settlement'
            // \Log::info("Status transaksi bukan 'settlement': " . $payload['transaction_status']);
        }
    }
    
}
