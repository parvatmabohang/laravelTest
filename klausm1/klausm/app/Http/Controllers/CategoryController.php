<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        if(Session::has('adminSession')) {
        if($request->isMethod('post')) {
            $data = $request->all();
            $category = new Category;
            $category->parent_id = 0;
            $category->name = $data['category_name'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $rt = Category::where(['url'=>$data['url']])->count();
            if($rt != 0){
                return redirect('/admin/view-categories')->with('flash_message_success','url already exist.');
            }
            if(empty($data['status'])) {
                $category->status = 0;
            } else {
            $category->status = $data['status'];
            }
            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success','Category Added Successfully');
        }
        return view('admin.categories.add_category');
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    public function viewCategories()
    {
        if(Session::has('adminSession')) {
            $rt = Session::get('adminSession');
            $categories = Category::get();
        return view('admin.categories.view_categories')->with(compact('categories'));
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    public function editCategory(Request $request,$id = null)
    {
        if(Session::has('adminSession')) {
            if($request->isMethod('post')) {
                $data = $request->all();
                if(empty($data['status'])) {
                    $status = 0;} else {
                    $status = $data['status'];
                }
                Category::where(['id'=>$id])->update(['name'=>$data['category_name'],'description'=>$data['description'],'url'=>$data['url'],'status'=>$status]);
                return redirect('/admin/view-categories')->with('flash_message_success','Category Updated Successfully');
            }
            $categoryDetails = Category::where(['id'=>$id])->first();
            return view('admin.categories.edit_category')->with(compact('categoryDetails'));
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    public function deleteCategory($id = null)
    {
        if(Session::has('adminSession')) {
                Category::where(['id'=>$id])->delete();
                return redirect()->back()->with('flash_message_success','Category Deleted Successfully');
            
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    
}
