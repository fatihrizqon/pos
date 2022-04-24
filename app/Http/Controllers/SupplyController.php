<?php

namespace App\Http\Controllers;
 
use App\Models\Supply;
use App\Models\Product;
use App\Models\Cashflow;
use Illuminate\Http\Request;
use Validator;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::join('products','supplies.product_id','=','products.id') 
                            ->join('suppliers','supplies.supplier_id','=','suppliers.id')
                            ->join('users','supplies.user_id','=','users.id')
                            ->select('supplies.id', 'products.id as product_id', 'products.name as product', 'products.purchase as purchase', 'supplies.quantity as quantity', 'supplies.cost as cost', 'users.name as stocker', 'suppliers.id as supplier_id', 'suppliers.name as supplier', 'supplies.created_at as date', 'supplies.updated_at as update')
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
        $validator = Validator::make($request->all(),[
          'product_id'    => ['required', 'integer'],
          'quantity' => ['required', 'integer'], 
          'supplier_id'  => ['required', 'integer']
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error
          ], 403);
        }

        try{
            $supply = new Supply();
            $product = Product::where('id', $request->product_id)->get()->first();
            $current = Cashflow::latest()->get()->pluck('balance')->first();

            $supply->product_id = $request->product_id;
            $supply->quantity = $request->quantity;
            $supply->cost = $request->quantity * $product->purchase;
            $supply->supplier_id = $request->supplier_id;

            // $supply->user_id = $request->user_id; //change this soon...
            $supply->user_id = 1;

            $product->stocks += $request->quantity;

            if(!$current){
                $current = 0;
            }
            $cashflow = new Cashflow();
            $cashflow->operation = 'Purchasing '.$product->name;
            $cashflow->debit = 0;
            $cashflow->credit = $supply->cost;
            $cashflow->balance = $current - $cashflow->credit;
            $cashflow->user_id = $supply->user_id;
            $cashflow->notes = 'Purchasing '.$supply->quantity.' item(s) '.$product->name;

            if($supply->save() && $product->save() && $cashflow->save()){ 
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
        $validator = Validator::make($request->all(),[ 
          'quantity' => ['required', 'integer'], 
          'supplier_id'  => ['required', 'integer']
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error
          ], 403);
        }

        try {
            $supply = Supply::find($id);
            $product = Product::where('id', $supply->product_id)->get()->first();
            $cashflow = Cashflow::where([
                ['user_id', '=', $supply->user_id],
                ['created_at', '=', $supply->created_at],
            ])->get()->first();
            $cashflow->balance += $supply->cost; /*normalize previous balance*/
            $supply->product_id = $request->product_id;;
            $oldstock = $product->stocks - $supply->quantity; /*normalize previous stock*/
            $newstock = $oldstock + $request->quantity; /*counting updated stock*/
            $supply->quantity = $request->quantity; /*getting new quantity*/
            $supply->cost = $supply->quantity * $product->purchase; /*generating updated cost*/
            $supply->supplier_id = $request->supplier_id;
            $product->stocks = $newstock; /*updating stock at product*/
            $cashflow->credit = $supply->cost; /*generating updated credit*/
            $cashflow->balance = $cashflow->balance - $cashflow->credit; /*generating updated balance*/
            $cashflow->notes = 'Purchasing '.$supply->quantity.' item(s) '.$product->name;
            if($supply->save() && $product->save() && $cashflow->save()){
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
        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ], 403);
        }
    }

    public function delete($id)
    {
        $supply = Supply::find($id);
        $product = Product::where('id', $supply->product_id)->get()->first();
        $cashflow = Cashflow::where([
            ['user_id', '=', $supply->user_id],
            ['created_at', '=', $supply->created_at],
        ])->get()->first();
        $cashflow->balance += $supply->cost; /*normalize previous balance*/
        $oldstock = $product->stocks - $supply->quantity; /*generating previous stock*/
        $product->stocks = $oldstock; /*updating to previous stock*/
        $latest = Cashflow::latest()->get()->first(); /*getting latest cashflow*/
        $latest->balance += $cashflow->credit; /*normalize latest balance by adding previous credit*/
        $supply = Supply::find($id)->delete(); /*deleting selected supply*/
        $cashflow = Cashflow::find($cashflow->id)->delete(); /*deleting related cashflow*/
        if($supply && $product->save() && $latest->save()){
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
