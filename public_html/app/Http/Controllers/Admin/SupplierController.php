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

use App\Model\Supplier as DTSupplier;


class SupplierController extends Controller
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
              $validator=Validator::make($request->all(),[
                  "name"=>"required|unique:DT_Supplier",
              
                

              ],[
                  "name.required"=>" Vui lòng nhập tên nhà cung cấp. " ,
                   "name.unique"=>" Tên nhà cung cấp này đã tồn tại. " ,

                   
               
              ]);
              if($validator->fails()){
                  return redirect()->back()->withErrors($validator)->withInput();
              }else{
             

                  $TNew=new DTSupplier();
                  $TNew->name= $request->input("name");
                  $TNew->code=App\MrData::toAlias2($request->input("name"));
                
                  $TNew->phone=$request->input("phone");
                  $TNew->email=$request->input("email");
                  $TNew->address=$request->input("address");
                  $TNew->note=$request->input("note");

                  $TNew->phidichthuat=$request->input("phidichthuat");
                  $TNew->congchung=$request->input("congchung");
                  $TNew->daucongty=$request->input("daucongty");
                  $TNew->saoy=$request->input("saoy");
                  $TNew->ngoaivu=$request->input("ngoaivu");
                  $TNew->phivanchuyen=$request->input("phivanchuyen");
                  $TNew->vat=$request->input("vat");
                  $TNew->tong=$request->input("tong");

                   if(Auth::check()){
                      $TNew->cid_users=Auth::user()->id;
                   }else{
                      $TNew->cid_users=-1;
                   }
                 $TNew->save();
                 

                $request->session()->flash("success"," Thêm mới nhà cung cấp thành công. ");
                return redirect()->back();
            }
        }


       $data=[];

        $this->View['data']=$data;
        return view("admin.supplier.add",$this->View);
    }
   
    public function lists(Request $request){
        $search=[];

      
           $search['name']=$name=$request->input("name","");
          


           $this->View['search']=$search;
    

         $TData= DTSupplier::where("name","LIKE","%{$name}%")->orderBy("id","DESC")
              ->paginate(20);

         $this->View['data_list']=$TData;
                           
        return view("admin.supplier.lists",$this->View);
    }
    public function edit($id,Request $request){
        if($request->isMethod("post")){
              $validator=Validator::make($request->all(),[
                  "name"=>"required|unique:DT_Supplier,name,{$id},id",
              
                

              ],[
                  "name.required"=>" Vui lòng nhập tên nhà cung cấp. " ,
                   "name.unique"=>" Tên nhà cung cấp này đã tồn tại. " ,

                   
               
              ]);
              if($validator->fails()){
                  return redirect()->back()->withErrors($validator)->withInput();
              }else{
             

                  $TUpdated=DTSupplier::find($id);
                  $TUpdated->name= $request->input("name");
                  $TUpdated->code=App\MrData::toAlias2($request->input("name"));
                
                  $TUpdated->phone=$request->input("phone");
                  $TUpdated->email=$request->input("email");
                  $TUpdated->address=$request->input("address");
                  $TUpdated->note=$request->input("note");


                  $TUpdated->phidichthuat=$request->input("phidichthuat");
                  $TUpdated->congchung=$request->input("congchung");
                  $TUpdated->daucongty=$request->input("daucongty");
                  $TUpdated->saoy=$request->input("saoy");
                  $TUpdated->ngoaivu=$request->input("ngoaivu");
                  $TUpdated->phivanchuyen=$request->input("phivanchuyen");
                  $TUpdated->vat=$request->input("vat");
                  $TUpdated->tong=$request->input("tong");
                  
                   if(Auth::check()){
                      $TUpdated->cid_users=Auth::user()->id;
                   }else{
                      $TUpdated->cid_users=-1;
                   }
                 $TUpdated->save();
                 

                $request->session()->flash("success"," Cập nhật thông tin mới về nhà Cung Cấp thành công. ");
                return redirect()->back();
            }
        }


       $data=[];
       $data=DTSupplier::find($id)->toArray();
        $this->View['data']=$data;
        return view("admin.supplier.edit",$this->View);



    }
    public function remove(Request $request)
    {
        //
        if($request->isMethod("post")){
            if($id=$request->input("id")){
                $data=DTSupplier::find($id);
                if(count($data->Form())==0){
                     $data->delete();
                }
               
                echo 'Destroy Success';exit;
            }
        }

    }
   
    public function export(Request $request){
          $name_excel="Danh sách nhà cung cấp: ". date("d-m-Y H:i:s");
          Excel::download(function() use ($request){
          //  $excel->sheet('Danh sách nhà cung cấp ', function($sheet) use ($request) {


                $name=$request->input("name","");
          


         
    

                  $TData= DTSupplier::where("name","LIKE","%{$name}%")->orderBy("id","DESC")
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
