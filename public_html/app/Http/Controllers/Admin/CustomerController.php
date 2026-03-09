<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App;
use DB;
use Excel;
use Auth;

use App\Model\Customer as DTCustomer;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $View=[];
    public function add(Request $request)
    {
      
        if($request->isMethod("post")){
          //  dd($request->input('is_kl'));
              $validator=Validator::make($request->all(),[
                  "name"=>"required",
              
                

              ],[
                  "name.required"=>" Vui lòng nhập tên khách . " ,
               

                   
               
              ]);

              if($validator->fails()){
                  return redirect()->back()->withErrors($validator)->withInput();
              }else{
                $check_validator=DTCustomer::where("name",$request->input("name"))->where("email",$request->input("email"))->where("phone",$request->input("phone"))->first();

                if(!empty($check_validator)){
                  $validator->errors()->add("name"," Thông tin khách hàng này đã tồn tại. " );
                  return redirect()->back()->withErrors($validator)->withInput();
                }

                  $TNew=new DTCustomer();
                  $TNew->name= $request->input("name");
                  $TNew->code=App\MrData::toAlias2($request->input("name"));
                
                  $TNew->phone=$request->input("phone");
                  $TNew->email=$request->input("email");
                  $TNew->address=$request->input("address");
                  $TNew->company=$request->input("company");
                  $TNew->note=$request->input("note");
                   $TNew->fax=$request->input("fax");

                   $TNew->is_kl=$request->input("is_kl",'1');


                   if(Auth::check()){
                      $TNew->cid_users=Auth::user()->id;
                   }else{
                      $TNew->cid_users=-1;
                   }
                 $TNew->save();
                 

                $request->session()->flash("success"," Thêm mới khách hàng thành công. ");
                return redirect()->back();
            }
        }


       $data=[];

        $this->View['data']=$data;
        return view("admin.customer.add",$this->View);
    }
   
    public function lists(Request $request){
        $search=[];

           $sql=" id > 0 ";

           $search['name']=$name=$request->input("name","");
           $search['is_kl']='';
           if(!empty($name)){
              $sql= $sql. " AND name LIKE '%{$name}%' ";

           } 
           if($request->input("is_kl")){
              $kl=$request->input("is_kl");
              $search['is_kl']=$kl;
              $sql= $sql. " AND is_kl= '{$kl}' ";
           }


           $this->View['search']=$search;
    

         $TData= DTCustomer::whereRaw(DB::raw($sql))->orderBy("id","DESC")
              ->paginate(20);

         $this->View['is_kl'] =['1'=>" Khách ",'2'=>" Khách lẻ",''=>"Tất cả"];    
         $this->View['data_list']=$TData;
                           
        return view("admin.customer.lists",$this->View);
    }
    public function edit($id,Request $request){
        if($request->isMethod("post")){
              $validator=Validator::make($request->all(),[
                  "name"=>"required"//|unique:DT_Customer,name,{$id},id",
              
                

              ],[
                  "name.required"=>" Vui lòng nhập tên khách hàng. " ,
                  // "name.unique"=>" Tên khách hàng này đã tồn tại. " ,

                   
               
              ]);
              if($validator->fails()){
                  return redirect()->back()->withErrors($validator)->withInput();
              }else{
             

                  $TUpdated=DTCustomer::find($id);
                  $TUpdated->name= $request->input("name");
                  $TUpdated->code=App\MrData::toAlias2($request->input("name"));
                
                  $TUpdated->phone=$request->input("phone");
                  $TUpdated->email=$request->input("email");
                  $TUpdated->address=$request->input("address");
                  $TUpdated->company=$request->input("company");
                  $TUpdated->note=$request->input("note");
                     $TUpdated->fax=$request->input("fax");
                     $TUpdated->is_kl=$request->input("is_kl",'1');

                   if(Auth::check()){
                      $TUpdated->cid_users=Auth::user()->id;
                   }else{
                      $TUpdated->cid_users=-1;
                   }
                 $TUpdated->save();
                 

                $request->session()->flash("success"," Cập nhật thông tin mới về khách hàng thành công. ");
                return redirect()->back();
            }
        }


       $data=[];
       $data=DTCustomer::find($id)->toArray();
        $this->View['data']=$data;
        return view("admin.customer.edit",$this->View);



    }
    public function remove(Request $request)
    {
        //
        if($request->isMethod("post")){
            if($id=$request->input("id")){
                $data=DTCustomer::find($id);
                if(count($data->Form())==0){
                     $data->delete();
                }
               
                echo 'Destroy Success';exit;
            }
        }

    }
   
    public function export(Request $request){
          $name_excel="Danh sách khách hàng: ". date("d-m-Y H:i:s");
          Excel::download(function() use ($request){
          //  $excel->sheet('Danh sách khách hàng ', function($sheet) use ($request) {


                $name=$request->input("name","");
          


         
    

                  $TData= DTCustomer::where("name","LIKE","%{$name}%")->orderBy("id","DESC")
              ->paginate(20);



                $result=[];
                $result[]=["ID","CODE","NAME","PHONE","EMAIL","ADDRESS","NOTE","CREATE AT"];
              
                foreach ($TData as  $v) {
                  $value=(array)$v;
                  
                    $result[]=array(
                      $value['id'],
                      $value['code'],
                      $value['name'],
                      $value['phone'],
                      $value['email'],
                      $value['address'],
                  
                      $value['note'],
                      $value['created_at']
                    );
                  
                }
               
                return 'ladsf,asdf';

            //});

        } ,$name_excel);//->download('csv');
    }
}
