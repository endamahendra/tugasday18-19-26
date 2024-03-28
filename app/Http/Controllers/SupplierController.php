<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Validator;
use DataTables;
use Psy\Sudo;

class SupplierController extends Controller
{
    public function index(){
        return view('suppliers.index');
    }

        public function getdata()
        {
            $suppliers = Supplier::all();
            
            return DataTables::of($suppliers)
                    ->addColumn('action', function($supplier) {
                        return '<button class="btn btn-sm btn-warning" onclick="editSupplier(' . $supplier->id . ')">Edit</button>' .
                            '<button class="btn btn-sm btn-danger" onclick="deleteSupplier(' . $supplier->id . ')">Delete</button>';
                    })
                    ->make(true);
        }


        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'nama_pemasok' => 'required',
                'alamat' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $supplier = Supplier::create([
                'nama_pemasok' => $request->input('nama_pemasok'),
                'alamat' => $request->input('alamat'),
            ]);
    
            return response()->json(['supplier' => $supplier]);
        }

        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'nama_pemasok' => 'required',
                'alamat' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $supplier = Supplier::find($id);
            if (!$supplier) {
                return response()->json(['error' => 'Data not found'], 404);
            }
    
            $supplier->nama_pemasok = $request->input('nama_pemasok');
            $supplier->alamat = $request->input('alamat');
            $supplier->save();
    
            return response()->json(['customer' => $supplier]);
        }


        public function show($id)
        {
            $supplier = Supplier::find($id);

            if (!$supplier) {
                return view('errors.404');
            }

            return response()->json(['supplier' => $supplier]);
        }
        public function destroy($id)
        {
            Supplier::destroy($id);
            return response()->json([], 204);
        }
    
}