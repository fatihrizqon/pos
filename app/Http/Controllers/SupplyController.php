<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Supply;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $purchases = Supply::join('products','supplies.product_id','=','products.id')
                            ->join('stocks','stocks.product_id', '=', 'products.id')
                            ->join('suppliers','supplies.supplier_id','=','suppliers.id')
                            ->join('users','supplies.user_id','=','users.id')
                            ->select('supplies.id', 'products.name as product', 'products.purchase as purchase', 'supplies.quantity as quantity', 'users.fullname as stocker', 'suppliers.name as supplier')
                            ->get();

        if(!$purchases){
            return response()->json([
                'success' => false,
                'message' => "Failed to get Purchases activity.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get all Purchases activity.",
            'data'    => $purchases
        ], 200);
    }

    public function create(Request $request)
    {
        try{
            $purchase = new Supply();
            $purchase->product_id = $request->product_id;
            $purchase->quantity = $request->quantity;
            $purchase->user_id = $request->user_id;
            $purchase->supplier_id = $request->supplier_id;
            
            $stock = Stock::where('id', $request->stock_id)->get()->first();
            $stock->quantity = $stock->quantity + $request->quantity;
            if($stock->save()){
                $purchase->save();
                return response()->json([
                    'success' => true,
                    'message' => "A New Purchase has been added.",
                    'data'    => $purchase
                ], 200);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => "A New Purchase can't be added.",
                ], 403);
            }
        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ], 403);
        }
    }

    public function view($id)
    {
        $purchase = Supply::find($id);

        if(!$purchase){
            return response()->json([
                'success' => false,
                'message' => "Failed to get The Purchase.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get a Purchase.",
            'data'    => $purchase
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $purchase = Supply::find($id);
        $product = Product::where('id', $purchase->product_id)->get()->first();
        $stock = Stock::where('product_id', $product->id)->get()->first();
        $oldstock = $stock->quantity - $purchase->quantity;
        $newstock = $oldstock + $request->quantity;

        $purchase->quantity = $request->quantity;
        $purchase->supplier = $request->supplier; // set by default too
        $stock->quantity = $newstock;

        if($purchase->save() && $stock->save()){
            return response()->json([
                'success' => true,
                'message' => "Selected Purchase has been updated.",
                'data'    => $purchase
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Failed to get update The Purchase.",
                'data'    => ''
            ], 404);
        }
    }

    public function delete($id)
    {
        $purchase = Supply::find($id)->delete();

        if(!$purchase){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete selected Purchase.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Selected Purchase has been deleted.",
            'data'    => $purchase
        ], 200);
    }
}
