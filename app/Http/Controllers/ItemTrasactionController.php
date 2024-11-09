<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use Illuminate\Http\Request;

class ItemTrasactionController extends Controller
{
    public function index()
    {
        $rows = ItemTransaction::with('transaction')->get();
        return view('content.itemT.list', [
            'rows' => $rows
        ]);
    }
    public function search(Request $request)
    {
        $id_booking = $request->input('id_booking'); // Ambil input dari request

        // Cari berdasarkan id_booking di relasi transaction
        $rows = ItemTransaction::with('transaction')
            ->whereHas('transaction', function ($query) use ($id_booking) {
                $query->where('id_booking', $id_booking);
            })
            ->get();

        return view('content.itemT.list', [
            'rows' => $rows
        ]);
    }

    
}
