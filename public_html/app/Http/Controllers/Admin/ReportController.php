<?php

namespace App\Http\Controllers\Admin;

use App\TokenStore\TokenCache;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App;
use DB;
use Excel;
use PDF;
use Illuminate\Support\Facades\Log;

//use Carbon\Carbon;
use App\Model\Forms as DTForms;


use App\Model\Phieuthu as DTPhieuthu;
use App\Model\Phieuchi as DTPhieuchi;
use App\Model\Report as DTReport;

use App\Model\OrderCustomer as DTOrderCustomer;
use App\Model\Supplier as DTSupplier;
use App\Model\Customer as DTCustomer;

use App\Model\OrderSupplier as DTOrderSupplier;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $View = [];

    protected $mytong = "(
      IF(approved_cong_chung='2', 0, IFNULL(congchung,0)) +
      IF(approved_dau_cong_ty='2', 0, IFNULL(daucongty,0)) +
      IF(approved_sao_y='2', 0, IFNULL(saoy ,0)) +
      IF(approved_ngoai_vu='2', 0, IFNULL(ngoaivu,0)) +
      IF(approved_phi_van_chuyen='2', 0, IFNULL(phivanchuyen,0)) +
      IF(approved_vat='2', 0, IFNULL(vat,0))
    )";

    protected $cid_listbuoi = [
        [
            'id' => 4,
            'name' => '-Cả ngày-',
            'order' => 1,
            'value' => 'DAY',
            'time' => "00:00:00",
            'time_start' => "00:00:00",
            'time_end' => "24:00:00",
            'filter_default' => true,
        ], [
            'id' => 1,
            'name' => 'Sáng',
            'order' => 1,
            'value' => 'SANG',
            'time' => "00:00:00",
            'time_start' => "00:00:00",
            'time_end' => "11:59:59",
            'filter_default' => true,
        ], [
            'id' => 2,
            'name' => 'Chiều',
            'order' => 2,
            'value' => 'CHIEU',
            'time' => "12:00:00",
            'time_start' => "12:00:00",
            'time_end' => "17:59:59",
            'filter_default' => true,
        ], [
            'id' => 3,
            'name' => 'Tối',
            'order' => 3,
            'value' => 'TOI',
            'time' => "18:00:00",
            'time_start' => "18:00:00",
            'time_end' => "24:00:00",
            'filter_default' => false,
        ],
    ];

    protected $cid_sort = [
        '0' => " -- Sắp xếp theo công nợ --",
        '1' => "Nhiều nhất",
        '2' => "Ít nhất"
    ];

    public function supplier(Request $request)
    {

        DTOrderSupplier::whereRaw("tamung IS NULL AND approved='1'")->update(['tamung' => 0]);
        DTOrderSupplier::whereRaw("tong IS NULL AND approved='1'")->update(['tong' => 0]);
        $search = $request->input();
        $filtered_buoi = false;
        if ($cid_buoi = $request->input("cid_buoi")) {
            $filtered_buoi = collect($this->cid_listbuoi)->where('id', $cid_buoi)->first();
            $search['cid_buoi'] = $cid_buoi;
        }
//        $search = [];
//        $search['cid_supplier'] = '';

        // dd($sql);

        $this->View['cid_sort'] = $this->cid_sort;
        $this->View['cid_listbuoi'] = collect($this->cid_listbuoi)->pluck("name", "id");
        $search['cid_sort'] = '0';

        $sort = ['id', 'DESC'];
        $cid_sort = $request->input("cid_sort");
        if ($cid_sort) {
            if ($cid_sort == '1') {
                $sort = ['total', 'DESC'];
            }
            if ($cid_sort == '2') {
                $sort = ['total', 'ASC'];
            }
            $search['cid_sort'] = $cid_sort;

        }

        $dataset = DTOrderSupplier::select("*", DB::raw(" sum({$this->mytong}-IFNULL(tamung,0)) as total, count(cid_supplier) as cnt"))
            ->whereNotIn('approved', ['2', 2])
            ->where(function ($query) use ($request, $filtered_buoi) {
                if ($cid = $request->input("cid_supplier")) {
                    $query->where('cid_supplier', $cid);
                }
                if ($date_from = $request->input("date_from")) {
                    $query->whereDate('created_at', '>=', \Carbon\Carbon::createFromFormat('m/d/Y', $date_from)->startOfDay());
                }
                if ($date_to = $request->input("date_to")) {
                    $query->whereDate('created_at', '<=', \Carbon\Carbon::createFromFormat('m/d/Y', $date_to)->endOfDay());
                }
                if ($ngaytrahoso = $request->input("ngaytrahoso")) {
                    $giotrahoso_from = '00:00:00';
                    $giotrahoso_to = '24:00:00';
                    if ($filtered_buoi) {
                        $giotrahoso_from = $filtered_buoi['time_start'];
                        $giotrahoso_to = $filtered_buoi['time_end'];
                    }

                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $query->where('giotrahoso', '>=', $giotrahoso_from);
                    $query->where('giotrahoso', '<=', $giotrahoso_to);
                }
            })
//            ->whereRaw(DB::raw($sql))
            ->groupBy("cid_supplier")->orderBy($sort[0], $sort[1]);

//        $sql = $dataset->toSql();
//        $bindings = $dataset->getBindings();
//        dd($sql, $bindings);
        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportCongNoNCC($dataset->get()), 'Công Nợ NCC PHÍ DỊCH VỤ ' . date("m-d-Y") . '.xlsx');
            }
        }


