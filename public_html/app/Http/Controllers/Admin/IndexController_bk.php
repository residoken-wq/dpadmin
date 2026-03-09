<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App;
use Image;
use Auth;
use PDF;
use DB;
use App\Model\Forms as DTForms;
use App\Model\Supplier as DTSupplier;
use App\Model\Customer as DTCustomer;
use App\Model\OrderCustomer as DTOrderCustomer;
use App\Model\OrderSupplier as DTOrderSupplier;
use App\Model\Log as DTLog;
use App\Model\Phieuchi as DTPhieuchi;
use App\Model\Phieuthu as DTPhieuthu;

use Session;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $View = [];

    public function barcode(Request $request)
    {
        $barcode = $request->input("barcode");
        $sql = "";
        $search = [];
        if (!empty($barcode)) {
            $array_sql = [];
            $array_barcode = explode(",", $barcode);

            foreach ($array_barcode as $br) {
                $x = substr($br, 0, strlen($br) - 1);
                if (is_numeric($x)) {
                    $array_sql[] = " id = " . $x;
                }

            }

            if (!empty($array_sql)) {
                $sql = implode(" OR ", $array_sql);
            }

            $search['barcode'] = $barcode;
        } else {
            $sql = " id=0 ";
        }
        $this->View['search'] = $search;

        if (empty($sql)) {
            $TData = DTForms::whereRaw(DB::raw("id=0"))->orderBy("id", "DESC")->get();
        } else {
            $TData = DTForms::whereRaw(DB::raw($sql))->orderBy("id", "DESC")->get();
        }


        $this->View['data_list'] = $TData;

        return view("admin.index.barcode", $this->View);
    }

    public function index(Request $request)
    {
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                "cid_supplier" => "required",
                "cid_customer" => "required",
                "name" => "required",
                "name_number" => "required",
                "path_work" => "required",
                "name_docs" => "required",
                "phone" => "required",
                "sobandich" => "required"

            ], [
                "cid_supplier.required" => "Vui lòng chọn NCC. ",
                "cid_customer.required" => "Vui lòng chọn khách hàng.   ",
                "name.required" => "Vui lòng nhập loại văn kiện.   ",
                "name_number.required" => "Vui lòng nhập số lượng loại văn kiện.  ",
                "path_work.required" => "Vui lòng nhập đường dẫn vật lý.   ",
                "name_docs.required" => "Vui lòng nhập tên trong hồ sơ.   ",
                "phone.required" => "Vui lòng nhập số điện thoại. ",
                "sobandich.required" => "Vui lòng nhập nhập số bản dịch.  ",

            ]);
            if ($validator->fails()) {


                return redirect()->back()->withErrors($validator)->withInput();

            } else {

                $check_code = DTForms::where("code", $request->input("code"))->first();
                if (!empty($check_code['id'])) {
                    $request->session()->flash("success", "Lỗi Thêm mới: Mã đơn hàng này đã tồn tại. Vui lòng kiểm tra dữ liệu. ");
                    return redirect()->back()->withErrors($validator)->withInput();
                }


                $TNew = new DTForms();
                $TNew->cid_customer = $request->input('cid_customer');
                $TNew->cid_supplier = $request->input('cid_supplier');
                $TNew->code = $request->input('code');
                $TNew->name = $request->input('name');
                $TNew->name_number = $request->input('name_number');
                $TNew->name_docs = $request->input('name_docs');
                $TNew->phone = $request->input('phone');

                $TNew->sobandich = $request->input('sobandich');
                $TNew->ngaytrahoso = $request->input('ngaytrahoso');
                $TNew->giotrahoso = $request->input('giotrahoso');
                $TNew->path_work = $request->input('path_work');
                $TNew->approved = '1';
                $TNew->cid_users = Auth::user()->id;


                $TNew->save();


                //FOR ORDER  SUPPLIER
                $TNewsOrder = new DTOrderSupplier();
                $TNewsOrder->cid_supplier = $request->input("cid_supplier");
                $TNewsOrder->cid_form = $TNew->id;
                $TNewsOrder->phidichthuat = 0;
                $TNewsOrder->congchung = 0;
                $TNewsOrder->daucongty = 0;
                $TNewsOrder->saoy = 0;
                $TNewsOrder->ngoaivu = 0;
                $TNewsOrder->phivanchuyen = 0;
                $TNewsOrder->vat = 0;
                $TNewsOrder->tong = 0;

                $TNewsOrder->tamung = 0;
                $TNewsOrder->conglai = 0;
                $TNewsOrder->approved = '1';
                $TNewsOrder->approved_2 = '1';
                $TNewsOrder->ghichu = $request->input("ghichu");
                $TNewsOrder->save();

                //FOR ORDER  CUSTOMER
                $TNewsOrderCustomer = new DTOrderCustomer();
                $TNewsOrderCustomer->cid_customer = $request->input("cid_customer");
                $TNewsOrderCustomer->cid_form = $TNew->id;
                $TNewsOrderCustomer->phidichthuat = (int)$request->input("phidichthuat");
                $TNewsOrderCustomer->congchung = (int)$request->input("congchung");
                $TNewsOrderCustomer->daucongty = (int)$request->input("daucongty");
                $TNewsOrderCustomer->saoy = (int)$request->input("saoy");
                $TNewsOrderCustomer->ngoaivu = (int)$request->input("ngoaivu");
                $TNewsOrderCustomer->phivanchuyen = (int)$request->input("phivanchuyen");
                $TNewsOrderCustomer->vat = (int)$request->input("vat");
                $TNewsOrderCustomer->tong = (int)$request->input("tong");

                $TNewsOrderCustomer->tamung = (int)$request->input("tamung");
                $TNewsOrderCustomer->conglai = (int)$request->input("conglai");

                if ($appro = $request->input("approved")) {
                    $TNewsOrderCustomer->approved = '2';
                } else {
                    $TNewsOrderCustomer->approved = '1';
                }
                if ($TNewsOrderCustomer->approved == '2') {

                    $this->phieuthu($TNew->id, $TNewsOrderCustomer->tong, ' Thu từ Khách hàng :' . $TNew->Customer()['name']);

                }

                $TNewsOrderCustomer->save();

                $this->mylog('Thêm Phiếu mới ', $TNew->code, $TNew->id);

                $request->session()->flash("success", "Thêm mới PHIẾU DỊCH THUẬT Thành công. ");
                return redirect()->back();
            }
        }
        $data = [];
        $data['code'] = date("Ymd-His");

        $this->View['cid_supplier'] = DTSupplier::orderBy("name", "DESC")->get()->pluck("name", "id");

        $this->View['cid_customer'] = DTCustomer::select(DB::raw("id,IF(phone, CONCAT(name,' - ',phone ), name ) as mypluck "))->orderBy("name", "DESC")->get()->pluck("mypluck", "id");

