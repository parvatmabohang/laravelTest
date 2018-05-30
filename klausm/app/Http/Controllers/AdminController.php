<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input(); 
            
            if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])) {
                Session::put('adminSession',$data['email']);
                return redirect('/admin/dashboard');
             } else {
                 return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
            }
        }
        return view("admin.admin_login");
    }
    public function dashboard(Request $request)
    {
        if(Session::has('adminSession')) {
            return view("admin.dashboard");
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
        
    }
    public function settings()
    {
        if(Session::has('adminSession')) {
            return view("admin.settings");
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
        
    }
    public function logout()
    {
         Session::flush();
         return redirect('/admin')->with('flash_message_success','Logged Out Successfully');
    }
    public function chkPassword(Request $request)
    {
        if(Session::has('adminSession')) {
            $rt = Session::get('adminSession');
            $data = $request->all();
            $current_password = $data['current_pwd'];
            $check_password = User::where(['admin'=>'1','email'=>$rt])->first();
            if(Hash::check($current_password,$check_password->password)){
                echo true;
            } else {
                echo "false";
            }
            
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
      
    }
    public function updatePassword(Request $request)
    {
       if(Session::has('adminSession')) {
           $rt = Session::get('adminSession');
           if ($request->isMethod('post')){
            $data = $request->all();
            $current_password = $data['current_pwd'];   
            $check_password = User::where(['admin'=>'1','email'=>$rt])->first();
            if(Hash::check($current_password,$check_password->password)){
                $password = bcrypt($data['new_pwd']);
                User::where(['admin'=>'1','email'=>$rt])->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success','Password Updated Successfully');
             } else {
                return redirect('/admin/settings')->with('flash_message_error','Incorrect Current Password');
            }        
           }
        } else {
            return redirect('/admin')->with('flash_message_error','Please login to access');
        }
    }
    
}
