<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::get();
        if($suppliers){
            return response()->json([
                'success' => true,
                'message' => "All Suppliers has been loaded.",
                'data'    => $suppliers
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load the Suppliers." 
        ], 404);
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
                    'message' => "A New Supplier has been created.",
                    'data'    => $supplier
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => "An error has been occured."
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
        $supplier = Supplier::find($id);

        if($supplier){
            return response()->json([
                'success' => true,
                'message' => "Selected Supplier has been loaded.",
                'data'    => $supplier
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to get The Supplier.",
            'data'    => ''
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id); 
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->email = $request->email;
        $supplier->contact = $request->contact;

        if($supplier->save()){
            return response()->json([
                'success' => true,
                'message' => "The Supplier has been updated.",
                'data'    => $supplier
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to get update The Supplier." 
        ], 404); 
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id)->delete();

        if($supplier){
            return response()->json([
                'success' => true,
                'message' => "A Supplier has been deleted." 
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete The Supplier."  
        ], 404);
    }
}
