<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
class AuthController extends Controller
{
    //
    public function login(Request $request){
		if($request->isMethod("post")){
    	
		        $validator=Validator::make($request->all(),[
		                "username"=>"required",
		                "password"=>"required"
		        ],[
		                "username.required"=>"Vui lòng nhập tên đăng nhập ",
		                "password.required"=>"Vui lòng nhập mật khẩu "
		        ]);
		        if($validator->fails()){
		            return redirect()->back()->withErrors($validator)->withInput();
		        }else{
		            if(Auth::attempt(['username'=>$request->input("username"),'password'=>$request->input("password")])){
		                return redirect("/admin/index/lists");
		            }else{
		                $validator->errors()->add("username"," Tên đăng nhập hoặc mật khẩu không chính xác");
		                return redirect()->back()->withErrors($validator);
		            }
		        }
		    
    	}
    	return view("auth.getLogin",[]);
    }
    public function getLogout(){
    		Auth::logout();
    		return redirect("/login");
    }
}
