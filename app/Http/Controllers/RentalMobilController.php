<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentalMobilController extends Controller
{
    public function hitungBiayaSewa(Request $request)
    {
        $request->validate([
            'biaya_sewa_per_hari' => 'required|numeric',
            'jumlah_hari_sewa' => 'required|numeric|min:1',
        ]);

        $biaya_sewa_per_hari = $request->input('biaya_sewa_per_hari');
        $jumlah_hari_sewa = $request->input('jumlah_hari_sewa');
        $biaya_sewa = $biaya_sewa_per_hari * $jumlah_hari_sewa;

        return view('hasil_biaya_sewa')->with('biaya_sewa', $biaya_sewa);
    }

    public function hitungDenda(Request $request)
    {
        $request->validate([
            'denda_per_hari' => 'required|numeric',
            'denda_per_jam' => 'required|numeric',
            'jumlah_hari_terlambat' => 'required|numeric|min:1',
            'jumlah_jam_terlambat' => 'required|numeric|min:1',
        ]);

        $denda_per_hari = $request->input('denda_per_hari');
        $denda_per_jam = $request->input('denda_per_jam');
        $jumlah_hari_terlambat = $request->input('jumlah_hari_terlambat');
        $jumlah_jam_terlambat = $request->input('jumlah_jam_terlambat');

        $denda = ($denda_per_hari * $jumlah_hari_terlambat) + ($denda_per_jam * $jumlah_jam_terlambat);

        return view('hasil_denda')->with('denda', $denda);
    }
}
