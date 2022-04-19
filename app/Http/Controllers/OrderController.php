<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::get();
        if($orders){
            return response()->json([
                'success' => true,
                'message' => "All Orders has been loaded.",
                'data'    => $orders
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load the Orders.",
            'data'    => ''
        ], 404); 
    }

    public function create(Request $request)
    {
        try{
            $product = Product::where('code', $request->product_code)->get()->first();
            $order = new Order();
            $order->product_id = $product->id;
            $order->product_name = $request->product_name;
            $order->quantity = $request->quantity;
            $order->price = $request->price;
            $order->code = $request->code;
            $product->stocks = $product->stocks - $order->quantity;

            if($request->quantity > $product->stocks){ 
                return response()->json([
                    'success' => false,
                    'message' => "Insuficcient Stocks."
                ], 403);
            }else{
                if($order->save() && $product->save()){ 
                    return response()->json([
                        'success' => true,
                        'message' => "A New Order has been created.",
                        'data'    => $order
                    ], 200);
                }
                return response()->json([
                    'success' => false,
                    'message' => "An error has been occured.",
                ], 404);  
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
        $order = Order::where('id',$id)->get();
        if($order){
            return response()->json([
                'success' => true,
                'message' => "Selected Order has been loaded.",
                'data'    => $order
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to get selected Order.",
        ], 404);
    }

    public function update(Request $request, $id)
    {
        /* Can't update order */ 
        $order = Order::find($id); 

        if($order->save()){
            return response()->json([
                'success' => true,
                'message' => "Selected Order has been updated.",
                'data'    => $order
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to update selected Order." 
        ], 404);
    }

    public function delete($id)
    {
        $order = Order::find($id)->delete();
        /* Can't delete order */ 

        if($order){
            return response()->json([
                'success' => true,
                'message' => "Selected Order has been deleted."
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete selected Order.",
            'data'    => ''
        ], 404);
    }
}
