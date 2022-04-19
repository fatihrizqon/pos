<?php

namespace App\Http\Controllers;
 
use App\Models\Supply;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::join('products','supplies.product_id','=','products.id') 
                            ->join('suppliers','supplies.supplier_id','=','suppliers.id')
                            ->join('users','supplies.user_id','=','users.id')
                            ->select('supplies.id', 'products.id as product_id', 'products.name as product', 'products.purchase as purchase', 'supplies.quantity as quantity', 'users.fullname as stocker', 'suppliers.id as supplier_id', 'suppliers.name as supplier', 'supplies.created_at as date', 'supplies.updated_at as update')
                            ->get();

        if($supplies){
            return response()->json([
                'success' => true,
                'message' => "All Supplies has been loaded.",
                'data'    => $supplies
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load the Supplies.",
            'data'    => ''
        ], 404); 
    }

    public function create(Request $request)
    {
        try{
            $supply = new Supply();
            $supply->product_id = $request->product_id;
            $supply->quantity = $request->quantity; 
            $supply->supplier_id = $request->supplier_id;
            $supply->user_id = 1; // next ganti
            $product = Product::where('id', $request->product_id)->get()->first();
            $product->stocks = $product->stocks + $request->quantity;
            if($supply->save() && $product->save()){ 
                return response()->json([
                    'success' => true,
                    'message' => "A New Supply has been created.",
                    'data'    => $supply
                ], 200);
            } 
            return response()->json([
                'success' => false,
                'message' => "An error has been occured."
            ], 404);
        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ], 403);
        }
    }

    public function view($id)
    {
        $supply = Supply::find($id);

        if($supply){
            return response()->json([
                'success' => true,
                'message' => "Selected Supply has been loaded.",
                'data'    => $supply
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to get selected Supply." 
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $supply = Supply::find($id);
        $product = Product::where('id', $supply->product_id)->get()->first(); 
        $supply->product_id = $request->product_id;
        $oldstock = $product->stocks - $supply->quantity;
        $newstock = $oldstock + $request->quantity;
        $supply->quantity = $request->quantity;
        $supply->supplier_id = $request->supplier_id; // set by default too
        $product->stocks = $newstock;

        if($supply->save() && $product->save()){
            return response()->json([
                'success' => true,
                'message' => "Selected Supply has been updated.",
                'data'    => $supply
            ], 200);
        } 
        return response()->json([
            'success' => false,
            'message' => "Failed to update selected Supply."
        ], 404);
    }

    public function delete($id)
    {
        $supply = Supply::find($id);
        $product = Product::where('id', $supply->product_id)->get()->first(); 
        $oldstock = $product->stocks - $supply->quantity;
        $product->stocks = $oldstock;
        $supply = Supply::find($id)->delete();

        if($supply && $product->save()){
            return response()->json([
                'success' => true,
                'message' => "Selected Supply has been deleted."
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete selected Supply."
        ], 404);
    }
}
