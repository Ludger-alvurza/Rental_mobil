<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::query()
            ->paginate();
        return view('content.product.listPr', [
            'products' => $products
        ]);
    }

    public function add(){
        return view('content.product.add');
    }
    public function insert(Request $request){
        $validated = $request->validate([
            'barcode' => 'required',
            'name' => 'required',
            'price' =>  'required',
        ]);
        #sudah tervalidasi
        $product = new Product();
        $product->name = $request->name;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->save();
        return redirect(url('/product'));
    }
    public function edit(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product === null) {
            abort(404);
        }
        return view('content.product.edit', [
            'product' => $product
        ]);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required',
            'name' => 'required',
            'price' =>  'required',
        ]);
        $product = Product::find($request->id);
        if ($product === null) {
            abort(404);
        }
        $product->name = $request->name;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->save();
        return redirect(url('/product'));
    }
    public function delete(Request $request)
    {
        $idStudent = $request->id;
        $student = Product::find($idStudent);
        if ($student === null) {
            return response()->json([], 404);
        }
        $student->delete();
        return response()->json([], 200);
    }
}
