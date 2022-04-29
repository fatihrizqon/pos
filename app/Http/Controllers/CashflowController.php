<?php

namespace App\Http\Controllers;

use App\Models\Cashflow;
use Illuminate\Http\Request;
use Validator;

class CashflowController extends Controller
{
    public function index()
    {

        $cashflows = Cashflow::join('users','cashflows.user_id','=','users.id')
                            ->select('cashflows.*', 'users.name as operator')
                            ->orderBy('created_at', 'DESC')->get();
        if($cashflows){
            return response()->json([
                'success' => true,
                'message' => "All Cashflow Activities has been loaded.",
                'data'    => $cashflows
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load the Cashflow Activities.",
            'data'    => ''
        ], 404); 
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'operation' => ['required','string'],
            'debit'     => ['required','integer','min:0'],
            'credit'    => ['required','integer','min:0'],
            'user_id'   => ['required','integer']
        ]);
      
        if($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success'   => false,
                'message'   => $error 
            ], 403);
        }

        try{ 
            $latest = Cashflow::latest()->get()->pluck('balance')->first();
            if(!$latest){
                $latest = 0;
            }
            $cashflow = new Cashflow();
            $cashflow->operation = ucfirst($request->operation);
            $cashflow->debit = $request->debit;
            $cashflow->credit = $request->credit;
            if($cashflow->debit != 0){
                $cashflow->balance = $latest + $cashflow->debit;
            }else{
                $cashflow->balance = $latest - $cashflow->credit;
            }
            $cashflow->user_id = $request->user_id;
            $cashflow->notes = $request->notes;

            if($cashflow->save()){ 
                return response()->json([
                    'success' => true,
                    'message' => "A New Cashflow Activity has been created.",
                    'data'    => $cashflow
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
        $cashflow = Cashflow::where('id',$id)->get();
        if($cashflow){
            return response()->json([
                'success' => true,
                'message' => "Selected Cashflow has been loaded.",
                'data'    => $cashflow
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to get selected Cashflow.", 
        ], 404);
    }

    public function update(Request $request, $id)
    {
        /**
         * Error ketika update terhadap Balance. check lagi.
         */
        
        $validator = Validator::make($request->all(),[
            'operation' => ['required','string'],
            'debit'     => ['required','integer'],
            'credit'    => ['required','integer'], 
        ]);
      
        if($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success'   => false,
                'message'   => $error 
            ], 403);
        }
        try {
            $cashflow = Cashflow::find($id);
            $current = $cashflow->balance;
            $cashflow->operation = $request->operation;
            $cashflow->debit = $request->debit;
            $cashflow->credit = $request->credit;
            $cashflow->credit = $request->credit;
            $cashflow->balance = $current + $cashflow->debit;
            $cashflow->balance = $current - $cashflow->credit;
            $cashflow->user_id = $cashflow->user_id;
            $cashflow->notes = $request->notes;
            $arr = explode(' ',trim($cashflow->notes));
            if($arr[0] === 'Transaction' || $arr[0] === 'Purchasing'){
                return response()->json([
                    'success' => false,
                    'message' => "Cannot update Cashflow from Transaction or Purchasing Activity." 
                ], 404);
            }
    
            if($cashflow->save()){
                return response()->json([
                    'success' => true,
                    'message' => "Selected Cashflow has been updated.",
                    'data'    => $cashflow
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => "Failed to update selected Cashflow." 
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
        $cashflow = Cashflow::find($id);
        $arr = explode(' ',trim($cashflow->notes));
        if($arr[0] === 'Transaction' || $arr[0] === 'Purchasing'){
            return response()->json([
                'success' => false,
                'message' => "Cannot delete Cashflow from Transaction or Purchasing Activity." 
            ], 404);
        }
        $debit = $cashflow->debit;
        $credit = $cashflow->credit;
        if($cashflow->delete()){       
            $latest = Cashflow::latest()->get()->first(); /*getting latest cashflow*/
            $latest->balance -= $debit;
            $latest->balance += $credit; 
            if($latest->save()){
                return response()->json([
                    'success' => true,
                    'message' => "Selected Cashflow has been deleted."
                ], 200);
            }
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete selected Cashflow."
        ], 403);
    }


}
