<?php

namespace App\Http\Controllers\Admin;

use App\TokenStore\TokenCache;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
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
                    $sql .= " AND (id = {$string_code} OR code LIKE '%{$string_code}%')";
                }
                $search['cid_id'] = $scan_code;
            }
        }


        //dd(DB::raw($sql));


        $this->View['search'] = $search;
        $tokenCache = new TokenCache();
        $this->View['access_token'] = $tokenCache->getAccessToken(Auth::user());
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

    public function lock(Request $request, $id)
    {

        $phieudichthuat = DTForms::find($id);

        if ((Auth::user()->roles !== '1')) {
            $request->session()->flash("warning", "Bạn không có quyền khóa phiếu! Chức năng chỉ dành cho admin");
            return redirect()->back();
        }

        if (!$phieudichthuat) {
            $request->session()->flash("warning", "Không tìm thấy Phiếu dịch thuật cần khóa");
            return redirect()->back();
        }

        //  return view("admin.pdf.mau",$data);
        if (Auth::user()->roles == '1') {
            //
            $phieudichthuat->locked = '1';
            $phieudichthuat->save();

            $this->mylog('Khóa Phiếu', $phieudichthuat->code, $phieudichthuat->id);

            $request->session()->flash("success", "Khóa PHIẾU DỊCH THUẬT Thành công!");
            return redirect()->back();
        }

        $request->session()->flash("warning", "Có lỗi xảy ra khi Khóa phiếu dịch thuật!");
        return redirect()->back();
    }

    public function unlock(Request $request, $id)
    {

        $phieudichthuat = DTForms::find($id);

        if ((Auth::user()->roles !== '1')) {
            $request->session()->flash("warning", "Bạn không có quyền mở khóa phiếu! Chức năng chỉ dành cho admin");
            return redirect()->back();
        }

        if (!$phieudichthuat) {
            $request->session()->flash("warning", "Không tìm thấy Phiếu dịch thuật cần mở khóa");
            return redirect()->back();
        }

        //  return view("admin.pdf.mau",$data);
        if (Auth::user()->roles == '1') {
            //
            $phieudichthuat->locked = '0';
            $phieudichthuat->save();

            $this->mylog('Mở Khóa Phiếu', $phieudichthuat->code, $phieudichthuat->id);

            $request->session()->flash("success", "Mở Khóa PHIẾU DỊCH THUẬT Thành công!");
            return redirect()->back();
        }

        $request->session()->flash("warning", "Có lỗi xảy ra khi mở Khóa phiếu dịch thuật!");
        return redirect()->back();
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

            $UP_Supplier = DTOrderSupplier::where("cid_form", $id)->first();
            if (!empty($UP_Supplier)) {
                $dt_OrderSupplier = DTOrderSupplier::where("cid_form", $id)->first();
                if ($dt_OrderSupplier) {
                    $this->mylog('Duyệt NCC . Đã chi đầy đủ  - ' . Auth::user()->name, $approvedsupplier->code, $approvedsupplier->id);
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

            $UP_Supplier = DTOrderSupplier::where("cid_form", $id)->first();
            if (!empty($UP_Supplier)) {

                DTOrderSupplier::where("cid_form", $id)->update(['approved_2' => '2']);
                $this->mylog('Duyệt NCC . Đã chi đầy đủ  - ' . Auth::user()->name, $approvedsupplier->code, $approvedsupplier->id);

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

                if ($TUpdated->locked) {
                    $request->session()->flash("warning", "Không thể sửa phiếu do đã bị KHÓA");
                    return redirect()->back();
                }

                $data = $request->only([
                    'name',
                    'name_number',
                    'name_docs',
                    'sobandich',
                    'ngaytrahoso',
                    'giotrahoso',
                    'path_work',

                    'cid_customer',
                    'cid_supplier',
                ]);
                $TUpdated->update($data);


                $orderCustomer = DTOrderCustomer::where('cid_form', $id)->first();

                $data_Customer = $request->only([
                    'cid_customer',
                    'phidichthuat',
                    'congchung',
                    'daucongty',
                    'saoy',
                    'ngoaivu',
                    'phivanchuyen',
                    'vat',
                    'tong',
                    'tamung',
                    'conglai',
                    'approved',
                ]);


                $data_Customer['tong'] = (int)$data_Customer["tong"];
                $data_Customer['tamung'] = (int)$data_Customer["tamung"];
                $data_Customer['conglai'] = (int)$data_Customer['tong'] - (int)$data_Customer['tamung'];
                $data_Customer['approved'] = (isset($request->approved)) ? $request->approved : 1;
                $Up_Customer = $orderCustomer->update($data_Customer);

                $changed = $orderCustomer->wasChanged(['approved']);
                if ($changed) {
                    if ($orderCustomer->approved == '2') {
                        $this->phieuthu($TUpdated->id, $orderCustomer->tong, ' Thu từ Khách hàng :' . $TUpdated->khachhang->name);
                    } else {
                        $removed = $orderCustomer->phieuthu()->delete();
                        if ($removed) {
                            $this->mylog('Xóa phiếu thu', $TUpdated->code, $TUpdated->id);
                        }
                    }
                }


                $orderSupplier = DTOrderSupplier::where("cid_form", $id)->first();
                $data_Supplier = [];
                $data_Supplier_admin = [];
                if (Auth::user()->roles == '1') {
                    //SUPPLIER
                    $data_Supplier_admin = [

                        'congchung' => $request->input("congchung_1"),
                        'daucongty' => $request->input("daucongty_1"),
                        'saoy' => $request->input("saoy_1"),
                        'ngoaivu' => $request->input("ngoaivu_1"),
                        'phivanchuyen' => $request->input("phivanchuyen_1"),
                        'vat' => $request->input("vat_1"),

                        'approved_cong_chung' => isset($request->approved_cong_chung) ? $request->approved_cong_chung : 1,
                        'approved_dau_cong_ty' => isset($request->approved_dau_cong_ty) ? $request->approved_dau_cong_ty : 1,
                        'approved_sao_y' => isset($request->approved_sao_y) ? $request->approved_sao_y : 1,
                        'approved_ngoai_vu' => isset($request->approved_ngoai_vu) ? $request->approved_ngoai_vu : 1,
                        'approved_phi_van_chuyen' => isset($request->approved_phi_van_chuyen) ? $request->approved_phi_van_chuyen : 1,
                        'approved_vat' => isset($request->approved_vat) ? $request->approved_vat : 1,
                    ];
                }
                $data_Supplier = array_merge($data_Supplier_admin, [
                    'cid_supplier' => $request->input("cid_supplier"),

                    'tong' => $request->input("tong_1"),
                    'nguoinhantien' => $request->input("nguoinhantien_1"),
                    'ghichu' => $request->input("ghichu"),

                    'phidichthuat' => $request->input("phidichthuat_1"),
                    'approved_2' => isset($request->approved_2) ? $request->approved_2 : 1,
                ]);


                $UP_Supplier = $orderSupplier->update($data_Supplier);

                $_phieuchi = DTPhieuchi::where("cid_form", $TUpdated->id);
//                $_phieuchi = $orderCustomer->phieuchi();

                if ($orderSupplier->wasChanged('approved_cong_chung')) {
                    if ($orderSupplier->approved_cong_chung == '2' && !empty($orderSupplier->congchung)) {
                        $this->phieuchi($orderSupplier->id, $orderSupplier->congchung, 'Phí Công Chứng (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->nhacungcap->name, $request->input("nguoinhantien_1", ""), '1', '2', 2);
                    } else {
                        $removed = $_phieuchi->where('flag', 2)->delete();
                        if ($removed) {
                            $this->mylog('Xóa phiếu chi Công chứng NCC do bỏ chọn', $TUpdated->code, $TUpdated->id);
                        }
                    }
                }

                if ($orderSupplier->wasChanged('approved_dau_cong_ty')) {
                    if ($orderSupplier->approved_dau_cong_ty == '2' && !empty($orderSupplier->daucongty)) {
                        $this->phieuchi($orderSupplier->id, $orderSupplier->daucongty, 'PHÍ Dấu công ty (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->nhacungcap->name, $request->input("nguoinhantien_1", ""), '1', '2', 3);
                    } else {
                        $removed = $_phieuchi->where('flag', 3)->delete();
                        if ($removed) {
                            $this->mylog('Xóa phiếu chi Dấu công ty NCC do bỏ chọn', $TUpdated->code, $TUpdated->id);
                        }
                    }
                }


                if ($orderSupplier->wasChanged('approved_sao_y')) {

                    if ($orderSupplier->approved_sao_y == '2' && !empty($orderSupplier->saoy)) {
                        $this->phieuchi($orderSupplier->id, $orderSupplier->saoy, 'PHÍ Dấu công ty (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->nhacungcap->name, $request->input("nguoinhantien_1", ""), '1', '2', 4);
                    } else {
                        $removed = $_phieuchi->where('flag', 4)->delete();
                        if ($removed) {
                            $this->mylog('Xóa phiếu chi Sao y NCC do bỏ chọn', $TUpdated->code, $TUpdated->id);
                        }
                    }
                }

                if ($orderSupplier->wasChanged('approved_ngoai_vu')) {
                    if ($orderSupplier->approved_ngoai_vu == '2' && !empty($orderSupplier->ngoaivu)) {
                        $this->phieuchi($orderSupplier->id, $orderSupplier->ngoaivu, 'PHÍ Ngoại vụ (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->nhacungcap->name, $request->input("nguoinhantien_1", ""), '1', '2', 5);
                    } else {
                        $removed = $_phieuchi->where('flag', 5)->delete();
                        if ($removed) {
                            $this->mylog('Xóa phiếu chi Ngoại vụ NCC do bỏ chọn', $TUpdated->code, $TUpdated->id);
                        }
                    }
                }
                if ($orderSupplier->wasChanged('approved_phi_van_chuyen')) {
                    if ($orderSupplier->approved_phi_van_chuyen == '2' && !empty($orderSupplier->phivanchuyen)) {
                        $this->phieuchi($orderSupplier->id, $orderSupplier->phivanchuyen, 'Phí vận chuyển (PDV): Chi cho nhà Cung Cấp : ' . $TUpdated->nhacungcap->name, $request->input("nguoinhantien_1", ""), '1', '2', 6);
                    } else {
                        $removed = $_phieuchi->where('flag', 6)->delete();
                        if ($removed) {
                            $this->mylog('Xóa phiếu chi Vận chuyển NCC do bỏ chọn', $TUpdated->code, $TUpdated->id);
                        }
                    }
                }

                if ($orderSupplier->wasChanged('approved_vat')) {
                    if ($orderSupplier->approved_vat == '2' && !empty($orderSupplier->vat)) {
                        $this->phieuchi($orderSupplier->id, $orderSupplier->vat, 'PHÍ VAT (PDV) : Chi cho nhà Cung Cấp : ' . $TUpdated->nhacungcap->name, $request->input("nguoinhantien_1", ""), '1', '2', 7);
                    } else {
                        $removed = $_phieuchi->where('flag', 7)->delete();
                        if ($removed) {
                            $this->mylog('Xóa phiếu chi Phí VAT do bỏ chọn', $TUpdated->code, $TUpdated->id);
                        }
                    }
                }


                if ($orderSupplier->wasChanged('approved_2')) {
                    if ($orderSupplier->approved_2 == '2' && !empty($orderSupplier->phidichthuat)) {
                        $this->phieuchi($orderSupplier->id, $orderSupplier->phidichthuat, 'PHÍ DỊCH THUẬT : Chi cho nhà Cung Cấp : ' . $TUpdated->nhacungcap->name, "", '2');
                    } else {
//                        $removed = $_phieuchi->where('is_type', 2)->delete();
//                        if ($removed) {
//                            $this->mylog('Xóa phiếu chi Phí Dịch thuật do bỏ chọn', $TUpdated->code, $TUpdated->id);
//                        }
                    }
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
        $data['locked'] = $dt_form->locked;

        $data['phidichthuat_1'] = $GET_Supplier->phidichthuat;
        $data['congchung_1'] = $GET_Supplier->congchung;
        $data['daucongty_1'] = $GET_Supplier->daucongty;
        $data['saoy_1'] = $GET_Supplier->saoy;
        $data['ngoaivu_1'] = $GET_Supplier->ngoaivu;
        $data['phivanchuyen_1'] = $GET_Supplier->phivanchuyen;
        $data['vat_1'] = $GET_Supplier->vat;
        $data['tong_1'] = $GET_Supplier->tong;
        $data['approved_1'] = $GET_Supplier->approved;
        $data['nguoinhantien_1'] = $GET_Supplier->nguoinhantien;
        $data['ghichu'] = $GET_Supplier->ghichu;

        $data['approved_cong_chung'] = $GET_Supplier->approved_cong_chung == '1' ? false :true;
        $data['approved_dau_cong_ty'] = $GET_Supplier->approved_dau_cong_ty == '1' ? false :true;
        $data['approved_sao_y'] = $GET_Supplier->approved_sao_y == '1' ? false :true;
        $data['approved_ngoai_vu'] = $GET_Supplier->approved_ngoai_vu == '1' ? false :true;
        $data['approved_phi_van_chuyen'] = $GET_Supplier->approved_phi_van_chuyen == '1' ? false :true;
        $data['approved_vat'] = $GET_Supplier->approved_vat == '1' ? false :true;
        $data['approved_2'] = $GET_Supplier->approved_2 == '1' ? false :true;
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
