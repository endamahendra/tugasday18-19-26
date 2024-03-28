<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Validator;
use DataTables;

class CustomerController extends Controller
{
    public function index(){
        return view('customers.index');
    }

        public function getdata()
        {
            $customers = Customer::all();
            
            return DataTables::of($customers)
                    ->addColumn('action', function($customer) {
                        return '<button class="btn btn-sm btn-warning" onclick="editCustomer(' . $customer->id . ')">Edit</button>' .
                            '<button class="btn btn-sm btn-danger" onclick="deleteCustomer(' . $customer->id . ')">Delete</button>';
                    })
                    ->make(true);
        }


        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'nama_pelanggan' => 'required',
                'alamat' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $customer = Customer::create([
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'alamat' => $request->input('alamat'),
            ]);
    
            return response()->json(['customer' => $customer]);
        }

        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'nama_pelanggan' => 'required',
                'alamat' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $customer = Customer::find($id);
            if (!$customer) {
                return response()->json(['error' => 'Data not found'], 404);
            }
    
            $customer->nama_pelanggan = $request->input('nama_pelanggan');
            $customer->alamat = $request->input('alamat');
            $customer->save();
    
            return response()->json(['customer' => $customer]);
        }


        public function show($id)
        {
            $customer = Customer::find($id);

            if (!$customer) {
                return view('errors.404');
            }

            return response()->json(['customer' => $customer]);
        }
        public function destroy($id)
        {
            Customer::destroy($id);
            return response()->json([], 204);
        }
    
}