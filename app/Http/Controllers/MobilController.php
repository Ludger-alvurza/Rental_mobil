<?php

namespace App\Http\Controllers;

use App\Models\MessageRating;
use App\Models\Mobil;
use App\Models\SyaratS;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class MobilController extends Controller
{
    public function list()
    {
        $mobils = Mobil::query()
            ->paginate();
        return view('content.mobil.list', [
            'mobils' => $mobils
        ]);
    }

    public function add(){
        return view('content.mobil.add');
    }
    public function insert(Request $request) {
        $validated = $request->validate([
            'gambar' => 'image|required',
            'name' => 'required',
            'no_plat' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'price_per_day' => 'required',
            'denda' => 'required',
            'availability' => 'required'
        ]);
    
        $mobil = new Mobil();
        $gambarPath = $request->file('gambar')->store('public/images');
        $namaGambar = $request->file('gambar')->hashName();
    
        $mobil->gambar = $namaGambar;
        $mobil->name = $request->name;
        $mobil->no_plat = $request->no_plat;
        $mobil->type = $request->type;
        $mobil->year = $request->year;
        $mobil->brand = $request->brand;
        $mobil->denda = $request->denda;
        $mobil->availability = $request->availability;
        $mobil->price_per_day = $request->price_per_day;
    
        try {
            $mobil->save();
            // Set flash message untuk sukses
            return redirect(url('/mobil'))->with('success', 'Mobil berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Set flash message untuk gagal
            return redirect(url('/mobil'))->with('error', 'Gagal menambahkan mobil: ' . $e->getMessage());
        }
    }    
    public function edit(Request $request, $id)
    {
        $mobils = Mobil::find($id);
        if ($mobils === null) {
            abort(404);
        }
        return view('content.mobil.edit', [
            'mobils' => $mobils
        ]);
    }
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'no_plat' => 'required',
                'type' => 'required',
                'brand' => 'required',
                'year' => 'required',
                'price_per_day' => 'required',
                'denda' => 'required',
                'availability' => 'required'
            ]);
    
            $mobil = Mobil::findOrFail($request->id);

            if ($request->hasFile('gambar')) {
                $oldImagePath = storage_path('app/public/images/' . $mobil->gambar);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
    
            $mobil->name = $request->name;
            $mobil->no_plat = $request->no_plat;
            $mobil->type = $request->type;
            $mobil->brand = $request->brand;
            $mobil->year = $request->year;
            $mobil->denda = $request->denda;
            $mobil->availability = $request->availability;
            $mobil->price_per_day = $request->price_per_day;
            if($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('public/images');
                $gambarName = $request->file('gambar')->hashName(); 
                $mobil->gambar = $gambarName; // Simpan nama file gambar saja
            }
            $mobil->save();
    
            // Tambahkan pesan keberhasilan ke sesi
            Session::flash('success', 'Data Mobil berhasil diperbarui.');
    
            return redirect(url('/mobil'));
    
        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal Memperbarui data Mobil. Mobil tidak ditemukan.');
            return redirect(url('/mobil'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data Mobil.');
            return redirect(url('/mobil'));
        }
    }
    public function delete(Request $request)
    {
        $idMobil = $request->id;
        $mobil = Mobil::find($idMobil);
        if ($mobil === null) {
            return response()->json([], 404);
        }
        $mobil->delete();
        return response()->json([], 200);
    }
    
    public function search(Request $request)
{
    // Ambil semua input pencarian
    $userT = Auth::user();
    $syarat = SyaratS::first();
    $name = $request->input('name');
    $brand = $request->input('brand');
    $type = $request->input('type');
    $harga = $request->input('harga');
    $messageRatings = MessageRating::with('user')->latest()->take(20)->get(); // Ambil 20 ulasan terbaru

    // Query untuk filter
    $query = Mobil::leftJoin('message_rating', 'mobils.id', '=', 'message_rating.id_mobil')
        ->select(
            'mobils.*', 
            DB::raw('AVG(message_rating.rating) as avg_rating'), // Rata-rata rating
            DB::raw('COUNT(message_rating.rating) as total_ratings') // Jumlah rating
        )
        ->groupBy('mobils.id');

    // Tambahkan filter pencarian
    if (!empty($name)) {
        $query->where('mobils.name', 'like', '%' . $name . '%');
    }
    if (!empty($brand)) {
        $query->where('mobils.brand', $brand);
    }
    if (!empty($type)) {
        $query->where('mobils.type', $type);
    }
    if (!empty($harga)) {
        $query->where('mobils.price_per_day', '<=', $harga);
    }

    // Eksekusi query dan ambil hasil
    $kendaraan = $query->orderByDesc('avg_rating')->paginate(6); // Gunakan pagination untuk hasil pencarian

    // Kirim hasil pencarian ke view
    return view('layout-fe.dashboardfe', [
        'kendaraan' => $kendaraan,
        'userT' => $userT,
        'messageRatings' => $messageRatings,
        'syarat' => $syarat,
    ]);
}

}
