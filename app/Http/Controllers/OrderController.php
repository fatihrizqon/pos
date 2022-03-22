<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
            if($order->save()){
                return response()->json([
                    'success' => true,
                    'message' => "A new order has been added.",
                    'data'    => $order
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
            'message' => "Get a orders.",
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
