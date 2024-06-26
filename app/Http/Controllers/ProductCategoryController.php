<?php

namespace App\Http\Controllers;
 
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


    public function import(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'product_categories' => ['required', 'string'] 
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error 
          ], 403);
        }
        $data = json_decode($request->product_categories, true);
        
        if(!$data){
            return response()->json([
                'success' => false,
                'message' => "Unable to Import an Empty Data." 
            ], 400); 
        }

        try { 
            if($this->rules($data)){
                foreach ($data as $value) {
                    ProductCategory::create(array(
                        'name' => ucwords(strtolower($value['category_name'])), 
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
        if( array_key_exists('category_name', $data[0])
            ){
            return true;
        }else{
            return false;
        }
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
        $product_category = ProductCategory::find($id);
        
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
