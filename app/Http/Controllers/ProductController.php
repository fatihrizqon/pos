<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::join('stocks','stocks.product_id', '=', 'products.id')
                    ->join('supplies', 'supplies.product_id', '=', 'products.id')
                    ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
                    ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
                    ->select('products.*', 'suppliers.name as supplier', 'product_categories.name as category', 'stocks.quantity as stocks')
                    ->get();

        // $products = Product::get();

        if(!$products){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the products.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get all products.",
            'data'    => $products
        ], 200);
    }

    public function create(Request $request)
    {
        try{
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category_id = $request->category_id; /* Drop Down */
            if($product->save()){
                return response()->json([
                    'success' => true,
                    'message' => "A new product has been added.",
                    'data'    => $product
                ], 200);
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
        $product = Product::where('id',$id)->get();
        if(!$product){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the product.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get a products.",
            'data'    => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $product = product::find($id);
        $product->quantity = $request->quantity;

        if(!$product->save()){
            return response()->json([
                'success' => false,
                'message' => "Failed to get update the product.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "The product has been updated.",
            'data'    => $product
        ], 200);
    }

    public function delete($id)
    {
        $product = product::find($id)->delete();

        if(!$product){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete the product.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "A product has been deleted.",
            'data'    => $product
        ], 200);
    }
}
