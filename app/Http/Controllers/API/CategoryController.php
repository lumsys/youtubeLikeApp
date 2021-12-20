<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\cate;

class CategoryController extends Controller
{
    //
public function category(Request $request){
    $category = new cate();
    $category ->name=$request->input('name');
    $category->user_id = $request->user()->id;
    $category -> save();
    return response()->json(['success' => true,]);
    }

    public function getCateList()
    {
        $categoryList = Cate::all();
        return response()->json($categoryList);
    }
}
