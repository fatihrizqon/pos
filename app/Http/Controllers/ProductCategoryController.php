<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $product_categories = ProductCategory::get();
        if(!$product_categories){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the product categories.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get all product categories.",
            'data'    => $product_categories
        ], 200);
    }

    public function create(Request $request)
    {
        try{
            $product_category = new ProductCategory();
            $product_category->name = $request->name;
            if($product_category->save()){
                return response()->json([
                    'success' => true,
                    'message' => "A new product category has been added.",
                    'data'    => $product_category
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
        $product_category = ProductCategory::where('id',$id)->get();
        if(!$product_category){
            return response()->json([
                'success' => false,
                'message' => "Failed to get the product category.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Get a product category.",
            'data'    => $product_category
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $product_category = ProductCategory::find($id);
        $product_category->quantity = $request->quantity;

        if(!$product_category->save()){
            return response()->json([
                'success' => false,
                'message' => "Failed to get update the product category.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "The product category has been updated.",
            'data'    => $product_category
        ], 200);
    }

    public function delete($id)
    {
        $product_category = ProductCategory::find($id)->delete();

        if(!$product_category){
            return response()->json([
                'success' => false,
                'message' => "Failed to delete the product category.",
                'data'    => ''
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "A product category has been deleted.",
            'data'    => $product_category
        ], 200);
    }
}
