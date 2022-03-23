<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::get();
        if(!$orders){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the orders.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get all orders.",
            'data'    => $orders
        ], 200);
    }

    public function create(Request $request)
    {
        try{
            $order = new Order();
            $order->product_id = $request->product_id;
            $order->quantity = $request->quantity;

            $stock = Stock::where('product_id', $request->product_id)->get()->first();
            if($stock->quantity >= $request->quantity){
                $stock->quantity = $stock->quantity - $request->quantity;
                if($stock->save()){
                    $order->save();
                    return response()->json([
                        'success' => true,
                        'message' => "A New Order has been created.",
                        'data'    => $order
                    ], 200);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Insuficcient Stocks."
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
        $order = Order::where('id',$id)->get();
        if(!$order){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the order.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get an orders.",
            'data'    => $order
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->quantity = $request->quantity;

        if(!$order->save()){
            return response()->json([
                'success' => false,
                'message' => "Failed to get update the order.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "The order has been updated.",
            'data'    => $order
        ], 200);
    }

    public function delete($id)
    {
        $order = Order::find($id)->delete();

        if(!$order){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete the order.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "A order has been deleted.",
            'data'    => $order
        ], 200);
    }
}
