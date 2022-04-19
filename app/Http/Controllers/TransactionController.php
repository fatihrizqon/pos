<?php

namespace App\Http\Controllers;
 
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::get();
        if($transactions){ 
            return response()->json([
                'success' => true,
                'message' => "All Transactions has been loaded.",
                'data'    => $transactions
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load the Transactions.",
            'data'    => ''
        ], 404);
    }

    public function create(Request $request)
    {
        try{
            $transaction = new Transaction();
            $transaction->order_code = $request->code;
            $transaction->total_price = $request->total_price;
            $transaction->pay = $request->pay;
            $transaction->return = $request->return;
            $transaction->user_id = $request->user_id;

            if($transaction->save()){ 
                return response()->json([
                    'success' => true,
                    'message' => "A New Transaction has been created.",
                    'data'    => $transaction
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => "An error has been occured.",
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
        $transaction = Transaction::where('id',$id)->get();
        if($transaction){
            return response()->json([
                'success' => true,
                'message' => "Selected Transaction has been loaded.",
                'data'    => $transaction
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to get selected Transaction.",
            'data'    => ''
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->quantity = $request->quantity;

        if($transaction->save()){
            return response()->json([
                'success' => true,
                'message' => "Selected Transaction has been updated.",
                'data'    => $transaction
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to update selected Transaction." 
        ], 404);
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id)->delete();

        if($transaction){
            return response()->json([
                'success' => true,
                'message' => "Selected Transaction has been deleted" 
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete selected Transaction." 
        ], 404);
    }
}
