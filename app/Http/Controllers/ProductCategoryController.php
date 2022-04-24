<?php

namespace App\Http\Controllers;
 
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Validator;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $product_categories = ProductCategory::withCount(['products as products'])->get();

        if($product_categories){
            return response()->json([
                'success' => true,
                'message' => "All Categories has been loaded.",
                'data'    => $product_categories
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load Categories.",
            'data'    => ''
        ], 404);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'name' => ['required', 'string'],
        ]);
      
        if($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' => $error
            ], 403);
        }

        try{
            $product_category = new ProductCategory();
            $product_category->name = ucwords(strtolower($request->name));
            if($product_category->save()){ 
                return response()->json([
                    'success' => true,
                    'message' => "A New Category has been created.",
                    'data'    => $product_category
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
        $product_category = ProductCategory::where('id',$id)->get();
        if($product_category){
            return response()->json([
                'success' => true,
                'message' => "Selected Category has been loaded.",
                'data'    => $product_category
            ], 200);
        }
        
        return response()->json([
            'success' => false,
            'message' => "Failed to get selected Category." 
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[ 
            'name' => ['required', 'string'],
        ]);
      
        if($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' => $error
            ], 403);
        }
        try {
            $product_category = ProductCategory::find($id);
            $product_category->name = ucwords(strtolower($request->name));
    
            if($product_category->save()){
                return response()->json([
                    'success' => true,
                    'message' => "Selected Category has been updated.",
                    'data'    => $product_category
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => "Failed to update selected Category." 
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
        $product_category = ProductCategory::find($id)->delete();

        if($product_category){
            return response()->json([
                'success' => true,
                'message' => "Selected Category has been deleted."
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete selected Category." 
        ], 404);
    }
}
