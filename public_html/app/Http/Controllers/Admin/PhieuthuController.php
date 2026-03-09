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

use App\Model\Phieuthu as DTPhieuthu;


class PhieuthuController extends Controller
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
                  "price"=>"required",
                  "nguoinhantien"=>"required"
                

              ],[
                  "price.required"=>" Vui lòng nhập số tiền . " ,
                "nguoinhantien.required"=>" Vui lòng nhập người nhận tiền . " ,

                   
               
              ]);
              if($validator->fails()){
                  return redirect()->back()->withErrors($validator)->withInput();
              }else{
             

                  $TNew=new DTPhieuthu();
                  $TNew->cid_form=0;
              
                
                  $TNew->nguoinhantien=$request->input("nguoinhantien");
                  $TNew->cid_user=Auth::user()->id;

                  $TNew->price=$request->input("price");
                  $TNew->lydo=$request->input("lydo");

                  $TNew->ghichu=$request->input("ghichu");
             
                 $TNew->save();
                 

                $request->session()->flash("success"," Thêm mới PHIẾU THU thành công. ");
                return redirect()->back();
            }
        }


       $data=[];

        $this->View['data']=$data;
        return view("admin.phieuthu.add",$this->View);
    }
   
    public function lists(Request $request){
        $search=[];

        $this->View['options']=[''=>' Tất cả  ','1'=>"Danh sách từ Phiếu Dịch ", '2'=>"Danh sách tự tạo "];
      
           $search['name']=$name=$request->input("name","");
            $search['options']=$name=$request->input("options","");
            $search['customer']=$request->input("customer","");

           $sql=" id > 0 ";

           if(!empty($search['name'])){
              $sql = " nguoinhantien  LIKE  '%{$search['name']}%'";
           }
           if(!empty($search['options'])){
              if($search['options']=='1'){
                  $sql = $sql." AND cid_form != 0 ";
              }
              if($search['options']=='2'){
                  $sql = $sql." AND cid_form = 0 ";
              }
           }
           if(!empty($search['customer'])){
              $sql = $sql. " AND lydo LIKE '%{$search['customer']}%'";
           }
        
           $this->View['search']=$search;
    

         $TData= DTPhieuthu::whereRaw(DB::raw($sql))->orderBy("id","DESC")
              ->paginate(50);

         $this->View['data_list']=$TData;
                           
        return view("admin.phieuthu.lists",$this->View);
    }
    public function edit($id,Request $request){
        if($request->isMethod("post")){
              $validator=Validator::make($request->all(),[
                  "price"=>"required",
                  "nguoinhantien"=>"required"
                

              ],[
                  "price.required"=>" Vui lòng nhập số tiền . " ,
                "nguoinhantien.required"=>" Vui lòng nhập người nhận tiền . " ,

                   
               
              ]);
              if($validator->fails()){
                  return redirect()->back()->withErrors($validator)->withInput();
              }else{
             

                  $TUpdated=DTPhieuthu::find($id);
                  $TUpdated->cid_form=0;
              
                
                  $TUpdated->nguoinhantien=$request->input("nguoinhantien");
                  $TUpdated->cid_user=Auth::user()->id;

                  $TUpdated->price=$request->input("price");
                  $TUpdated->lydo=$request->input("lydo");

                  $TUpdated->ghichu=$request->input("ghichu");
             
                  $TUpdated->save();
                 

                $request->session()->flash("success"," Cập nhật PHIẾU THU thành công. ");
                return redirect()->back();
            }
        }


       $data=[];
       $data=DTPhieuthu::find($id)->toArray();

       if((int)$data['cid_form'] > 0){
            echo 'not access';
            exit;
       }
        $this->View['data']=$data;
        return view("admin.phieuthu.edit",$this->View);





    }
    public function remove(Request $request)
    {
        //
        if($request->isMethod("post")){
            if($id=$request->input("id")){
                $data=DTPhieuthu::find($id);
                if((int)$data['cid_form'] == 0){
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
          


         
    

                  $TData= DTPhieuthu::where("name","LIKE","%{$name}%")->orderBy("id","DESC")
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
