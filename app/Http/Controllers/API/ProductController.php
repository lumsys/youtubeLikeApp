<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Products;
use App\Orders;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function create(Request $request){
        try{
        $validator = Validator::make($request->all(),[
            'name' => 'nullable|min:2|max:45',
            'details' => 'nullable|min:2|max:450',
            'price' => 'nullable',
            'stock' => 'nullable|min:2|max:200',
            'discount' => 'nullable|min:2|max:200',
            'profile_picture' => 'nullable|image'
        ]);
            if($validator->fails()){
                $error = $validator->errors()->all()[0];
                return response()->json(['status'=>'false', 'message'=>$error, 'data'=>[]],422);
            }else{
        $product = new Products;
        $product->name = $request->name;
        $product->details = $request->details;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->discount =$request->discount;
        if($request->product_image && $request->profile_picture->isValid())
                    {
                        $file_name = time().'.'.$request->product_image->extension();
                        $request->profile_picture->move(public_path('images'),$file_name);
                        $path = "images/$file_name";
                        $product->product_image = $path;
                    }
        $product->save();
        return response()->json(["message" => "Product record created"], 200);
                }
            }
                catch(\exception $e){
                    return response()->json([
                        'message' => 'An error occured',
                        'short_description' => $e->getMessage()
                    ],400);

                }
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
    
    function getPriceByProductId($product_id)
    {
        $price = Products::where('id', $product_id)->first();
        return $price->price;
    }

    public function checkout(Request $request){
        $user_id  = "11";
        $total = $request->input('total');
        $cart = $request->input('cart');
        try{
            for($i = 0; $i < count($cart); $i++){
                $order_id = str_random(15);
                $product_id = $cart[$i]['product_id'];
                $price = $this->getPriceByProductId($product_id);
                $order = new Orders();
                $order->product_id = $product_id;
                $order->price = $price;
                $order->order_id = $order_id;
                $order->save();

                return response()->json(['message' => 'Checkout Succesfully', 'data' => $order],200);
            }
        }catch(\exception $e){
            return response()->json([
                'message' => 'An error occured',
                'short_description' => $e->getMessage()
            ],400);
        }
    }
}
