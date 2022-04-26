<?php

namespace App\Http\Controllers;
 
use App\Models\Order;
use App\Models\Cashflow;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::join('users', 'users.id', '=', 'user_id')
                                    ->join('orders', 'orders.code', '=', 'order_code')->distinct()
                                    ->select('transactions.*', 'users.name as cashier')
                                    ->orderBy('created_at', 'DESC')->get();
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
        $validator = Validator::make($request->all(),[
          'code'    => ['required', 'string'],
          'revenue' => ['required', 'integer'],
          'pay'     => ['required', 'integer'],
          'return'  => ['required', 'integer'], 
          'user_id' => ['required','integer']
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error
          ], 403);
        }

        try{
            $transaction = new Transaction();
            $transaction->order_code = $request->code;
            $transaction->revenue = $request->revenue;
            $transaction->pay = $request->pay;
            $transaction->return = $request->return;
            $transaction->user_id = $request->user_id;
            
            $orders = Order::where('code', '=', $request->code)->count();
            $current = Cashflow::latest()->get()->pluck('balance')->first();
            if(!$current){
                $current = 0;
            }
            $cashflow = new Cashflow();
            $cashflow->operation = 'Transaction ' . $transaction->order_code;
            $cashflow->debit = $transaction->revenue;
            $cashflow->credit = 0;
            $cashflow->balance = $current + $cashflow->debit;
            $cashflow->user_id = $transaction->user_id;
            $cashflow->notes = 'Transaction '.$transaction->order_code.' with '.$orders.' products.';

            if($transaction->save() && $cashflow->save()){
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
            'message' => "Failed to get selected Transaction." 
        ], 404);
    }

    public function update(Request $request, $id)
    {
        // $transaction = Transaction::find($id);
        $transaction = false;

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
        // $transaction = Transaction::find($id)->delete();
        $transaction = false;

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