//        $this->View['tongso'] = DTOrderSupplier::whereRaw(DB::raw(" approved = '1' "))->get()->sum('tongcongno');
//        $this->View['data_list'] = DTSupplier::congno()->whereHas('hoadon', function ($query) use ($request) {
//            if ($request->input("cid_supplier")) {
//                $query->where('cid_supplier', $request->input("cid_supplier"));
//            }
//            if ($request->input("date_from")) {
//                $query->where('created_at', '>=', date("Y-m-d H:i:s", strtotime($request->input("date_from"))));
//            }
//            if ($request->input("date_to")) {
//                $query->where('created_at', '<=', date("Y-m-d 23:00:00", strtotime($request->input("date_to"))));
//            }
//        })->groupBy('id')->paginate(20);
//        $this->View['data_list'] = DTOrderSupplier::whereRaw(DB::raw($sql))->orderBy($sort[0], $sort[1])->paginate(20);
//        dd(DTOrderSupplier::select("*", DB::raw(" sum({$this->mytong}-tamung) as total"))->whereRaw(DB::raw($sql))->groupBy("cid_supplier")->orderBy($sort[0], $sort[1])->toSql());
//        dd(DTOrderSupplier::select("*", DB::raw(" sum({$this->mytong}-IFNULL(tamung,0)) as total"))->whereRaw(DB::raw($sql))->whereRaw(DB::raw(" sum({$this->mytong}-IFNULL(tamung,0)) >0"))->groupBy("cid_supplier")->orderBy($sort[0], $sort[1])->toSql());
        $this->View['tongso'] = $dataset->pluck('total')->sum();
        $this->View['data_list'] = $dataset->paginate(20);


        $this->View['cid_supplier'] = DTSupplier::orderBy("name", "DESC")->get()->pluck("name", "id");


        $this->View['cid_supplier'][''] = " -- Chọn NCC -- ";

        $this->View['search'] = $search;


        return view("admin.report.supplier", $this->View);
    }

    public function supplierlist($id, Request $request)
    {
        $filtered_buoi = false;
        if ($cid_buoi = $request->input("cid_buoi")) {
            $filtered_buoi = collect($this->cid_listbuoi)->where('id', $cid_buoi)->first();
            $search['cid_buoi'] = $cid_buoi;
        }
        $nhacungcap = DTSupplier::findOrFail($id);
        $this->View['supplier'] = $nhacungcap;
        $phieudich = DTForms::where('cid_supplier', $id)
            ->whereHas('OrderSuppliers', function ($query) {
                $query->where('approved', 1);
            })
            ->where(function ($query) use ($request, $filtered_buoi) {
                if ($date_from = $request->input("date_from")) {
                    $query->whereDate('created_at', '>=', Carbon::createFromFormat('m/d/Y', $date_from)->startOfDay());
                }

                if ($date_to = $request->input("date_to")) {
                    $query->whereDate('created_at', '<=', Carbon::createFromFormat('m/d/Y', $date_to)->endOfDay());
                }

                if ($ngaytrahoso = $request->input("ngaytrahoso")) {
//                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $giotrahoso_from = '00:00:00';
                    $giotrahoso_to = '24:00:00';
                    if ($filtered_buoi) {
                        $giotrahoso_from = $filtered_buoi['time_start'];
                        $giotrahoso_to = $filtered_buoi['time_end'];
                    }

                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $query->where('giotrahoso', '>=', $giotrahoso_from);
                    $query->where('giotrahoso', '<=', $giotrahoso_to);
                }
            })->orderBy("id", "DESC");

        $sql = " id IN (SELECT cid_form FROM DT_Order_Supplier WHERE approved='1')";

//        $search = [];
        $search = $request->input();
//        if ($date_from = $request->input("date_from")) {
//            $search['date_from'] = $date_from;
//
////            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
//        }
//
//        if ($date_to = $request->input("date_to")) {
//            $search['date_to'] = $date_to;
////            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
//        }
//
//        if ($ngaytrahoso = $request->input("ngaytrahoso")) {
//            $search['ngaytrahoso'] = $ngaytrahoso;
//        }
        //dd($sql);
        $this->View['search'] = $search;


        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportSUPPLIERLIST($sql, $id, $search, $nhacungcap->name, $phieudich->get()), 'NCC ' . $nhacungcap->name . ' ' . date("m-d-Y") . '.xlsx');
            }
        }
        if ($export = $request->input("pdf")) {
            if ($export == 'pdf') {
                $View = $this->View;
                $View['data_list'] = $phieudich->get();
                $View['name_supplier'] = $nhacungcap->name;
                $pdf = PDF::loadView('admin.excel.excelsupplierlist', $View, [], [])->download($View['name_supplier'] . " " . date("m-d-Y") . ".pdf");
            }

        }

        $this->View['data_list'] = $phieudich->paginate(50);
        $tokenCache = new TokenCache();
        $this->View['access_token'] = $tokenCache->getAccessToken(Auth::user());
        return view("admin.report.supplierlist", $this->View);
    }

    //NCC PHI DICH THUA
    public function supplierextension(Request $request)
    {


        DTOrderSupplier::whereRaw("tamung IS NULL AND approved_2='1' ")->update(['tamung' => 0]);

        DTOrderSupplier::whereRaw("tong IS NULL AND approved_2='1' ")->update(['tong' => 0]);
        $search = [];

        $filtered_buoi = false;
        if ($cid_buoi = $request->input("cid_buoi")) {
            $filtered_buoi = collect($this->cid_listbuoi)->where('id', $cid_buoi)->first();
            $search['cid_buoi'] = $cid_buoi;
        }

        $search['cid_supplier'] = '';
        $sql = " 1=1 ";
//        $sql = " approved_2 = '1' ";
        if ($request->input("cid_supplier")) {
            $sql = $sql . " AND cid_supplier = " . $request->input("cid_supplier");
            $search['cid_supplier'] = $request->input("cid_supplier");
        }
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }
        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;


            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
        }
        if ($ngaytrahoso = $request->input("ngaytrahoso")) {
            $search['ngaytrahoso'] = $ngaytrahoso;
        }


        // dd($sql);

        $this->View['cid_sort'] = $this->cid_sort;
        $this->View['cid_listbuoi'] = collect($this->cid_listbuoi)->pluck("name", "id");
        $search['cid_sort'] = '0';

        $sort = ['id', 'DESC'];
        if ($cid_sort = $request->input("cid_sort")) {
            if ($cid_sort == '1') {
                $sort = ['total', 'DESC'];
            }
            if ($cid_sort == '2') {
                $sort = ['total', 'ASC'];
            }
            $search['cid_sort'] = $cid_sort;
        }


        $dataset = DTOrderSupplier::whereRaw(DB::raw($sql))
            ->select("*", DB::raw(" sum(CASE WHEN approved_2 = '1' THEN phidichthuat ELSE 0 END) as total"))
            ->whereHas('phieudichthuat', function ($query) use ($ngaytrahoso, $filtered_buoi) {
                if ($ngaytrahoso) {
                    $giotrahoso_from = '00:00:00';
                    $giotrahoso_to = '23:59:59';
                    if ($filtered_buoi) {
                        $giotrahoso_from = $filtered_buoi['time_start'];
                        $giotrahoso_to = $filtered_buoi['time_end'];
                    }

                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $query->where('giotrahoso', '>=', $giotrahoso_from);
                    $query->where('giotrahoso', '<=', $giotrahoso_to);
                }
            })
            ->groupBy("cid_supplier")->orderBy($sort[0], $sort[1]);

        if ($export = $request->input("export")) {
            if ($export == 'excel') {
                return Excel::download(new InvoicesExportCongNoNCCPHIDICHTHUAT($sql, $sort, $dataset->get()), 'Công Nợ NCC Phí dịch thuật ' . date("m-d-Y") . '.xlsx');
            }
        }

        $this->View['tongso'] = $dataset->pluck('total')->sum();

        $this->View['data_list'] = $dataset->paginate(20);

        $this->View['cid_supplier'] = DTSupplier::orderBy("name", "DESC")->get()->pluck("name", "id");

        $this->View['cid_supplier'][''] = " -- Chọn NCC -- ";

        $this->View['search'] = $search;


        return view("admin.report.supplierextension", $this->View);
    }

    public function supplierextensionlist($id, Request $request)
    {

        $nhacungcap = DTSupplier::findOrFail($id);
        $this->View['supplier'] = $nhacungcap;

        $sql = " id IN (SELECT cid_form FROM DT_Order_Supplier WHERE approved_2='1')";
        $search = [];

        $filtered_buoi = false;
        if ($cid_buoi = $request->input("cid_buoi")) {
            $filtered_buoi = collect($this->cid_listbuoi)->where('id', $cid_buoi)->first();
            $search['cid_buoi'] = $cid_buoi;
        }

        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;
//            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }
        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
//            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
        }
        if ($ngaytrahoso = $request->input("ngaytrahoso")) {
            $search['ngaytrahoso'] = $ngaytrahoso;
//            $sql = $sql . " AND created_at  = '" . date("Y-m-d 23:00:00", strtotime($ngaytrahoso)) . "' ";
        }

        $this->View['search'] = $search;
        $tokenCache = new TokenCache();
        $this->View['access_token'] = $tokenCache->getAccessToken(Auth::user());
        $phieudich = DTForms::where('cid_supplier', $id)
            ->whereHas('OrderSuppliers', function ($query) {
                $query->where('approved_2', 1);
            })
            ->where(function ($query) use ($request, $filtered_buoi) {
                if ($date_from = $request->input("date_from")) {
                    $query->whereDate('created_at', '>=', Carbon::createFromFormat('m/d/Y', $date_from)->startOfDay());
                }

                if ($date_to = $request->input("date_to")) {
                    $query->whereDate('created_at', '<=', Carbon::createFromFormat('m/d/Y', $date_to)->endOfDay());
                }

                if ($ngaytrahoso = $request->input("ngaytrahoso")) {
//                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $giotrahoso_from = '00:00:00';
                    $giotrahoso_to = '23:59:59';
                    if ($filtered_buoi) {
                        $giotrahoso_from = $filtered_buoi['time_start'];
                        $giotrahoso_to = $filtered_buoi['time_end'];
                    }

                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $query->where('giotrahoso', '>=', $giotrahoso_from);
                    $query->where('giotrahoso', '<=', $giotrahoso_to);
                }
            })->orderBy("id", "DESC");

        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportSUPPLIERLISTPHIDICHTHUAT($sql, $id, $search, $nhacungcap->name, $phieudich->get()), 'NCC ' . $nhacungcap->name . ' ' . date("m-d-Y") . '.xlsx');
            }
        }
        if ($export = $request->input("pdf")) {
            if ($export == 'pdf') {
                $View = $this->View;
                $View['data_list'] = $phieudich->get();
                $View['name_supplier'] = $nhacungcap->name;
                $pdf = PDF::loadView('admin.excel.excelsupplierlistphidichthuat', $View, [], [])->download($View['name_supplier'] . " " . date("m-d-Y") . ".pdf");
            }

        }
        $this->View['data_list'] = $phieudich->paginate(50);

        return view("admin.report.supplierextensionlist", $this->View);
    }


    //END NCC PHI DICH THAUT


    public function customer(Request $request)
    {

        DTOrderCustomer::whereRaw("tamung IS NULL")->update(['tamung' => 0]);

        DTOrderCustomer::whereRaw("tong IS NULL")->update(['tong' => 0]);


        $search = [];

        $filtered_buoi = false;
        if ($cid_buoi = $request->input("cid_buoi")) {
            $filtered_buoi = collect($this->cid_listbuoi)->where('id', $cid_buoi)->first();
            $search['cid_buoi'] = $cid_buoi;
        }

        $search['cid_customer'] = $search['cid_customer_kl'] = '';
        $sql = " approved = '1' ";
        if ($request->input("cid_customer")) {
            $sql = $sql . " AND cid_customer = " . $request->input("cid_customer");
            $search['cid_customer'] = $request->input("cid_customer");
        }
        if ($request->input("cid_customer_kl")) {
            $sql = $sql . " AND cid_customer = " . $request->input("cid_customer_kl");
            $search['cid_customer_kl'] = $request->input("cid_customer_kl");
        }
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }
        if ($request->input("is_customer")) {
            $is_k = $request->input("is_customer");
            $sql = $sql . " AND cid_customer IN (SELECT id FROM DT_Customer WHERE is_kl='{$is_k}') ";
            $search['is_customer'] = $request->input("is_customer");
        }
        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
        }

        if ($ngaytrahoso = $request->input("ngaytrahoso")) {
            $search['ngaytrahoso'] = $ngaytrahoso;
        }

        // dd($sql);
        $this->View['is_customer'] = ['' => " -Tất cả KH-", '2' => " Khách Lẻ ", '1' => "Khách Hàng"];
        $this->View['cid_sort'] = $this->cid_sort;
        $this->View['cid_listbuoi'] = collect($this->cid_listbuoi)->pluck("name", "id");
        $search['cid_sort'] = '0';

        $sort = ['id', 'DESC'];
        if ($cid_sort = $request->input("cid_sort")) {
            if ($cid_sort == '1') {
                $sort = ['total', 'DESC'];
            }
            if ($cid_sort == '2') {
                $sort = ['total', 'ASC'];
            }
            $search['cid_sort'] = $cid_sort;

        }

        $dataset = DTOrderCustomer::whereRaw(DB::raw($sql))
            ->whereHas('phieudichthuat', function ($query) use ($ngaytrahoso,$filtered_buoi) {
                if ($ngaytrahoso) {
//                    $query->whereDate('ngaytrahoso', '=', Carbon::parse($ngaytrahoso)->toDateTimeString());
                    $giotrahoso_from = '00:00:00';
                    $giotrahoso_to = '24:00:00';
                    if ($filtered_buoi) {
                        $giotrahoso_from = $filtered_buoi['time_start'];
                        $giotrahoso_to = $filtered_buoi['time_end'];
                    }

                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $query->where('giotrahoso', '>=', $giotrahoso_from);
                    $query->where('giotrahoso', '<=', $giotrahoso_to);
                }
            })
            ->select("*", DB::raw(" sum(tong-tamung) as total"))
            ->groupBy("cid_customer")->orderBy($sort[0], $sort[1]);

        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportCongNoKH($sql, $sort, $dataset->get()), 'Công Nợ KH ' . date("m-d-Y") . '.xlsx');
            }
        }

        $this->View['tongso'] = DTOrderCustomer::select(DB::raw(" sum(tong-tamung) as total"))->whereRaw(DB::raw(" approved = '1' "))->first();


        $this->View['data_list'] = $dataset->paginate(20);


        // $this->View['cid_supplier']=DTSupplier::orderBy("name","DESC")->get()->pluck("name","id");
        $this->View['cid_customer'] = DTCustomer::where("is_kl", '1')->orderBy("name", "DESC")->get()->pluck("name", "id");
        // $this->View['cid_supplier']['']=" -- Chọn Nhà Cung Cấp -- ";
        $this->View['cid_customer'][''] = " -- Chọn Khách Hàng -- ";

        $this->View['cid_customer_kl'] = DTCustomer::where("is_kl", '2')->orderBy("name", "DESC")->get()->pluck("name", "id");
        $this->View['cid_customer_kl'][''] = " -- Chọn Khách Lẻ -- ";

        $this->View['search'] = $search;


        return view("admin.report.customer", $this->View);
    }

    public function customerlist($id, Request $request)
    {
        $customer = DTCustomer::findOrFail($id);
        $this->View['customer'] = $customer;
        $search = [];

        $filtered_buoi = false;
        if ($cid_buoi = $request->input("cid_buoi")) {
            $filtered_buoi = collect($this->cid_listbuoi)->where('id', $cid_buoi)->first();
            $search['cid_buoi'] = $cid_buoi;
        }
        $phieudich = DTForms::where('cid_customer', $id)
            ->whereHas('ordercustomers', function ($query) {
                $query->where('approved', 1);
            })
            ->where(function ($query) use ($request, $filtered_buoi) {
                if ($list_ids = $request->input("list_checkbox")) {
                    $list_ids = array_map('trim', explode(',', $list_ids));
                    $query->whereIn('id', $list_ids);
                }
                if ($date_from = $request->input("date_from")) {
                    $query->where('created_at', '>=', Carbon::createFromFormat('m/d/Y', $date_from)->startOfDay());
                }

                if ($date_to = $request->input("date_to")) {
                    $query->where('created_at', '<=', Carbon::createFromFormat('m/d/Y', $date_to)->endOfDay());
                }

                if ($ngaytrahoso = $request->input("ngaytrahoso")) {
                    $giotrahoso_from = '00:00:00';
                    $giotrahoso_to = '24:00:00';
                    if ($filtered_buoi) {
                        $giotrahoso_from = $filtered_buoi['time_start'];
                        $giotrahoso_to = $filtered_buoi['time_end'];
                    }

                    $query->whereDate('ngaytrahoso', Carbon::createFromFormat('m/d/Y', $ngaytrahoso));
                    $query->where('giotrahoso', '>=', $giotrahoso_from);
                    $query->where('giotrahoso', '<=', $giotrahoso_to);
                }
            })->orderBy("id", "DESC");

        $sql = "cid_customer={$id} AND  id IN (SELECT cid_form FROM DT_Order_Customer WHERE approved='1')";


        if ($list_ids = $request->input("list_checkbox")) {
            $sql = $sql . " AND id IN (" . $list_ids . ") ";
        }

        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;
            $sql = $sql . " AND created_at >= '" . Carbon::createFromFormat('m/d/Y', $date_from)->startOfDay() . "' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND created_at  < '" . Carbon::createFromFormat('m/d/Y', $date_to)->endOfDay() . "' ";
        }

        if ($ngaytrahoso = $request->input("ngaytrahoso")) {
            $search['ngaytrahoso'] = $ngaytrahoso;
            $sql = $sql . " AND ngaytrahoso = '" . date("Y-m-d", strtotime($date_to)) . "' ";
        }

        $this->View['search'] = $search;

        if ($export = $request->input("export")) {

            if ($export == 'excel') {

                return Excel::download(new InvoicesExportCUSTOMERLIST($sql, $search, $this->View['customer']['name'], $phieudich->get()), 'KH_' . $this->View['customer']['name'] . '_' . date("m-d-Y") . '.xlsx');
            }
        }
        if ($export = $request->input("pdf")) {
            if ($export == 'pdf') {
                $View = $this->View;
                $View['data_list'] = $phieudich->get();
                $View['name_customer'] = $this->View['customer']['name'];
                $pdf = PDF::loadView('admin.excel.pdfcustomerlist', $View, [], [
                    'format' => 'A4-L'
                ])->download($View['name_customer'] . " " . date("m-d-Y") . ".pdf");
            }

        }

        $this->View['data_list'] = $phieudich->paginate(50);
        $tokenCache = new TokenCache();
        $this->View['access_token'] = $tokenCache->getAccessToken(Auth::user());
        //$this->View['data_list']

        return view("admin.report.customerlist", $this->View);
    }

    public function doanhthu(Request $request)
    {

        $search = [];
        $this->View['filter'] = ['1' => " Doanh Số Theo Ngày ", '2' => " Doanh Số Theo Tháng ", '3' => "Doanh Số Theo Năm"];
        $search['filter'] = $request->input("filter", '1');


        $sql = " id > 0 ";
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
        }

        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportDoanhThu($sql, $search['filter']), "Doanh Thu " . date("d-m-Y H:i:s") . ".xlsx");
            }
        }


        $this->View['tongds'] = DB::table("DT_Phieu_Thu")->select("*", DB::raw("SUM(price) as total"))->first();

        if ($search['filter'] == '1') {
            $this->View['data_list'] = DTPhieuthu::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("DATE(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }
        if ($search['filter'] == '2') {
            $this->View['data_list'] = DTPhieuthu::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("MONTH(created_at),YEAR(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }
        if ($search['filter'] == '3') {
            $this->View['data_list'] = DTPhieuthu::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("YEAR(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }

        $this->View['search'] = $search;
        return view("admin.report.doanhthu", $this->View);
    }

    public function tatcaphieu(Request $request)
    {

        $search = [];
        $this->View['filter'] = ['1' => " Doanh Số Theo Ngày ", '2' => " Doanh Số Theo Tháng ", '3' => "Doanh Số Theo Năm"];
        $search['filter'] = $request->input("filter", '1');


        $sql = " id > 0 ";
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
        }

        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportDoanhThu($sql, $search['filter']), "Doanh Thu " . date("d-m-Y H:i:s") . ".xlsx");
            }
        }


        $this->View['tongds'] = $t = DB::table("DT_Order_Customer")->select(DB::raw("SUM(tong) as total"))->first();

        /* $this->View['tongds_test']= $x=DTOrderCustomer::select(DB::raw("SUM(tong) as total"))->toSql();
      dd($t,$x);*/


        if ($search['filter'] == '1') {
            $this->View['data_list'] = DTOrderCustomer::select("*", DB::raw("SUM(tong-tamung) as total,SUM(tong) as mytong,SUM(tamung) as mytamung"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("DATE(created_at)"))->orderBy("id", "DESC")->paginate(20);;
        }
        if ($search['filter'] == '2') {
            $this->View['data_list'] = DTOrderCustomer::select("*", DB::raw("SUM(tong-tamung) as total,SUM(tong) as mytong,SUM(tamung) as mytamung"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("MONTH(created_at),YEAR(created_at)"))->orderBy("id", "DESC")->paginate(20);;
        }
        if ($search['filter'] == '3') {
            $this->View['data_list'] = DTOrderCustomer::select("*", DB::raw("SUM(tong-tamung) as total,SUM(tong) as mytong,SUM(tamung) as mytamung"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("YEAR(created_at)"))->orderBy("id", "DESC")->paginate(20);;
        }


        $this->View['search'] = $search;
        return view("admin.report.tatcaphieu", $this->View);
    }

    public function danhsachtatcaphieu($value, Request $request)
    {
        $filter = $request->input("filter", "1");


        $search = [];
        $search['filter'] = $filter;
        if ($filter == '1') {
            $convert_date = date("Y/m/d", strtotime($value));
            $sql = " DATE(created_at) = '{$convert_date}' ";
            $this->View['value'] = "Ngày: " . $value;
        }
        if ($filter == '2') {

            $sql = " MONTH(created_at) = '{$value}' ";
            if ($value_year = $request->input("myyear")) {
                $sql = " MONTH(created_at) = '{$value}' AND YEAR(created_at) = '{$value_year}' ";
            }
            //dd($sql);
            $this->View['value'] = "Tháng: " . $value . " - " . $value_year;

        }
        if ($filter == '3') {

            $sql = " YEAR(created_at) = '{$value}' ";
            $this->View['value'] = "Năm: " . $value;

        }

        if ($myyear = $request->input("myyear")) {
            $search['myyear'] = $myyear;

        }
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            //$sql = $sql." AND created_at > '".date("Y-m-d H:i:s",strtotime($date_from))."' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            //  $sql = $sql." AND created_at  < '".date("Y-m-d H:i:s",strtotime($date_to))."' ";
        }
        //  dd($sql);
        $this->View['search'] = $search;

        $TData = DTForms::whereRaw(DB::raw($sql))->orderBy("id", "DESC")
            ->paginate(50);

        $this->View['data_list'] = $TData;
        $tokenCache = new TokenCache();
        $this->View['access_token'] = $tokenCache->getAccessToken(Auth::user());
        return view("admin.report.danhsachtatcaphieu", $this->View);


    }


    public function danhsachdoanhthu($value, Request $request)
    {
        $filter = $request->input("filter", "1");


        $search = [];
        $search['filter'] = $filter;
        if ($filter == '1') {
            $convert_date = date("Y/m/d", strtotime($value));
            $sql = " DATE(created_at) = '{$convert_date}' ";
            $this->View['value'] = "Ngày: " . $value;
        }
        if ($filter == '2') {

            $sql = " MONTH(created_at) = '{$value}' ";
            if ($value_year = $request->input("myyear")) {
                $sql = " MONTH(created_at) = '{$value}' AND YEAR(created_at) = '{$value_year}' ";
            }

            $this->View['value'] = "Tháng: " . $value . " - " . $value_year;

        }
        if ($filter == '3') {

            $sql = " YEAR(created_at) = '{$value}' ";
            $this->View['value'] = "Năm: " . $value;

        }

        if ($myyear = $request->input("myyear")) {
            $search['myyear'] = $myyear;

        }
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            //$sql = $sql." AND created_at > '".date("Y-m-d H:i:s",strtotime($date_from))."' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            //  $sql = $sql." AND created_at  < '".date("Y-m-d H:i:s",strtotime($date_to))."' ";
        }
        //  dd($sql);
        $this->View['search'] = $search;

        $TData = DTPhieuthu::whereRaw($sql)->orderBy("id", "DESC")
            ->paginate(20);

        $this->View['data_list'] = $TData;

        return view("admin.report.danhsachdoanhthu", $this->View);


    }

    public function chiphi(Request $request)
    {
        $search = [];
        $this->View['filter'] = ['1' => " Doanh Số Theo Ngày ", '2' => " Doanh Số Theo Tháng ", '3' => "Doanh Số Theo Năm"];
        $search['filter'] = $request->input("filter", '1');


        $sql = " id > 0 ";
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
        }

        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportChiPhi($sql, $search['filter']), "Chi Phí " . date("d-m-Y H:i:s") . ".xlsx");
            }
        }


        $this->View['tongds'] = DB::table("DT_Phieu_Chi")->select("*", DB::raw("SUM(price) as total"))->first();

        if ($search['filter'] == '1') {
            $this->View['data_list'] = DTPhieuchi::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("DATE(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }
        if ($search['filter'] == '2') {
            $this->View['data_list'] = DTPhieuchi::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("MONTH(created_at),YEAR(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }
        if ($search['filter'] == '3') {
            $this->View['data_list'] = DTPhieuchi::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("YEAR(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }

        $this->View['search'] = $search;
        return view("admin.report.chiphi", $this->View);
    }

    public function chiphinhacungcap(Request $request)
    {
        $search = [];
        $this->View['filter'] = ['1' => " Doanh Số Theo Ngày ", '2' => " Doanh Số Theo Tháng ", '3' => "Doanh Số Theo Năm"];
        $search['filter'] = $request->input("filter", '1');


        $sql = " id > 0 ";

        if ($supplier = $request->input("supplier")) {
            $search['supplier'] = $supplier;

            $first = DTSupplier::find($supplier);

            $sql = " cid_form IN (SELECT id FROM DT_Form WHERE  cid_supplier = {$first['id']} )";
        } else {
            $first = false;
        }
        $this->View['detail_supplier'] = $first;


        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND created_at >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND created_at  <= '" . date("Y-m-d 23:00:00", strtotime($date_to)) . "' ";
        }

        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportChiPhi($sql, $search['filter']), "Chi Phí " . date("d-m-Y H:i:s") . ".xlsx");
            }
        }

        if ($first) {
            $this->View['tongds'] = DTPhieuchi::select(DB::raw("SUM(price) as total"))->where("cid_form", "!=", 0)->whereRaw(DB::raw(" cid_form IN (SELECT id FROM DT_Form WHERE  cid_supplier = {$first['id']} )"))->first();
        } else {
            $this->View['tongds'] = DTPhieuchi::select(DB::raw("SUM(price) as total"))->where("cid_form", "!=", 0)->first();
        }

        $this->View['dsncc'] = DTSupplier::get()->pluck("name", "id");
        $this->View['dsncc'][''] = " -- All -- ";


        if ($search['filter'] == '1') {

            $this->View['data_list'] =
                DTPhieuchi::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
                groupBy(DB::raw("DATE(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }
        if ($search['filter'] == '2') {
            $this->View['data_list'] = DTPhieuchi::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("MONTH(created_at),YEAR(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }
        if ($search['filter'] == '3') {
            $this->View['data_list'] = DTPhieuchi::select("*", DB::raw("SUM(price) as total"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("YEAR(created_at)"))->orderBy("id", "DESC")->paginate(10);;
        }

        $this->View['search'] = $search;
        return view("admin.report.chiphinhacungcap", $this->View);
    }


    public function danhsachchiphi($value, Request $request)
    {
        $filter = $request->input("filter", "1");
        $is_type = $request->input("is_type");

        $search = [];
        $search['filter'] = $filter;
        $search['is_type'] = $is_type;
        if ($filter == '1') {
            $convert_date = date("Y/m/d", strtotime($value));
            $sql = " DATE(created_at) = '{$convert_date}' ";
            $this->View['header_datetime'] = "Ngày: " . $value;
        }
        if ($filter == '2') {

            $sql = " MONTH(created_at) = '{$value}' ";
            if ($value_year = $request->input("myyear")) {
                $sql = " MONTH(created_at) = '{$value}' AND YEAR(created_at) = '{$value_year}' ";
            }
            $this->View['header_datetime'] = "Tháng: " . $value . " - " . $value_year;

        }
        if ($filter == '3') {

            $sql = " YEAR(created_at) = '{$value}' ";
            $this->View['header_datetime'] = "Năm: " . $value;

        }

        if ($myyear = $request->input("myyear")) {
            $search['myyear'] = $myyear;
        }
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;

        }
        //  dd($sql);
        $this->View['search'] = $search;
        $this->View['value'] = $value;

        $dTotal = DTPhieuchi::whereRaw($sql);

        $total['tong'] = App\MrData::toPrice(DTPhieuchi::whereRaw($sql)->sum('price'));
        $total['dichvu'] = App\MrData::toPrice(DTPhieuchi::whereRaw($sql)->whereIn('is_type', [1, 3])->sum('price'));
        $total['dichthuat'] = App\MrData::toPrice(DTPhieuchi::whereRaw($sql)->where('is_type', '=', 2)->sum('price'));

        $TData = DTPhieuchi::whereRaw($sql)->orderBy("id", "DESC")
            ->where(function ($query) use ($search) {
                if (isset($search['is_type'])) {
                    if ($search['is_type'] == 'dv') {
                        $query->whereIn('is_type', [1, 3]);
                    } elseif ($search['is_type'] == 'dt') {
                        $query->where('is_type', '=', 2);
                    }
                }
            })
            ->paginate(20);

        $this->View['data_list'] = $TData;
        $this->View['dTotal'] = $dTotal;
        $this->View['total'] = $total;

        return view("admin.report.danhsachchiphi", $this->View);


    }

    public function danhsachchiphinhacungcap($value, Request $request)
    {
        $filter = $request->input("filter", "1");


        $search = [];
        $search['filter'] = $filter;
        if ($filter == '1') {
            $convert_date = date("Y/m/d", strtotime($value));
            $sql = " DATE(created_at) = '{$convert_date}' ";
            $this->View['value'] = "Ngày: " . $value;
        }
        if ($filter == '2') {

            $sql = " MONTH(created_at) = '{$value}' ";
            if ($value_year = $request->input("myyear")) {
                $sql = " MONTH(created_at) = '{$value}' AND YEAR(created_at) = '{$value_year}' ";
            }
            $this->View['value'] = "Tháng: " . $value . " - " . $value_year;

        }
        if ($filter == '3') {

            $sql = " YEAR(created_at) = '{$value}' ";
            $this->View['value'] = "Năm: " . $value;

        }
        if ($id_supplier = $request->input("supplier")) {
            $this->View['detail_supplier'] = DTSupplier::find($id_supplier);
            $sql = $sql . " AND  cid_form IN (SELECT id FROM DT_Form WHERE  cid_supplier = {$id_supplier} )";

            $search['supplier'] = $id_supplier;
        } else {
            $this->View['detail_supplier'] = false;
            $sql = $sql . " AND  cid_form > 0 ";


        }


        if ($myyear = $request->input("myyear")) {
            $search['myyear'] = $myyear;
        }
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;

        }
        //dd($sql);
        $this->View['search'] = $search;

        $TData = DTPhieuchi::whereRaw($sql)->orderBy("id", "DESC")
            ->paginate(20);

        $this->View['data_list'] = $TData;

        return view("admin.report.danhsachchiphinhacungcap", $this->View);


    }


    public function loinhuan(Request $request)
    {
        $this->update_report();
        $search = [];
        $this->View['filter'] = ['1' => " Doanh Số Theo Ngày ", '2' => " Doanh Số Theo Tháng ", '3' => "Doanh Số Theo Năm"];
        $search['filter'] = $request->input("filter", '1');


        $sql = " id > 0 ";
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND my_date >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND my_date  <= '" . date("Y-m-d H:i:s", strtotime($date_to)) . "' ";
        }

        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                return Excel::download(new InvoicesExportLoiNhuan($sql, $search['filter']), "Báo cáo " . date("d-m-Y H:i:s") . ".xlsx");
            }
        }


        $this->View['tongds'] = DB::table("DT_Phieu_Thu")->select("*", DB::raw("SUM(price) as total"))->first();

        if ($search['filter'] == '1') {
            $this->View['data_list'] = DTReport::whereRaw(DB::raw($sql))->orderBy("my_date", "DESC")->paginate(10);
        }
        if ($search['filter'] == '2') {
            $this->View['data_list'] = $t = DTReport::select("*", DB::raw("MONTH(my_date) as my_month"), DB::raw("YEAR(my_date) as my_year"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("MONTH(my_date),YEAR(created_at)"))
                ->orderBy("my_date", "DESC")->paginate(10);;


        }
        if ($search['filter'] == '3') {
            $this->View['data_list'] = DTReport::select("*", DB::raw("YEAR(my_date) as my_year"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("YEAR(my_date)"))->orderBy("my_date", "DESC")->paginate(10);;
        }

        $this->View['search'] = $search;


        $this->View['tongKH'] = DTOrderCustomer::select(DB::raw("SUM(tong) as total"))->first();
        $this->View['tongNCC'] = DTOrderSupplier::select(DB::raw("SUM(tong) as total"))->first();

        $this->View['CONLAI'] = DTOrderCustomer::select(DB::raw("SUM(tong-tamung) as total"))->where("approved", '1')->first();
        /*
                  $x=(DTOrderCustomer::select(DB::raw("SUM(tong) as total"))->where("approved",'1')->first() ) ;
                  $y=(DTOrderCustomer::select(DB::raw("SUM(tamung) as total"))->where("approved",'1')->first() ) ;

                  dd((int)$y['total']);
                 exit;*/
        $this->View['TONGCHI'] = DTPhieuchi::select(DB::raw("SUM(price) as total"))->first();
        $this->View['TONGTHU'] = DTPhieuthu::select(DB::raw("SUM(price) as total"))->where("cid_form", "!=", "0")->first();

        $this->View['TONGTHU_2'] = DTPhieuthu::select(DB::raw("SUM(price) as total"))->where("cid_form", "=", "0")->first();
        $this->View['LOINHUAN'] = (int)$this->View['TONGTHU']['total'] - (int)$this->View['TONGCHI']['total'];

        return view("admin.report.loinhuan", $this->View);
    }

    public function update_report($forceRefresh = false)
    {
        $start = microtime(true);
        $cacheKey = 'update_report_last_run';
        
        // Skip if already ran within the last hour (unless forced)
        if (!$forceRefresh) {
            $lastRun = cache($cacheKey);
            if ($lastRun && now()->diffInMinutes($lastRun) < 60) {
            // Log::info('update_report: SKIPPED (cached)', [
            //     'last_run' => $lastRun->toDateTimeString(),
            //     'minutes_ago' => now()->diffInMinutes($lastRun)
            // ]);
                return true;
            }
        }
        
        // Fast check: Compare max dates instead of full table scan
        $maxPhieuThuDate = DB::table('DT_Phieu_Thu')->max('created_at');
        $maxPhieuChiDate = DB::table('DT_Phieu_Chi')->max('created_at');
        $maxReportDate = DB::table('DT_Report')->max('my_date');
        
        // Log::info('update_report: Date comparison', [
        //     'max_phieu_thu' => $maxPhieuThuDate,
        //     'max_phieu_chi' => $maxPhieuChiDate,
        //     'max_report' => $maxReportDate,
        //     'time' => round(microtime(true) - $start, 3) . 's'
        // ]);
        
        // Quick check: if report is up to date, skip expensive queries
        $needsUpdate = false;
        if ($maxPhieuThuDate && (!$maxReportDate || date('Y-m-d', strtotime($maxPhieuThuDate)) > $maxReportDate)) {
            $needsUpdate = true;
        }
        if ($maxPhieuChiDate && (!$maxReportDate || date('Y-m-d', strtotime($maxPhieuChiDate)) > $maxReportDate)) {
            $needsUpdate = true;
        }
        
        if (!$needsUpdate) {
            // Log::info('update_report: No new dates needed', ['time' => round(microtime(true) - $start, 3) . 's']);
            cache([$cacheKey => now()], 60); // Cache for 60 minutes
            return true;
        }
        
        // Only run expensive queries if actually needed
        $all_date_phieu_thu = DB::select("
            SELECT DISTINCT DATE(pt.created_at) as mydate 
            FROM DT_Phieu_Thu pt 
            WHERE DATE(pt.created_at) > IFNULL((SELECT MAX(my_date) FROM DT_Report), '1970-01-01')
            LIMIT 100
        ");
        
        // Log::info('update_report: Found ' . count($all_date_phieu_thu) . ' new phieu_thu dates', [
        //     'time' => round(microtime(true) - $start, 3) . 's'
        // ]);

        if (count($all_date_phieu_thu) > 0) {
            $insertData = array_map(function($item) {
                return ['my_date' => $item->mydate, 'created_at' => now(), 'updated_at' => now()];
            }, $all_date_phieu_thu);
            DTReport::insert($insertData);
        }

        $all_date_phieu_chi = DB::select("
            SELECT DISTINCT DATE(pc.created_at) as mydate 
            FROM DT_Phieu_Chi pc 
            WHERE DATE(pc.created_at) > IFNULL((SELECT MAX(my_date) FROM DT_Report), '1970-01-01')
              AND DATE(pc.created_at) NOT IN (SELECT my_date FROM DT_Report)
            LIMIT 100
        ");
        
        // Log::info('update_report: Found ' . count($all_date_phieu_chi) . ' new phieu_chi dates', [
        //     'time' => round(microtime(true) - $start, 3) . 's'
        // ]);

        if (count($all_date_phieu_chi) > 0) {
            $insertData = array_map(function($item) {
                return ['my_date' => $item->mydate, 'created_at' => now(), 'updated_at' => now()];
            }, $all_date_phieu_chi);
            DTReport::insert($insertData);
        }
        
        cache([$cacheKey => now()], 60); // Cache for 60 minutes
        // Log::info('update_report COMPLETED', ['total_time' => round(microtime(true) - $start, 3) . 's']);
        return true;
    }

    public function loinhuankhachhang(Request $request)
    {
        $totalStart = microtime(true);
        // Log::info('=== loinhuankhachhang START ===', [
        //     'request_params' => $request->all(),
        //     'memory' => round(memory_get_usage() / 1024 / 1024, 2) . 'MB'
        // ]);
        
        //Thêm thống kê doanh số của 01 khách hàng theo khoảng thời gian chỉ định
        $this->update_report();
        // Log::info('After update_report()', ['elapsed' => round(microtime(true) - $totalStart, 3) . 's']);

        // NOTE: NULL tamung/tong values should be fixed by migration: 2025_12_10_153000_fix_order_customer_null_defaults
        // Monitoring check disabled - uncomment if needed for debugging
        // $nullTamungCount = DTOrderCustomer::whereNull('tamung')->count();
        // $nullTongCount = DTOrderCustomer::whereNull('tong')->count();
        // if ($nullTamungCount > 0 || $nullTongCount > 0) {
        //     Log::warning('Found NULL records in DT_Order_Customer - migration may not have run', [
        //         'null_tamung' => $nullTamungCount,
        //         'null_tong' => $nullTongCount
        //     ]);
        // }
        // Log::info('After NULL check', ['elapsed' => round(microtime(true) - $totalStart, 3) . 's']);


        $search = [];
        $this->View['filter'] = ['1' => " Doanh Số Theo Ngày ", '2' => " Doanh Số Theo Tháng ", '3' => "Doanh Số Theo Năm"];
        $this->View['customer'] = DTCustomer::get()->pluck("name", "id");
        // Log::info('After customer list load', ['elapsed' => round(microtime(true) - $totalStart, 3) . 's']);


        if ($id_cus = $request->input("customer")) {
            $this->View["cus"] = DTCustomer::find($id_cus);
            $search['customer'] = $id_cus;
        } else {
            $this->View["cus"] = DTCustomer::first();
        }


        $search['filter'] = $request->input("filter", '1');


        $sql = " id > 0 ";
        if ($date_from = $request->input("date_from")) {
            $search['date_from'] = $date_from;


            $sql = $sql . " AND my_date >= '" . date("Y-m-d H:i:s", strtotime($date_from)) . "' ";
        }

        if ($date_to = $request->input("date_to")) {
            $search['date_to'] = $date_to;
            $sql = $sql . " AND my_date  <= '" . date("Y-m-d H:i:s", strtotime($date_to)) . "' ";
        }

        // Optimized: Use DATE(created_at) with proper index instead of DATE_FORMAT
        // Create an indexed computed column or use DATE() which MySQL can optimize better
        $cusId = $this->View["cus"]->id ?? 0;
        
        if ($export = $request->input("export")) {

            if ($export == 'excel') {
                if ($search['filter'] == '1') {
                    // Optimized: Use DATE() instead of DATE_FORMAT for better index usage
                    $sql = $sql . ' AND my_date IN (SELECT DATE(created_at) FROM DT_Order_Customer WHERE cid_customer = ' . $cusId . ') ';
                }
                // Log::info('Starting Excel export', ['elapsed' => round(microtime(true) - $totalStart, 3) . 's']);
                return Excel::download(new InvoicesExportLoiNhuanKhachhang($sql, $search['filter'], $cusId), "" . $this->View['cus']->name . " - " . date("d-m-Y H:i:s") . ".xlsx");
            }
        }

        // Log::info('Building main query', ['filter' => $search['filter'], 'elapsed' => round(microtime(true) - $totalStart, 3) . 's']);

        if ($search['filter'] == '1') {
            // Optimized: Use IN with DATE() instead of EXISTS with DATE_FORMAT
            // This allows MySQL to use index on cid_customer and performs better
            $sql = $sql . ' AND my_date IN (SELECT DATE(created_at) FROM DT_Order_Customer WHERE cid_customer = ' . $cusId . ') ';

            // Log::debug('Filter 1 SQL', ['sql' => $sql]);

            $this->View['data_list'] = DTReport::whereRaw(DB::raw($sql))->orderBy("my_date", "DESC")->paginate(10);
        }
        if ($search['filter'] == '2') {
            $this->View['data_list'] = $t = DTReport::select("*", DB::raw("MONTH(my_date) as my_month"), DB::raw("YEAR(my_date) as my_year"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("MONTH(my_date),YEAR(created_at)"))
                ->orderBy("my_date", "DESC")->paginate(10);;


        }
        if ($search['filter'] == '3') {
            $this->View['data_list'] = DTReport::select("*", DB::raw("YEAR(my_date) as my_year"))->whereRaw(DB::raw($sql))->
            groupBy(DB::raw("YEAR(my_date)"))->orderBy("my_date", "DESC")->paginate(10);;
        }
        
        // Log::info('After main query', ['elapsed' => round(microtime(true) - $totalStart, 3) . 's']);

        $this->View['search'] = $search;

        // Log::info('=== loinhuankhachhang END ===', [
        //     'total_time' => round(microtime(true) - $totalStart, 3) . 's',
        //     'memory' => round(memory_get_usage() / 1024 / 1024, 2) . 'MB'
        // ]);

        return view("admin.report.loinhuankhachhang", $this->View);
    }

}
