<?php

namespace App\Http\Controllers;

use App\Models\bkuser;
use App\Models\MessageRating;
use App\Models\SyaratS;
use App\Models\User;
use App\Notifications\PeminjamanSelesaiNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BkuserController extends Controller
{
    public function list()
    {
        $bkuser = bkuser::query()
            ->paginate();
        return view('content.pesan.list', [
            'bkuser' => $bkuser
        ]);
    }
    public function pesanan()
    {
        $syarat = SyaratS::first();
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $bkuser = Bkuser::where('id_user', $user->id)
            ->paginate();

        return view('layout-fe.pesanan', [
            'bkuser' => $bkuser,
            'user' => $user,
            'syarat' =>  $syarat
        ]);
    }

    public function add(){
        return view('content.pesan.add');
    }
    public function insert(Request $request){
        try {
        $validated = $request->validate([
            'id_mobil' => 'required',
            'id_user' => 'required',
            'name' => 'required',
            'no_plat' => 'required',
            'name_mobil' => 'required',
            'lama_sewa' => 'required',
            'keterangan' => 'required'
        ]);
        #sudah tervalidasi
        $bkuser = new bkuser();
        $bkuser->id_mobil = $request->id_mobil;
        $bkuser->id_user = $request->id_user;
        $bkuser->name = $request->name;
        $bkuser->no_plat = $request->no_plat;
        $bkuser->name_mobil = $request->name_mobil;
        $bkuser->lama_sewa = $request->lama_sewa;
        $bkuser->keterangan = $request->keterangan;
        $bkuser->save();
        Session::flash('success', 'Pesanan Anda Berhasil Silahkan Tunggu Verifikasi.');

            return redirect(url('/sewa-mobil'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memesan. Pesanan Gagal.');
            return redirect(url('/sewa-mobil'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal Menambah Pesanan.');
            return redirect(url('/sewa-mobil'));
        }
    }
    public function edit(Request $request, $id)
    {
        $bkuser = bkuser::find($id);
        if ($bkuser === null) {
            abort(404);
        }
        return view('content.pesan.edit', [
            'bkuser' => $bkuser
        ]);
    }
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'no_plat' => 'required',
                'name_mobil' => 'required',
                'lama_sewa' => 'required',
                'keterangan' => 'required'
            ]);

            $bkuser = bkuser::findOrFail($request->id);

            $bkuser->name = $request->name;
            $bkuser->no_plat = $request->no_plat;
            $bkuser->name_mobil = $request->name_mobil;
            $bkuser->lama_sewa = $request->lama_sewa;
            $bkuser->keterangan = $request->keterangan;
            $bkuser->save();

            // Tambahkan pesan keberhasilan ke sesi
            Session::flash('success', 'Data pesanan berhasil diperbarui.');

            return redirect(url('/pesanan'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memperbarui data Mobil. Mobil tidak ditemukan.');
            return redirect(url('/pesanan'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data Mobil.');
            return redirect(url('/pesanan'));
        }
    }
    public function batal(Request $request)
{
    try {
        $validated = $request->validate([
            'pembatalan' => 'required|in:Dipesan,Dibatalkan,Terverifikasi',
        ]);

        $bkuser = bkuser::findOrFail($request->id);

        $bkuser->pembatalan = $request->pembatalan;
        $bkuser->save();

        // Tentukan pesan berdasarkan nilai pembatalan
        if ($request->pembatalan == 'Dibatalkan') {
            Session::flash('success', 'Data pesanan berhasil dibatalkan.');
        } elseif ($request->pembatalan == 'Terverifikasi') {
            Session::flash('success', 'Data pesanan berhasil diverifikasi.');
        } else {
            Session::flash('success', 'Data pesanan berhasil dilanjutkan.');
        }

        // Cek peran pengguna secara manual
        $user = auth()->user();

        if ($user && $user->role === 'superadmin') {
            return redirect(url('/pesanan'));
        } else {
            return redirect(url('/pesanan/keranjang'));
        }

    } catch (ModelNotFoundException $e) {
        Session::flash('error', 'Gagal memperbarui data pesanan. Pesanan tidak ditemukan.');
        return redirect(url('/pesanan/keranjang'));
    } catch (\Exception $e) {
        Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data pesanan.');
        return redirect(url('/pesanan/keranjang'));
    }
}


    public function delete(Request $request)
    {
        $idPesan = $request->id;
        $bkuser = bkuser::find($idPesan);
        if ($bkuser === null) {
            return response()->json([], 404);
        }
        $bkuser->delete();
        return response()->json([], 200);
    }

    public function konfirmasiPengembalian($id)
    {
        $peminjaman = bkuser::find($id);
        
        // Cek apakah peminjaman ditemukan
        if (!$peminjaman) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }
    
        // Log status sebelum diubah
    
        // Update status peminjaman menjadi selesai
        $peminjaman->status = 'selesai';
        $peminjaman->save();
    
        // Log status setelah diubah
    
        // Kirim notifikasi ke user
        $user = User::find($peminjaman->id_user);

        if ($user) {
            $user->notify(new PeminjamanSelesaiNotification($peminjaman));
        } else {
            // Tangani jika pengguna tidak ditemukan
        }

        
    
        return redirect()->back()->with('success', 'Pengembalian telah dikonfirmasi.');
    }
    
public function store(Request $request)
{
    $request->validate([
        'id_mobil' => 'required|exists:mobils,id',
        'message' => 'required|integer|min:1|max:5',
    ]);

    // Simpan rating ke dalam tabel message_rating
    MessageRating::create([
        'id_mobil' => $request->id_mobil,
        'message' => $request->rating,
        // Tambah kolom lain jika ada, misal user_id jika perlu
    ]);

    return redirect()->back()->with('success', 'Rating telah diberikan.');
}


}
