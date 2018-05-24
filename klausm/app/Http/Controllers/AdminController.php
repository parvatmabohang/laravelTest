<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
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
    public function logout()
    {
         Session::flush();
         return redirect('/admin')->with('flash_message_success','Logged Out Successfully');
    }
    
}