//         dd( $this->View['cid_customer']);

        $this->View['cid_supplier'][''] = " -- Chọn Nhà Cung Cấp -- ";
        $this->View['cid_customer'][''] = " -- Chọn Khách Hàng -- ";
        $data['cid_supplier'] = $data['cid_customer'] = '';
        $this->View['data'] = $data;


        return view("admin.index.index", $this->View);
    }

    public function phieuthu($cid_form, $price, $lydo = '')
    {
        $check = DTPhieuthu::where("cid_form", $cid_form)->first();

        if (empty($check['id'])) {
            $TNew_PT = new DTPhieuthu();

            $TNew_PT->cid_form = $cid_form;
            $TNew_PT->nguoinhantien = Auth::user()->name;
            $TNew_PT->cid_user = Auth::user()->id;
            $TNew_PT->price = $price;
            $TNew_PT->lydo = "$lydo";
            $TNew_PT->ghichu = " ";
            $TNew_PT->save();
        } else {
            $check->cid_user = Auth::user()->id;
            $check->price = $price;
            $check->lydo = "$lydo";

            $check->save();
        }
        return true;

    }

    public function mylog($name, $action, $cid_form)
    {
        $TNew_LOG = new DTLog();
        $TNew_LOG->name = $name;
        $TNew_LOG->actions = $action;
        $TNew_LOG->cid_form = $cid_form;
        $TNew_LOG->cid_user = Auth::user()->id;
        $TNew_LOG->save();
        return true;
    }

    public function lists(Request $request)
    {
        // dd(Session::get("onedrivec"));
        $search = [];

        $this->View['approved'] = ['' => " Tất cả ", '1' => " Pending ", '2' => ' Doing ', '3' => ' Done '];

        $this->View['cid_supplier'] = DTSupplier::orderBy("name", "DESC")->get()->pluck("name", "id");
        $this->View['cid_customer'] = DTCustomer::orderBy("name", "DESC")->get()->pluck("name", "id");
        // $this->View['cid_id']=DTForms::orderBy("name","DESC")->get()->pluck("name","id");

        $this->View['cid_supplier'][''] = " -- Tìm theo Nhà Cung Cấp -- ";
        $this->View['cid_customer'][''] = " -- Tìm theo Khách Hàng -- ";
        // $this->View['cid_id']['']="";

        $sql = " id > 0 ";
        $search['cid_supplier'] = $search['cid_customer'] = $search['approved'] = '';

        if (isset($_GET['approved'])) {
            if ($cid_supplier = $request->input("cid_supplier")) {
                $sql .= " AND cid_supplier = {$cid_supplier} ";
                $search['cid_supplier'] = $cid_supplier;
            }
            if ($cid_customer = $request->input("cid_customer")) {
                $sql .= " AND cid_customer = {$cid_customer} ";
                $search['cid_customer'] = $cid_customer;
            }
            if ($approved = $request->input("approved")) {
                $sql .= " AND approved='{$approved}' ";
                $search['approved'] = $approved;
            }
            if ($name_docs = $request->input("name_docs")) {

                $sql .= " AND name_docs LIKE \"%{$name_docs}%\" ";
                $search['name_docs'] = $name_docs;
            }
            if ($scan_code = $request->input("cid_id")) {
                $string_code = str_replace("G", "", $scan_code);
                if (strlen($scan_code) > 0) {
                    $string_code = substr($scan_code, 0, strlen($scan_code) - 1);
                    $sql .= " AND id = {$string_code} ";
                }
                $search['cid_id'] = $scan_code;
            }
        }


        //dd(DB::raw($sql));


        $this->View['search'] = $search;


        $TData = DTForms::whereRaw(DB::raw($sql))->orderBy("id", "DESC")
            ->paginate(15);

        $this->View['data_list'] = $TData;

        return view("admin.index.lists", $this->View);
    }

    public function pdf($id)
    {

        $data = ['data' => DTForms::find($id)];

        //  return view("admin.pdf.mau",$data);
        if (Auth::user()->roles == '1') {
            //
            $pdf = PDF::loadView('admin.pdf.supplier', $data, [], [
                'format' => 'A5-L',
                'author' => Auth::user()->name,
                'subject' => $data['data']['name'],
            ]);
        } else {
            $pdf = PDF::loadView('admin.pdf.supplier', $data, [], [
                'format' => 'A5-L',
                'author' => Auth::user()->name,
                'subject' => $data['data']['name'],
            ]);
        }

        return $pdf->stream('admin.document.pdf');
    }

    public function removed($id, Request $request)
    {

        $removed = DTForms::find($id);
        if (!empty($removed)) {
            $this->mylog('Xoá Phiếu mới - ' . Auth::user()->name, $removed->code, $removed->id);
            DTOrderCustomer::where("cid_form", $id)->delete();
            DTOrderSupplier::where("cid_form", $id)->delete();
            DTPhieuchi::where("cid_form", $id)->delete();
            $removed->delete();
        }
        return 'success';


    }

    public function approvedcustomer($id, Request $request)
    {

        $approvedcustomer = DTForms::find($id);
        if (!empty($approvedcustomer)) {
            $this->mylog('Duyệt KH . Đã nhận đầy đủ  - ' . Auth::user()->name, $approvedcustomer->code, $approvedcustomer->id);
            DTOrderCustomer::where("cid_form", $id)->update(["approved" => '2']);
            $Up_Customer = DTOrderCustomer::where("cid_form", $id)->first();
            $this->phieuthu($id, $Up_Customer->tong, ' Thu từ Khách hàng :' . $approvedcustomer->Customer()['name']);

        }
        return 'success';


    }

    public function approvedsupplier($id, Request $request)
    {


        $approvedsupplier = DTForms::find($id);
        if (!empty($approvedsupplier)) {
            $this->mylog('Duyệt NCC . Đã nhận đầy đủ  - ' . Auth::user()->name, $approvedsupplier->code, $approvedsupplier->id);

            $UP_Supplier = DTOrderSupplier::where("cid_form", $id)->first();
            if (!empty($UP_Supplier)) {
                $dt_OrderSupplier = DTOrderSupplier::where("cid_form", $id)->first();
                if ($dt_OrderSupplier) {
                    if (!empty($dt_OrderSupplier->congchung)) {
                        $dt_OrderSupplier->approved_cong_chung = 2;
                        $this->phieuchi($id, $dt_OrderSupplier->congchung, 'Phí Công Chứng (PDV): Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '1', '2', 2);
                    }
                    if (!empty($dt_OrderSupplier->daucongty)) {
                        $dt_OrderSupplier->approved_dau_cong_ty = 2;
                        $this->phieuchi($UP_Supplier->id, $UP_Supplier->daucongty, 'PHÍ Dấu công ty (PDV): Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '1', '2', 3);
                    }
                    if (!empty($dt_OrderSupplier->saoy)) {
                        $dt_OrderSupplier->approved_sao_y = 2;
                        $this->phieuchi($UP_Supplier->id, $UP_Supplier->saoy, 'PHÍ Sao y (PDV) : Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '1', '2', 4);
                    }
                    if (!empty($dt_OrderSupplier->ngoaivu)) {
                        $dt_OrderSupplier->approved_ngoai_vu = 2;
                        $this->phieuchi($UP_Supplier->id, $UP_Supplier->ngoaivu, 'PHÍ Ngoại vụ (PDV): Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '1', '2', 5);
                    }
                    if (!empty($dt_OrderSupplier->phivanchuyen)) {
                        $dt_OrderSupplier->approved_phi_van_chuyen = 2;
                        $this->phieuchi($UP_Supplier->id, $UP_Supplier->phivanchuyen, 'Phí Công Chứng (PDV): Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '1', '2', 6);
                    }
                    if (!empty($dt_OrderSupplier->vat)) {
                        $dt_OrderSupplier->approved_vat = 2;
                        $this->phieuchi($UP_Supplier->id, $UP_Supplier->vat, 'Phí Công Chứng (PDV): Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '1', '2', 7);
                    }
                    $dt_OrderSupplier->save();

//                    DTOrderSupplier::where("cid_form", $id)->update([
//                        "approved_cong_chung" => '2',
//                        "approved_dau_cong_ty" => '2',
//                        "approved_sao_y" => '2',
//                        "approved_ngoai_vu" => '2',
//                        "approved_phi_van_chuyen" => '2',
//                        "approved_vat" => '2',
//                    ]);

                    //   $this->phieuchi($UP_Supplier->id,$UP_Supplier->phidichthuat,' PHIEU DICH THUAT :  Chi cho nhà Cung Cấp: '.$approvedsupplier->Supplier()['name'],"",'2');

                }
//                $this->phieuchi($UP_Supplier->id, $UP_Supplier->tong, ' PHIEU DICH VU:  Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '1');
            }


        }
        return 'success';


    }

    public function phieuchi($cid_form, $price, $lydo = '', $nguoinhantien = "", $is_type = '1', $is_new = '1', $flag = 0)
    {

        if ((int)$price == 0) {
            return 0;
        }

        if ($is_new == '1') {
            //Xoá toàn bộ phiếu chi của nhà CC type=1
            if ($is_type == '1') {
                //REMOVE ALL PHIEU CHI
                // $remove_phieuchi=DTPhieuchi::where("is_type","1")->where("cid_form",$cid_form)->get();
                // foreach($remove_phieuchi as $r_p){
                //      if(!empty($r_p['id'])){
                //             $r_p->delete();
                //         }

                // }

            }


            $check = DTPhieuchi::where('flag', $flag)->where("is_type", $is_type)->where("cid_form", $cid_form)->first();

            if (empty($check['id'])) {

                $TNew_PC = new DTPhieuchi();

                $TNew_PC->cid_form = $cid_form;
                $TNew_PC->nguoichi = Auth::user()->name;
                $TNew_PC->nguoinhantien = $nguoinhantien; //nguoi ben NCC nhan tien .
                $TNew_PC->cid_user = Auth::user()->id;
                $TNew_PC->price = $price;
                $TNew_PC->lydo = "$lydo";
                $TNew_PC->ghichu = " ";
                $TNew_PC->is_type = $is_type;
                $TNew_PC->flag = $flag;
                $TNew_PC->save();
            } else {


                $check->nguoinhantien = $nguoinhantien; //nguoi ben NCC nhan tien .
                $check->cid_user = Auth::user()->id;
                $check->price = $price;
                $check->lydo = "$lydo";
                $check->is_type = $is_type;
                $check->save();
            }
        } else {

            $check = DTPhieuchi::where('flag', $flag)->where("cid_form", $cid_form)->first();
            if (empty($check['id'])) {
                $TNew_PC = new DTPhieuchi();

                $TNew_PC->cid_form = $cid_form;
                $TNew_PC->nguoichi = Auth::user()->name;
                $TNew_PC->nguoinhantien = $nguoinhantien; //nguoi ben NCC nhan tien .
                $TNew_PC->cid_user = Auth::user()->id;
                $TNew_PC->price = $price;
                $TNew_PC->lydo = "$lydo";
                $TNew_PC->ghichu = " ";
                $TNew_PC->is_type = $is_type;
                $TNew_PC->flag = $flag;
                $TNew_PC->save();
            } else {

                $check->nguoinhantien = $nguoinhantien; //nguoi ben NCC nhan tien .
                $check->cid_user = Auth::user()->id;
                $check->price = $price;
                $check->lydo = "$lydo";
                $check->is_type = $is_type;
                $check->save();
            }


        }


        return true;

    }

    public function approvedsupplierextension($id, Request $request)
    {


        $approvedsupplier = DTForms::find($id);
        if (!empty($approvedsupplier)) {
            $this->mylog('Duyệt NCC . Đã nhận đầy đủ  - ' . Auth::user()->name, $approvedsupplier->code, $approvedsupplier->id);

            $UP_Supplier = DTOrderSupplier::where("cid_form", $id)->first();
            if (!empty($UP_Supplier)) {

                DTOrderSupplier::where("cid_form", $id)->update(['approved_2' => '2']);

                //$this->phieuchi($UP_Supplier->id,$UP_Supplier->tong,' PHIEU DICH VU:  Chi cho nhà Cung Cấp: '.$approvedsupplier->Supplier()['name'],"",'1');

                $this->phieuchi($UP_Supplier->id, $UP_Supplier->phidichthuat, ' PHIEU DICH THUAT :  Chi cho nhà Cung Cấp: ' . $approvedsupplier->Supplier()['name'], "", '2');

            }


        }
        return 'success';


    }

    public function edit($id, Request $request)
    {
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [

                "name" => "required",
                "name_number" => "required",
                "path_work" => "required",
                "name_docs" => "required",

                "sobandich" => "required",
                "cid_customer" => "required",
                "cid_supplier" => "required"
            ], [

                "name.required" => "Vui lòng nhập loại văn kiện.   ",
                "name_number.required" => "Vui lòng nhập số lượng loại văn kiện.   ",
                "path_work.required" => "Vui lòng nhập đường dẫn vật lý.   ",
                "name_docs.required" => "Vui lòng nhập tên trong hồ sơ.   ",

                "sobandich.required" => "Vui lòng nhập nhập số bản dịch.  ",

            ]);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();

            } else {


                $TUpdated = DTForms::find($id);
                $TUpdated->name = $request->input('name');
                $TUpdated->name_number = $request->input('name_number');
                $TUpdated->name_docs = $request->input('name_docs');

                $TUpdated->sobandich = $request->input('sobandich');
                $TUpdated->ngaytrahoso = $request->input('ngaytrahoso');
                $TUpdated->giotrahoso = $request->input('giotrahoso');
                $TUpdated->path_work = $request->input('path_work');

                /*if($created_at=$request->input("created_at")){
                    if($created_at != $TUpdated->created_at){

                        $TUpdated->created_at=date("Y-m-d H:i:s",strtotime($created_at));
                    }else{

                    }

                }*/
                $TUpdated->cid_customer = $request->input('cid_customer');
                $TUpdated->cid_supplier = $request->input('cid_supplier');

                $TUpdated->save();

                //CUSTOMER
                $Up_Customer = DTOrderCustomer::where("cid_form", $id)->first();

                $Up_Customer->cid_customer = $request->input("cid_customer");
                $Up_Customer->phidichthuat = $request->input("phidichthuat");
                $Up_Customer->congchung = $request->input("congchung");
                $Up_Customer->daucongty = $request->input("daucongty");
                $Up_Customer->saoy = $request->input("saoy");
                $Up_Customer->ngoaivu = $request->input("ngoaivu");
                $Up_Customer->phivanchuyen = $request->input("phivanchuyen");
                $Up_Customer->vat = $request->input("vat");
                $Up_Customer->tong = (int)$request->input("tong");

                $Up_Customer->tamung = (int)$request->input("tamung");
                $Up_Customer->conglai = (int)$Up_Customer->tong - (int)$Up_Customer->tamung;
                if ($request->input("approved") == '1') {
                    $Up_Customer->approved = '2';
                } else {
                    $Up_Customer->approved = '1';
                }

                $Up_Customer->save();


                if ($Up_Customer->approved == '2') {

                    $this->phieuthu($TUpdated->id, $Up_Customer->tong, ' Thu từ Khách hàng :' . $TUpdated->Customer()['name']);
                } else {
                    $remove_phieuthu = DTPhieuthu::where("cid_form", $Up_Customer->id)->first();
                    if (!empty($remove_phieuthu)) {
                        $remove_phieuthu->delete();
                    }
                }

                $UP_Supplier = DTOrderSupplier::where("cid_form", $id)->first();
                if (Auth::user()->roles == '1') {
                    //SUPPLIER

                    $UP_Supplier->phidichthuat = $request->input("phidichthuat_1");
                    $UP_Supplier->congchung = $request->input("congchung_1");
                    $UP_Supplier->daucongty = $request->input("daucongty_1");
                    $UP_Supplier->saoy = $request->input("saoy_1");
                    $UP_Supplier->ngoaivu = $request->input("ngoaivu_1");
                    $UP_Supplier->phivanchuyen = $request->input("phivanchuyen_1");
                    $UP_Supplier->vat = $request->input("vat_1");

                }
                $UP_Supplier->cid_supplier = $request->input("cid_supplier");

                $UP_Supplier->tong = $request->input("tong_1");
                $UP_Supplier->nguoinhantien = $request->input("nguoinhantien_1");
                $UP_Supplier->ghichu = $request->input("ghichu");


//                if ($app = $request->input("approved_1")) {
//                    $UP_Supplier->approved = '2';
//                } else {
//                    $UP_Supplier->approved = '1';
//                }

                if ('2' == $request->input("approved_2")) {
                    $UP_Supplier->approved_2 = '2';
                } else {
                    $UP_Supplier->approved_2 = '1';
                }

                $UP_Supplier->approved_cong_chung = $request->input("approved_cong_chung", '1');
                $UP_Supplier->approved_dau_cong_ty = $request->input("approved_dau_cong_ty", '1');
                $UP_Supplier->approved_sao_y = $request->input("approved_sao_y", '1');
                $UP_Supplier->approved_ngoai_vu = $request->input("approved_ngoai_vu", '1');
                $UP_Supplier->approved_phi_van_chuyen = $request->input("approved_phi_van_chuyen", '1');
                $UP_Supplier->approved_vat = $request->input("approved_vat", '1');
//                $UP_Supplier->approved_phidichthuat_1 = $request->input("approved_phidichthuat_1", '1');

                $UP_Supplier->save();


                // $remove_phieuchi=DTPhieuchi::where("is_type","1")->where("cid_form",$UP_Supplier->id)->get();
                // foreach($remove_phieuchi as $r_p){
                //      if(!empty($r_p['id'])){
                //             $r_p->delete();

                //         }

                // }
                $is_flag = true;
//                if ($UP_Supplier->approved == '2' && !empty($UP_Supplier->tong)) {
//                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->tong, 'PHÍ DỊCH VỤ: Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], $request->input("nguoinhantien_1"), '2');
//                } else {
//                    DTPhieuchi::where('flag', 0)->where("cid_form", $TUpdated->id)->delete();
//                }
//                DTPhieuchi::where('flag', 0)->where("cid_form", $TUpdated->id)->delete();

                if ($UP_Supplier->approved_cong_chung == '2' && !empty($UP_Supplier->congchung)) {

                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->congchung, 'Phí Công Chứng (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], $request->input("nguoinhantien_1", ""), '1', '2', 2);

                } else {
                    DTPhieuchi::where('flag', 2)->where("cid_form", $TUpdated->id)->delete();
                }


                if ($UP_Supplier->approved_dau_cong_ty == '2' && !empty($UP_Supplier->daucongty)) {
                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->daucongty, 'PHÍ Dấu công ty (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], $request->input("nguoinhantien_1", ""), '1', '2', 3);
                } else {
                    DTPhieuchi::where('flag', 3)->where("cid_form", $TUpdated->id)->delete();
                }
                if ($UP_Supplier->approved_sao_y == '2' && !empty($UP_Supplier->saoy)) {
                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->saoy, 'PHÍ Sao y (PDV) : Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], $request->input("nguoinhantien_1", ""), '1', '2', 4);
                } else {
                    DTPhieuchi::where('flag', 4)->where("cid_form", $TUpdated->id)->delete();
                }
                if ($UP_Supplier->approved_ngoai_vu == '2' && !empty($UP_Supplier->ngoaivu)) {
                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->ngoaivu, 'PHÍ Ngoại vụ (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], $request->input("nguoinhantien_1", ""), '1', '2', 5);
                } else {
                    DTPhieuchi::where('flag', 5)->where("cid_form", $TUpdated->id)->delete();
                }
                if ($UP_Supplier->approved_phi_van_chuyen == '2' && !empty($UP_Supplier->phivanchuyen)) {
                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->phivanchuyen, 'Phí vận chuyển (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], $request->input("nguoinhantien_1", ""), '1', '2', 6);
                } else {
                    DTPhieuchi::where('flag', 6)->where("cid_form", $TUpdated->id)->delete();
                }
                if ($UP_Supplier->approved_vat == '2' && !empty($UP_Supplier->vat)) {
                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->vat, 'PHÍ VAT (PDV) : Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], $request->input("nguoinhantien_1", ""), '1', '2', 7);
                } else {
                    DTPhieuchi::where('flag', 7)->where("cid_form", $TUpdated->id)->delete();
                }


                if ($UP_Supplier->approved_2 == '2') {
                    $this->phieuchi($UP_Supplier->id, $UP_Supplier->phidichthuat, 'PHÍ DỊCH THUẬT : Chi cho nhà Cung Cấp : ' . $TUpdated->Supplier()['name'], "", '2');
                } else {
//                    $remove_phieuchi = DTPhieuchi::where("is_type", "2")->where("cid_form", $UP_Supplier->id)->first();
//                    if (!empty($remove_phieuchi['id'])) {
//                        $remove_phieuchi->delete();
//                    }
                }

                $this->mylog('Sửa Phiếu', $TUpdated->code, $TUpdated->id);

                $request->session()->flash("success", "Cập nhật PHIẾU DỊCH THUẬT Thành công. ");
                return redirect()->back();
            }
        }
        $data = [];


        $dt_form = DTForms::find($id);

        if (!$dt_form) {
            abort(404, 'không tìm thấy phiếu');
        }
        $this->View['cid_supplier'] = DTSupplier::orderBy("name", "DESC")->get()->pluck("name", "id");
        //    $this->View['cid_customer']=DTCustomer::orderBy("name","DESC")->get()->pluck("name","id");

        $this->View['cid_customer'] = DTCustomer::select(DB::raw("id,IF(phone, CONCAT(name,' - ',phone ), name ) as mypluck "))->orderBy("name", "DESC")->get()->pluck("mypluck", "id");

        $this->View['cid_supplier'][''] = " -- Chọn Nhà Cung Cấp -- ";
        $this->View['cid_customer'][''] = " -- Chọn Khách Hàng -- ";
        $data['cid_supplier'] = $data['cid_customer'] = '';

        $data = array_merge($dt_form->toArray(), DTOrderCustomer::where("cid_form", $id)->first()->toArray());
        //if(Auth::user()->roles=='1'){
        $GET_Supplier = DTOrderSupplier::where("cid_form", $id)->first();
        $data['phidichthuat_1'] = $GET_Supplier->phidichthuat;
        $data['congchung_1'] = $GET_Supplier->congchung;
        $data['daucongty_1'] = $GET_Supplier->daucongty;
        $data['saoy_1'] = $GET_Supplier->saoy;
        $data['ngoaivu_1'] = $GET_Supplier->ngoaivu;
        $data['phivanchuyen_1'] = $GET_Supplier->phivanchuyen;
        $data['vat_1'] = $GET_Supplier->vat;
        $data['tong_1'] = $GET_Supplier->tong;
        $data['approved_1'] = $GET_Supplier->approved;
        $data['approved_2'] = $GET_Supplier->approved_2;
        $data['nguoinhantien_1'] = $GET_Supplier->nguoinhantien;
        $data['ghichu'] = $GET_Supplier->ghichu;

        $data['approved_cong_chung'] = $GET_Supplier->approved_cong_chung == '1' ? false : true;
        $data['approved_dau_cong_ty'] = $GET_Supplier->approved_dau_cong_ty == '1' ? false : true;
        $data['approved_sao_y'] = $GET_Supplier->approved_sao_y == '1' ? false : true;
        $data['approved_ngoai_vu'] = $GET_Supplier->approved_ngoai_vu == '1' ? false : true;
        $data['approved_phi_van_chuyen'] = $GET_Supplier->approved_phi_van_chuyen == '1' ? false : true;
        $data['approved_vat'] = $GET_Supplier->approved_vat == '1' ? false : true;
        $data['approved_2'] = $GET_Supplier->approved_2 == '1' ? false : true;
//        $data['approved_phidichthuat_1'] = $GET_Supplier->approved_phidichthuat_1 == '1' ? false : true;

        //  }

        $this->View['data'] = $data;
        $this->View['maindata'] = DTForms::find($id);


        return view("admin.index.edit", $this->View);
    }

    public function getsupplier($id)
    {

        $data = DTSupplier::find($id)->toArray();
        echo json_encode($data);
    }

    public function getcustomer($id)
    {
        $data = DTCustomer::find($id)->toArray();
        echo json_encode($data);
    }

}
