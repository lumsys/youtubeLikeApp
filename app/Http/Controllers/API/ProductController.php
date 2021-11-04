<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Products;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request){
        $product = new Products;
        $product->name = $request->name;
        $product->details = $request->details;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->discount =$request->discount;
        $product->save();
        return response()->json(["message" => "Product record created"], 200);
    }

    public function getAllproducts() {
        $products = Products::get()->toJson(JSON_PRETTY_PRINT);
        return response($products, 200);
      }
    
    public function getProduct($id){
    if (Products::where('id', $id)->exists()) {
        $product = Products::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($product, 200);
      }else{
        return response()->json(["message" => "Oops, Product not found. Please check back again."], 404);
        }
    }

    public function updateProduct(Request $request, $id) {
        if (Products::where('id', $id)->exists()){
            $product = Products::find($id);
            $product->name = is_null($request->name) ? $product->name : $request->name;
            $product->details = is_null($request->details) ? $product->details : $request->details;
            $product->price = is_null($request->price) ? $product->price : $request->price;
            $product->stock = is_null($request->stock) ? $product->stock : $request->stock;
            $product->discount = is_null($request->discount) ? $product->discount : $request->discount;

            $product->save();
    
            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "product not found"
            ], 404);
            
        }
    }

    public function deleteProduct ($id) {
        if(products::where('id', $id)->exists()) {
            $product = products::find($id);
            $product->delete();

            return response()->json([
            "message" => "Product deleted"
            ], 202);
        } else {
            return response()->json([
            "message" => "product not found"
            ], 404);
        }
        }

    public function addToCart(){
        
    }
}
