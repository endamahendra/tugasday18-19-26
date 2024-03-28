<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use Validator;
use DataTables;

class ProductController extends Controller
{
    public function index(){
        return view('products.index');
    }

    public function getdata(){
        $products = Product::all();
        return DataTables::of($products)->addColumn('action', function($products){
                return '<button class="btn btn-sm btn-warning" onclick="editProduct(' . $products->ID_Product . ')">Edit</button>' .
                        '<button class="btn btn-sm btn-danger" onclick="deleteProduct(' . $products->ID_Product . ')">Delete</button>';
            })
            ->make(true);
    }

        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'nama_product' => 'required|unique:products',
                'deskripsi' => 'required',
                'harga' => 'required',
                'stok' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $product = Product::create([
                'nama_product' => $request->input('nama_product'),
                'deskripsi' => $request->input('deskripsi'),
                'harga' => $request->input('harga'),
                'stok' => $request->input('stok'),
            ]);
    
            return response()->json(['product' => $product]);
        }

        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'nama_product' => 'required|unique:products,nama_product,'.$id,
                'deskripsi' => 'required',
                'harga' => 'required',
                'stok' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['error' => 'Data not found'], 404);
            }
    
            $product->nama_product = $request->input('nama_product');
            $product->deskripsi = $request->input('deskripsi');
            $product->harga = $request->input('harga');
            $product->stok = $request->input('stok');
            $product->save();
    
            return response()->json(['product' => $product]);
        }


        public function show($id)
        {
            $product = Product::find($id);

            if (!$product) {
                return view('errors.404');
            }

            return response()->json(['product' => $product]);
        }
        public function destroy($id)
        {
            Product::destroy($id);
            return response()->json([], 204);
        }
    
}