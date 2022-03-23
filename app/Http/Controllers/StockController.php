<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::get();
        if(!$stocks){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the stocks.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get all stocks.",
            'data'    => $stocks
        ], 200);
    }

    public function create(Request $request)
    {
        try{
            $stock = new stock();
            $stock->product_id = $request->product_id;
            $stock->quantity = $request->quantity;
            if($stock->save()){
                return response()->json([
                    'success' => true,
                    'message' => "A new stock has been added.",
                    'data'    => $stock
                ], 200);
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
        $stock = Stock::find($id);

        if(!$stock){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the stock.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get a stock.",
            'data'    => $stock
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::find($id);
        $stock->quantity = $request->quantity;

        if(!$stock->save()){
            return response()->json([
                'success' => false,
                'message' => "Failed to get update the stock.",
                'data'    => ''
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => "The stock has been updated.",
            'data'    => $stock
        ], 200);
    }

    public function delete($id)
    {
        $stock = Stock::find($id)->delete();

        if(!$stock){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete the stock.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "A stock has been deleted.",
            'data'    => $stock
        ], 200);
    }
}
