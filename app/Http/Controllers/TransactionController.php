<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::get();
        if(!$transactions){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the transactions.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get all transactions.",
            'data'    => $transactions
        ], 200);
    }

    public function create(Request $request)
    {
        try{
            $transaction = new Transaction();
            $transaction->order_id = $request->order_id;
            $transaction->total_price = $request->total_price;
            $transaction->user_id = $request->user_id;
            if($transaction->save()){
                return response()->json([
                    'success' => true,
                    'message' => "A new transaction has been added.",
                    'data'    => $transaction
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
        $transaction = Transaction::where('id',$id)->get();
        if(!$transaction){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the transaction.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get a transactions.",
            'data'    => $transaction
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->quantity = $request->quantity;

        if(!$transaction->save()){
            return response()->json([
                'success' => false,
                'message' => "Failed to get update the transaction.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "The transaction has been updated.",
            'data'    => $transaction
        ], 200);
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id)->delete();

        if(!$transaction){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete the transaction.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "A transaction has been deleted.",
            'data'    => $transaction
        ], 200);
    }
}
