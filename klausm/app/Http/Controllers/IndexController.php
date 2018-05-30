<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index()
    {
        //Get Products
        $productsAll = Product::orderBy('id','DESC')->get();
        
        //Get Categories
        $categories = Category::where(['parent_id'=>0,'status'=>1])->get();
        return view('index')->with(compact('productsAll','categories'));
    }
    public function productDetails($id= null)
    {
        //$productS = Product::with('attributes')->where(['id'=>$id])->first();
        $productS = Product::with('attributes')->where(['id'=>$id])->first();
        //$productS = json_decode(json_encode($productS));
        //echo "<pre>";print_r($productS); die;
        //print_r($productS);die;
        $categories = Category::where(['parent_id'=>0,'status'=>1])->get();
        return view('product_details')->with(compact('categories','productS'));
    }
}
