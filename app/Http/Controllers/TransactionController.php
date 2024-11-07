<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function transaction()
    {
        $transactions = Transaction::query()
            ->with('item_transactions')
            ->paginate();
        return view('transaction', [
            'transactions' => $transactions
        ]);
    }

    public function itemTransaction()
    {
        $item_transactions = ItemTransaction::with('transactions')
            ->get();
        return view('itemT', [
            'item_transactions' => $item_transactions
        ]);
    }
    public function index()
    {
        $rows = Transaction::query()->get();
        return View('content.transaction.list',[
        'rows' => $rows
        ]);
    }
    public function printPDF($id)
{
    $row = Transaction::query()->with('ItemTransaction.Mobil')->find($id);
    if($row === null) {
        abort(404);
    }
    $pdf = Pdf::loadView('content.transaction.print-pdf',['row' => $row])
        ->setPaper('A4');
    return $pdf->stream('Invoice'. $row->code . '.pdf');
}
public function clearTable()
{
    // Pastikan untuk mengganti 'your_table_name' dengan nama tabel yang ingin Anda hapus
    DB::table('denda')->truncate();
    DB::table('transactions')->truncate();

    return redirect()->back()->with('success', 'Semua data berhasil dihapus!');
}

}
