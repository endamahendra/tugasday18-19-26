<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\Customer;
use App\Models\Product;
use Validator;
use DataTables;
class SalesOrderController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $products = Product::all(); 
        
        return view('sales_orders.index', compact('customers', 'products'));
    }

    public function getdata()
    {
        $salesOrders = SalesOrder::with(['customer', 'product'])->get();
        return DataTables::of($salesOrders)->addColumn('action', function ($salesOrder) {
            return '<button class="btn btn-sm btn-warning" onclick="editSalesOrder(' . $salesOrder->id . ')">Edit</button>' .
                '<button class="btn btn-sm btn-success" onclick="viewSalesOrder(' . $salesOrder->id . ')">View</button>' .
                '<button class="btn btn-sm btn-danger" onclick="deleteSalesOrder(' . $salesOrder->id . ')">Delete</button>';
        })->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_so' => 'required|unique:sales_orders',
            'tanggal' => 'required',
            'customer_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $salesOrder = SalesOrder::create([
            'no_so' => $request->input('no_so'),
            'tanggal' => $request->input('tanggal'),
            'customer_id' => $request->input('customer_id'),
            'product_id' => $request->input('product_id'),
            'total' => $request->input('total'),
            'qty' => $request->input('qty'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return response()->json(['salesOrder' => $salesOrder]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no_so' => 'required|unique:sales_orders,no_so,' . $id,
            'tanggal' => 'required',
            'customer_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $salesOrder = SalesOrder::find($id);
        if (!$salesOrder) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $salesOrder->update([
            'no_so' => $request->input('no_so'),
            'tanggal' => $request->input('tanggal'),
            'customer_id' => $request->input('customer_id'),
            'product_id' => $request->input('product_id'),
            'qty' => $request->input('qty'),
            'total' => $request->input('total'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return response()->json(['salesOrder' => $salesOrder]);
    }

    public function show($id)
    {
        $salesOrder = SalesOrder::with(['customer', 'product'])->find($id);

        if (!$salesOrder) {
            return view('errors.404');
        }

        return response()->json(['salesOrder' => $salesOrder]);
    }

    public function destroy($id)
    {
        SalesOrder::destroy($id);
        return response()->json([], 204);
    }
}
