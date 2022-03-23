<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::get();
        if(!$supplies){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the supplies.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get all supplies.",
            'data'    => $supplies
        ], 200);
    }

    public function create(Request $request)
    {
        try{
            $supply = new Supply();
            $supply->stock_id = $request->stock_id;
            $supply->quantity = $request->quantity;
            $supply->user_id = $request->user_id;
            
            $stock = Stock::where('id', $request->stock_id)->get()->first();
            $stock->quantity = $stock->quantity + $request->quantity;
            if($stock->save()){
                $supply->save();
                return response()->json([
                    'success' => true,
                    'message' => "A new supply has been added.",
                    'data'    => $supply
                ], 200);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => "A new supply can't be added.",
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
        $supply = Supply::find($id);

        if(!$supply){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the supply.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get a supply.",
            'data'    => $supply
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $supply = Supply::find($id);
        $supply->quantity = $request->quantity;

        if(!$supply->save()){
            return response()->json([
                'success' => false,
                'message' => "Failed to get update the supply.",
                'data'    => ''
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => "The supply has been updated.",
            'data'    => $supply
        ], 200);
    }

    public function delete($id)
    {
        $supply = Supply::find($id)->delete();

        if(!$supply){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete the supply.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "A supply has been deleted.",
            'data'    => $supply
        ], 200);
    }
}
