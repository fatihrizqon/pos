<?php

namespace App\Http\Controllers;

use App\Models\Cashflow;
use Illuminate\Http\Request;

class CashflowController extends Controller
{
    public function index()
    {
        $cashflows = Cashflow::get();
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
        try{ 
            $current = Cashflow::latest()->get()->pluck('balance')->first();
            if(!$current){
                $current = 0;
            }
            $cashflow = new Cashflow();
            $cashflow->operation = $request->operation;
            $cashflow->debit = $request->debit;
            $cashflow->credit = $request->credit;
            if($cashflow->debit != 0){
                $cashflow->balance = $current + $cashflow->debit;
            }else{
                $cashflow->balance = $current - $cashflow->credit;
            }
            // $cashflow->user_id = $request->user_id;
            $cashflow->user_id = 1;
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
        // test later...
        // pertimbangkan penggunaan digit besar, nilai milyar gamau masuk bos
        $cashflow = Cashflow::find($id);
        $current = $cashflow->balance;
        $cashflow->operation = $request->operation;
        $cashflow->debit = $request->debit;
        $cashflow->credit = $request->credit;
        if($cashflow->debit != 0){
            $cashflow->balance = $current + $cashflow->debit;
        }else{
            $cashflow->balance = $current - $cashflow->credit;
        }
        $cashflow->user_id = $request->user_id;
        $cashflow->notes = $request->notes;

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
    }


}
