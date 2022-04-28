<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker; 
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;


class ProductController extends Controller
{
    public function index()
    {  
        $products = Product::get();

        if($products){
            return response()->json([
                'success' => true,
                'message' => "Products has been loaded.",
                'data'    => $products
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load the Products.",
            'data'    => ''
        ], 404); 
    }

    public function allproducts()
    {  
        $products = Product::join('product_categories', 'product_categories.id', '=', 'products.category_id')
                    ->join('supplies', 'supplies.product_id', '=', 'products.id')->distinct()
                    ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id') 
                    ->select('products.*', 'products.stocks as stocks', 'suppliers.name as supplier', 'product_categories.name as category') 
                    ->get();

        if($products){
            return response()->json([
                'success' => true,
                'message' => "All Products has been loaded.",
                'data'    => $products
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to load the Products.",
            'data'    => ''
        ], 404); 
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'name'        => ['required', 'string'], 
            'purchase'    => ['required', 'integer'],
            'sell'        => ['required', 'integer'], 
            'category_id' => ['required', 'integer']
        ]);
      
        if($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' => $error
            ], 403);
        }

        $faker = Faker::create('id_ID');

        try{
            $product = new Product(); 
            $product->name = ucwords(strtolower($request->name));
            $product->code = $faker->regexify('[A-Z]{5}[0-4]{3}');
            $product->purchase = $request->purchase;
            $product->sell = $request->sell;
            $product->stocks = 0;
            $product->category_id = $request->category_id;

            if($product->save()){
                return response()->json([
                    'success' => true,
                    'message' => "A New Product has been created.",
                    'data'    => $product
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

    public function import(Request $request)
    {
        $faker = Faker::create('id_ID');
        $validator = Validator::make($request->all(),[ 
            'products' => ['required', 'string'] 
        ]);
    
        if($validator->fails()) {
          $error = $validator->errors()->first();
          return response()->json([
            'success' => false,
            'message' => $error 
          ], 403);
        }
        $data = json_decode($request->products, true);

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => "Unable to Import an Empty Data." 
            ], 400); 
        }

        try { 
            if($this->rules($data)){
                foreach ($data as $value) {
                    Product::create(array(
                      'name' => ucwords(strtolower($value['name'])), 
                      'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                      'purchase' => $value['purchase'],
                      'sell' => $value['sell'],
                      'stocks' => 0,
                      'category_id' => $value['category_id']
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
            array_key_exists('purchase', $data[0]) &&
            array_key_exists('sell', $data[0]) &&
            array_key_exists('category_id', $data[0])
            ){
            return true;
        }else{
            return false;
        }
    }

    public function view($id)
    {
        $product = Product::where('id',$id)->get();
        if($product){
            return response()->json([
                'success' => true,
                'message' => "Selected Product has been loaded.",
                'data'    => $product
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to get selected Product." 
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[ 
            'name'        => ['required', 'string'], 
            'purchase'    => ['required', 'integer'],
            'sell'        => ['required', 'integer'], 
            'category_id' => ['required', 'integer']
        ]);
      
        if($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' => $error
            ], 403);
        }
        
        try {
            $product = product::find($id); 
            $product->name = ucwords(strtolower($request->name));
            $product->purchase = $request->purchase;
            $product->sell = $request->sell;
            $product->category_id = $request->category_id;
    
            if($product->save()){
                return response()->json([
                    'success' => true,
                    'message' => "Selected Product has been updated.",
                    'data'    => $product
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => "Failed to update selected Product." 
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
        $product = product::find($id)->delete();

        if($product){
            return response()->json([
                'success' => true,
                'message' => "Selected Product has been deleted." 
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Failed to delete selected Product." 
        ], 404);
    }
}
