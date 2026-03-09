<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App;
use Excel;
use Auth;
use App\Model\Users as DTUsers;
use App\Model\Log as DTLog;
class UsersController extends Controller
{
    protected $View=[];
     public function add(Request $request)
    {
        if(Auth()->user()->roles =='2'){
            return redirect("/admin/index/index");
        }
        $data=[];
        if($request->isMethod("post")){
            $validater=Validator::make($request->all(),[
                "name"=>"required|max:225",
              
                "username"=>"required|max:225|unique:users",
                "password"=>"required|confirmed|min:6",
                "roles"=>"required"
               
            ],[
                "name.required"=>"Vui lòng nhập tên nhân viên .",
                "name.max"=>"Vượt quá ký tự giới hạn",
               
                "username.required"=>"Vui lòng nhập tên đăng nhập",
                "username.unique"=>"Tên đăng nhập đã tồn tại ",
                "password.required"=>"Vui lòng nhập mật khẩu",
                "password.min"=>"Mật khẩu không nhỏ hơn 6 ký tự",
               
                "password.confirmed"=>"Nhập lại mật khẩu không chính xác",
                "roles.required"=>"Vui lòng chọn phân quyền. "
            ]);
            if($validater->fails()){
                return redirect()->back()->withErrors($validater)->withInput();
            }else{

                $TNew=new DTUsers();
                $TNew->name=$request->input("name");
                $TNew->email=$request->input("email");
                $TNew->phone=$request->input("phone");
                $TNew->note=$request->input("note");

                $TNew->username=$request->input("username");
                $TNew->password=bcrypt($request->input("password"));

                $TNew->roles=$request->input("roles");
                $TNew->save();
                
                $request->session()->flash("success","Thêm mới quản trị viên thành công.");
                return redirect()->back();
            }
        }
        $this->View['roles']=['1'=>"Supper Admin",'2'=>"Nhân Viên"];
        $data['roles']='2';
        $this->View['data']=$data;

        return view("admin.user.add",$this->View);
    }
   

    
    public function lists(Request $request){

        if(Auth()->user()->roles =='2'){
            return redirect("/admin/index/index");
        }

         $search=[];

      
           $search['name']=$name=$request->input("name","");
          


           $this->View['search']=$search;
    

         $TData= DTUsers::where("name","LIKE","%{$name}%")->orderBy("id","DESC")
              ->paginate(20);

         $this->View['data_list']=$TData;
                           
        return view("admin.user.lists",$this->View);
    }
    public function edit($id,Request $request){

        if(Auth()->user()->roles =='2'){
            return redirect("/admin/index/index");
        }

        $data=[];
        if($request->isMethod("post")){
                 if($password=$request->input("password")){
                     $validater=Validator::make($request->all(),[
                            "name"=>"required|max:225",
                          
                            "username"=>"required|max:225|unique:users,username,{$id},id",
                            "password"=>"required|confirmed|min:6",
                            "roles"=>"required"
                           
                        ],[
                            "name.required"=>"Vui lòng nhập tên nhân viên .",
                            "name.max"=>"Vượt quá ký tự giới hạn",
                           
                            "username.required"=>"Vui lòng nhập tên đăng nhập",
                            "username.unique"=>"Tên đăng nhập đã tồn tại ",
                            "password.required"=>"Vui lòng nhập mật khẩu",
                            "password.min"=>"Mật khẩu không nhỏ hơn 6 ký tự",
                           
                            "password.confirmed"=>"Nhập lại mật khẩu không chính xác",
                            "roles.required"=>"Vui lòng chọn phân quyền. "
                        ]);
                }else{
                     $validater=Validator::make($request->all(),[
                            "name"=>"required|max:225",
                          
                            "username"=>"required|max:225|unique:users,username,{$id},id",
                         
                            "roles"=>"required"
                           
                        ],[
                            "name.required"=>"Vui lòng nhập tên nhân viên .",
                            "name.max"=>"Vượt quá ký tự giới hạn",
                           
                            "username.required"=>"Vui lòng nhập tên đăng nhập",
                            "username.unique"=>"Tên đăng nhập đã tồn tại ",
                           
                            "roles.required"=>"Vui lòng chọn phân quyền. "
                        ]);
                }

           
            if($validater->fails()){
                return redirect()->back()->withErrors($validater)->withInput();
            }else{

                $TUpdated= DTUsers::find($id);
                $TUpdated->name=$request->input("name");
                $TUpdated->email=$request->input("email");
                $TUpdated->phone=$request->input("phone");
                $TUpdated->note=$request->input("note");

                $TUpdated->username=$request->input("username");

                if($password=$request->input("password")){
                 $TUpdated->password=bcrypt($request->input("password"));
                }
                $TUpdated->roles=$request->input("roles");
                $TUpdated->save();
                
                $request->session()->flash("success","Cập nhật quản trị viên thành công.");
                return redirect()->back();
            }
        }
        $this->View['roles']=['1'=>"Supper Admin",'2'=>"Nhân Viên"];
        $data['roles']='2';
        $data=DTUsers::find($id)->toArray();
        $this->View['data']=$data;

        return view("admin.user.edit",$this->View);
    }
    public function remove(Request $request)
    {
        if(Auth()->user()->roles =='2'){
            return redirect("/admin/index/index");
        }   
        if($request->isMethod("post")){
            if($id=$request->input("id")){
                $User = App\User::find($id);
                if(!empty($User)){
                   
                  
                   $User->delete();
                }
                echo 'destroy success';exit;
            }
        }

    }
     public function log(Request $request){

        if(Auth()->user()->roles =='2'){
            return redirect("/admin/index/index");
        }

    
            $search=[];

           $sql=" id > 0";

           if($cid_user=$request->input("cid_user")){
                $sql= $sql. " AND  cid_user =  {$cid_user} ";
                $search['cid_user']=$cid_user;
           } 
      
            $this->View['cid_user']=DTUsers::orderBy("name","DESC")->pluck("name","id");


           $this->View['search']=$search;
    

         $TData= DTLog::whereRaw(DB::raw($sql))->orderBy("id","DESC")
              ->paginate(20);

         $this->View['data_list']=$TData;
        return view("admin.user.log",$this->View);
    }
}
