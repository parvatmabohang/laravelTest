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
        //$productsAll = Product::with('images')->orderBy('id','DESC')->get();
        $productsAll = Product::with('images')->join('pcats', 'pcats.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'pcats.cat_id')
            ->where('categories.status', '=', 1)
            ->select('pcats.*', 'categories.*','products.*')
            //->groupBy('id')
            ->orderBy('products.id','DESC')
            ->get();
        //$productsAll = json_decode(json_encode($productsAll));
        //cho "<pre>";print_r($productsAll); die;
        //Get Categories
        $categories = Category::where(['parent_id'=>0,'status'=>1])->get();
        return view('index')->with(compact('productsAll','categories'));
    }
    public function productDetails($id= null)
    {
        $countProduct = Product::where(['id'=>$id])->count();
        if($countProduct == 0) {
            abort(404);
        }
        $productS = Product::with('attributes','images')->where('products.id',$id)->join('pcats', 'pcats.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'pcats.cat_id')
            ->where('categories.status', '=', 1)
            ->select('pcats.*', 'categories.*','products.*')
            ->get();
        if(count($productS) == 0) {
            abort(404);
        }
        //$productS = Product::with('attributes')->where(['id'=>$id])->first();
        //$productS = Product::with('attributes','images')->where(['id'=>$id])->first();
       // $productS = json_decode(json_encode($productS));
        //echo "<pre>";print_r($productS); die;
        $categories = Category::where(['parent_id'=>0,'status'=>1])->get();
        return view('product_details')->with(compact('categories','productS'));
    }
}
