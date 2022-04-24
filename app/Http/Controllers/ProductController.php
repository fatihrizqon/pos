<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker; 
use App\Models\Product;
use Illuminate\Http\Request;

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
        $faker = Faker::create('id_ID');

        try{
            $product = new Product(); 
            $product->name = $request->name;
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
        $product = product::find($id); 
        $product->name = $request->name;
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
