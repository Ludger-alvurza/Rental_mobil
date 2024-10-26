<?php

namespace App\Http\Controllers;

use App\Models\SyaratS;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SyaratSewaController extends Controller
{
    public function list()
    {
        $syarats = SyaratS::query()
            ->paginate();
        return view('content.syarat.list', [
            'syarats' => $syarats
        ]);
    }

    public function add(){
        return view('content.syarat.add');
    }
    public function insert(Request $request){
        $validated = $request->validate([
            'keterangan' => 'required'
        ]);
        #sudah tervalidasi
        $syarat = new SyaratS();
        $syarat->keterangan = $request->keterangan;
        $syarat->save();
        return redirect(url('/syarat'));
    }
    public function edit(Request $request, $id)
    {
        $syarat = SyaratS::find($id);
        if ($syarat === null) {
            abort(404);
        }
        return view('content.syarat.edit', [
            'syarat' => $syarat
        ]);
    }
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'keterangan' => 'required'
            ]);
    
            $syarat = SyaratS::findOrFail($request->id);
    
            $syarat->keterangan = $request->keterangan;
            $syarat->save();
    
            // Tambahkan pesan keberhasilan ke sesi
            Session::flash('success', 'Data syarat berhasil diperbarui.');
    
            return redirect(url('/syarat'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal Syarat Pesanan. Syarat Gagal.');
            return redirect(url('/pesanan'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Saat Menambahkan Syarat.');
            return redirect(url('/pesanan'));
        }
    }
    public function delete(Request $request)
    {
        $idSyarat = $request->id;
        $syarat = SyaratS::find($idSyarat);
        if ($syarat === null) {
            return response()->json([], 404);
        }
        $syarat->delete();
        return response()->json([], 200);
    }
}
