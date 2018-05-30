<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use Auth;
use App\Product;
use App\Category;
use App\Pattribute;

class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {
        if(Session::has('adminSession')) {
            if($request->isMethod('post')) {
               $data = $request->all();
                //echo "<pre>";print_r($data); die;
               $product = new Product;
                $product->user_id = 8;
                $product->category_id = $data['category_id'];
                $product->product_name = $data['product_name'];
                $product->product_code = $data['product_code'];
                $product->product_color = $data['product_color'];
                $product->description = $data['description'];
                $product->price = $data['product_price'];
                //upload image
                if($request->hasFile('image')) {
                    $image_tmp=Input::file('image');
                    if($image_tmp->isValid()){
                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename=rand(111,99999).'.'.$extension;
                        $large_image_path='images/backend_images/products/large/'.$filename;
                        $medium_image_path='images/backend_images/products/medium/'.$filename;
                        $small_image_path='images/backend_images/products/small/'.$filename;
                        //Resize Images
                        Image::make($image_tmp)->save($large_image_path);
                        Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                        Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                        $product->image = $filename;
                    }
                }
                
                $product->save();
                return redirect("/admin/view-products")->with('flash_message_success','Product Added Successfully');
            }
            $categories = Category::where(['parent_id'=>0])->get();
            $categories_dropdown = "";
            //$categories_dropdown = "<option value='".$categories->id."'>".$categories->name."</option>";
            foreach($categories as $cat) {
                $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            }
            return view('admin.products.add_product')->with(compact('categories_dropdown'));
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    public function viewProducts()
    {
        if(Session::has('adminSession')) {
            $rt = Session::get('adminSession');
            $products = Product::where(['user_id'=>8])->get();
            foreach($products as $key=>$val) {
                $category_name=Category::where(['id'=>$val->category_id])->first();
                $products[$key]->category_name=$category_name->name;
            }
        return view('admin.products.view_products')->with(compact('products'));
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    public function editProduct(Request $request,$id = null)
    {
        if(Session::has('adminSession')) {
            if($request->isMethod('post')) {
                $data = $request->all();
                
                if($request->hasFile('image')) {
                    $image_tmp=Input::file('image');
                    if($image_tmp->isValid()){
                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename=rand(111,99999).'.'.$extension;
                        $large_image_path='images/backend_images/products/large/'.$filename;
                        $medium_image_path='images/backend_images/products/medium/'.$filename;
                        $small_image_path='images/backend_images/products/small/'.$filename;
                        //Resize Images
                        Image::make($image_tmp)->save($large_image_path);
                        Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                        Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                        
                    }
                } else {
                    $filename=$data['current_image'];
                }
                
                Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'price'=>$data['product_price'],'image'=>$filename]);
                return redirect()->back()->with('flash_message_success','Product Updated Successfully');
            }
            $productDetails = Product::where(['id'=>$id])->first();
            
            $categories = Category::where(['parent_id'=>0])->get();
            
            $category_dropdown = "";
            //$categories_dropdown = "<option value='".$categories->id."'>".$categories->name."</option>";
            foreach($categories as $cat) {
                if($cat->id == $productDetails->category_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $category_dropdown .= "<option value='".$cat->id."'".$selected.">".$cat->name."</option>";
            }
            return view('admin.products.edit_product')->with(compact('productDetails','category_dropdown'));
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    public function deleteProductImage($id = null)
    {
        $productImage = Product::where(['id'=>$id])->first();
        
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';
        
        if(file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }
        if(file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }
        if(file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }
        
        Product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success','Product image has been deleted...');
    }
    public function deleteProduct($id = null)
    {
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been removed...');
    }
    public function addAttributes(Request $request,$id = null)
    {
        if(Session::has('adminSession')) {
                 $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
                 // $productDetails = json_decode(json_encode($productDetails));
                 //echo "<pre>"; print_r($productDetails); die;
                 if ($request->isMethod('post')) {
                     $data = $request->all();
                     //echo "<pre>"; print_r($data); die;
                     foreach($data['sku'] as $key=>$val) {
                         if(!empty($val)) {
                             $attribute = new Pattribute;
                             $attribute->product_id = $id;
                             $attribute->sku = $val;
                             $attribute->size = $data['size'][$key];
                             $attribute->price = $data['price'][$key];
                             $attribute->stock = $data['stock'][$key];
                             $attribute->save();
                             //echo "<pre>";print_r($attribute);die;
                         }
                     }
                     return redirect()->back()->with('flash_message_success','Product Attributes Added Successfully');
                 }
                //return redirect()->back()->with('flash_message_success','Category Deleted Successfully');
                return view("admin.products.add_attributes")->with(compact('productDetails'));
            
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    public function deleteAttribute($id = null)
    {
        Pattribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute has been removed...');
    }
    public function products($url = null)
    {
        //Show Error Page
        $countCategory = Category::where(['url'=>$url,'status'=>1])->count();
        if($countCategory == 0) {
            abort(404);
        }
        $categoryDetails = Category::where(['url'=>$url,'status'=>1])->first();
        $categories = Category::where(['parent_id'=>0,'status'=>1])->get();
        //echo $categoryDetails->id;die;
        $productsAll = Product::where(['category_id'=>$categoryDetails->id])->get();
        return view('products.listing')->with(compact('categories','categoryDetails','productsAll'));
    }
    public function getProductPrice(Request $request) 
    {
        $data = $request->all();
        $re = $data['idSize'];
        $ret = Pattribute::where(['id'=>$re])->first();
        $yu = [];
        $yu[] = $ret->price;
        $yu[] =  $ret->stock;
        echo json_encode($yu);
    }
}
