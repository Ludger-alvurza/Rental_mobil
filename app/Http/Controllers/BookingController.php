<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use App\Models\Mobil;
use App\Models\Product;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
public function index()
{
    $motor = Mobil::with('booking')->first();
    return view('content.booking.index',compact('motor'));
}

// Di controller
public function getMobil()
{
    // Ambil data mobil beserta relasi booking
    $mobils = Mobil::with('booking')->get();
    return response()->json($mobils);
}


public function searchProduct(Request $request)
{
    $motor = Mobil::query()->with('booking')->where('no_plat', $request->no_plat)->first();
    if($motor === null){
        return response()->json([],404);
    }
    return response()->json($motor);
}


    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            // Mengecek apakah price ada dan valid
            if (!isset($request->price) || !is_array($request->price) || empty($request->price)) {
                return redirect()->back()->with('Gagal', 'Tidak ada item yang valid untuk diproses.');
            }

            // Membuat kode transaksi baru
            $prefix = 'INV' . date('ym') . '/';
            $code = Transaction::getLastCode($prefix);
            $transaction = new Transaction();
            $transaction->code = $code;
            $transaction->date = date('y-m-d');
            $transaction->subtotal = 0;
            $transaction->discount = 0;
            $transaction->total = 0;
            $transaction->created_by = Auth::id();
            $transaction->save();

            $subtotal = 0;
            $itemCount = count($request->price);

            // Proses setiap item dalam transaksi
            for ($i = 0; $i < $itemCount; $i++) {
                // Periksa apakah price dan qty ada dan valid
                if (!empty($request->price[$i]) && !empty($request->qty[$i])) {
                    $it = new ItemTransaction();
                    $it->id_transaction = $transaction->id;
                    $it->id_mobil = $request->id_mobil[$i]; // id mobil
                    $it->price = $request->price[$i]; // harga per item
                    $it->qty = $request->qty[$i]; // jumlah
                    $it->total = (int)$it->price * (int)$it->qty; // total harga per item
                    $it->denda = $request->denda[$i] ?? 0; // denda (jika ada)
                    $it->denda1 = $request->denda1[$i] ?? 0; // denda1 (jika ada)
                    $it->denda2 = $request->denda2[$i] ?? 0; // denda2 (jika ada)
                    $it->denda3 = $request->denda3[$i] ?? 0; // denda3 (jika ada)
                    $it->id_booking = $request->id_booking[$i]; // id booking
                    $it->save();

                    // Tambahkan total harga ke subtotal
                    $subtotal += $it->total;
                }
            }

            // Jika tidak ada item yang valid
            if ($subtotal == 0) {
                DB::rollBack();
                return redirect()->back()->with('Gagal', 'Tidak ada item valid untuk diproses.');
            }

            // Menghitung subtotal, diskon, dan total
            $transaction->subtotal = $subtotal;
            $discount = ($subtotal * (int)$request->discount) / 100;
            $transaction->discount = $request->discount;
            $transaction->total = $subtotal - $discount;
            $transaction->save();

            // Commit transaksi
            DB::commit();
            return redirect()->back()->with('Berhasil', 'Transaksi Berhasil');
        } catch (Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('Gagal', 'Transaksi Gagal');
        }
    }

    public function delete(Request $request)
    {
        $idTr = $request->id;
        $Tr = ItemTransaction::find($idTr);
        if ($Tr === null) {
            return response()->json([], 404);
        }
        $Tr->delete();
        return response()->json([], 200);
    }
    public function clearTable()
{
    try {
        // Menghapus isi tabel pertama
        DB::table('denda')->truncate();
        
        // Menghapus isi tabel kedua
        DB::table('transactions')->truncate();
        
        return response()->json(['success' => 'Semua data dari kedua tabel berhasil dihapus!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
    }
}

}



