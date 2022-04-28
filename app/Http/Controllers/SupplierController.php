<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Validator;

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

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'suppliers' => ['required', 'string'] 
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error 
          ], 403);
        }
        $data = json_decode($request->suppliers, true);
        
        if(!$data){
            return response()->json([
                'success' => false,
                'message' => "Unable to Import an Empty Data." 
            ], 400); 
        }

        try { 
            if($this->rules($data)){
                foreach ($data as $value) {
                    Supplier::create(array(
                      'name' => ucwords(strtolower($value['name'])), 
                      'address' => ucwords(strtolower($value['address'])),    
                      'email' => strtolower($value['email']),
                      'contact' => $value['contact']
                    ));
                }
                return response()->json([
                    'success' => true,
                    'message' => "Import Data Success.",
                    'data'    => $data
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => "Incorrect Format File. Please kindly to use provided Import Format File." 
            ], 400);  

        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ], 403);
        }
    }

    public function rules($data)
    {
        if( array_key_exists('name', $data[0]) &&
            array_key_exists('address', $data[0]) &&
            array_key_exists('email', $data[0]) &&
            array_key_exists('contact', $data[0])
            ){
            return true;
        }else{
            return false;
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
          'name'     => ['required', 'string'], 
          'address'  => ['required', 'string'],
          'email'    => ['required', 'string'],
          'contact'  => ['required', 'string']
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error
          ], 403);
        }
        try{
            $supplier = new Supplier();
            $supplier->name = ucwords(strtolower($request->name));
            $supplier->address = ucwords(strtolower($request->address));
            $supplier->email = strtolower($request->email);
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
        $validator = Validator::make($request->all(),[ 
          'name'     => ['required', 'string'], 
          'address'  => ['required', 'string'],
          'email'    => ['required', 'string'],
          'contact'  => ['required', 'string']
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error
          ], 403);
        }
        
        try {
            $supplier = Supplier::find($id); 
            $supplier->name = ucwords(strtolower($request->name));
            $supplier->address = ucwords(strtolower($request->address));
            $supplier->email = strtolower($request->email);
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
        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ], 403);
        }

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
