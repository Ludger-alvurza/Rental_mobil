<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use Illuminate\Http\Request;

class ItemTrasactionController extends Controller
{
    public function index()
    {
        $rows = ItemTransaction::query()->get();
        return View('content.itemT.list',[
        'rows' => $rows
        ]);
    }
    
}
