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
    return view('content.booking.index');
}

    public function searchProduct(Request $request)
    {
        $motor = Mobil::query()->where('no_plat', $request->no_plat)->first();
        if($motor === null){
            return response()->json([],404);
        }
        return response()->json($motor);
    }
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try{
            $prefix='INV'.date('ym').'/';
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
            for($i = 0;$i< $itemCount; $i++) {
                $it = new ItemTransaction();
                $it->id_transaction =$transaction->id;
                $it->id_mobil = $request->id_mobil[$i];
                $it->price = $request->price[$i];
                $it->qty = $request->qty[$i];
                $it->total = (int)$it->price * (int)$it->qty;
                $it->denda = $request->denda[$i];
                $it->denda1 = $request->denda1[$i];
                $it->denda2 = $request->denda2[$i];
                $it->denda3 = $request->denda3[$i];
                $it->save();
                $subtotal += $it->total;
            }
            $transaction->subtotal = $subtotal;
            $discount = $subtotal * (int)$request->discount / 100;
            $transaction->discount = $request->discount;
            $transaction->total = $subtotal - $discount;
            $transaction->save();
            DB::commit();
            return redirect()->back()->with('Berhasil', 'Transaksi Berhasil');
        }catch (Exception $e){
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
        DB::table('booking')->truncate();
        
        // Menghapus isi tabel kedua
        DB::table('transactions')->truncate();
        
        return redirect()->back()->with('success', 'Semua data dari kedua tabel berhasil dihapus!');
    } catch (\Exception $e) {
        \Log::error('Error saat menghapus data: '.$e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
    }
}


}
