<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplies = Supplier::get();
        if(!$supplies){
            return response()->json([
                'success' => false,
                'message' => "Failed to get The Suppliers.",
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
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->address = $request->address;
            $supplier->email = $request->email;
            $supplier->contact = $request->contact;
            
            if($supplier->save()){
                $supplier->save();
                return response()->json([
                    'success' => true,
                    'message' => "A New Supplier has been added.",
                    'data'    => $supplier
                ], 200);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => "A New Supplier can't be added.",
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
        $supplier = Supplier::find($id);

        if(!$supplier){
            return response()->json([
                'success' => false,
                'message' => "Failed to get The Supplier.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get a Supplier.",
            'data'    => $supplier
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->quantity = $request->quantity;

        if(!$supplier->save()){
            return response()->json([
                'success' => false,
                'message' => "Failed to get update The Supplier.",
                'data'    => ''
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => "The Supplier has been updated.",
            'data'    => $supplier
        ], 200);
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id)->delete();

        if(!$supplier){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete The Supplier.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "A Supplier has been deleted.",
            'data'    => $supplier
        ], 200);
    }
}
