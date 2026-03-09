<?php

namespace App\Model;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Krizalys\Onedrive\NameConflictBehavior;
use Session;

use GuzzleHttp\Client as GuzzleHttpClient;
use Krizalys\Onedrive\Client;
use Microsoft\Graph\Graph;

class Forms extends Model
{
    //

    protected $table = 'DT_Form';

    protected $primary = 'id';
    protected $timestamp = true;

    protected $fillable = [
        'cid_customer',
        'cid_supplier',
        'code',
        'name',
        'name_docs',
        'name_number',
        'phone',
        'sobandich',
        'ngaytrahoso',
        'approved',
        'cid_users',
        'locked',
        'path_work',
        'drive_item',
    ];

    protected $guarded = [
        'id'
    ];

//    public static function boot()
//    {
//        parent::boot();
//
//        static::creating(function ($form) {
//            $client_id = "8af3923f-2e65-4b7c-bc0b-8b52b19de073";
//            $client_secret = "ZdO8Q~~N6drWEx6FqR_MRRwD2QhwIXvsvN2Wwbs-";
//            $ten_nhacungcap = $form->nhacungcap->name;
//            $ten_khachhang = $form->khachhang->name;
//            $strSophieu = $form->code;
//            $today = Carbon::now();
//            $str_Year = $today->year;
//            $str_Month = $today->month;
//            $is_error = false;
//            $arrPath = array($ten_nhacungcap, $str_Year, $str_Month, $ten_khachhang, $strSophieu);
//            $strPath = implode('/', $arrPath);
//
//            try {
//                if (!Session::has('onedrive')) {
//                    $onedrive = new Client(
//                        $client_id,
//                        new Graph(),
//                        new GuzzleHttpClient(),
//                        [
//                            // Restore the previous state while instantiating this client to proceed
//                            // in obtaining an access token.
//                            'client_id' => $client_id,
//                            'state' => Session::get('onedrive')
//                        ]
//                    );
//
//                    $onedrive->obtainAccessToken($client_secret, $_GET['code']);
//                    Session::put("onedrive", $onedrive->getState());
//                }
//
//                if (Session::has('onedrive')) {
//                    $graph = new Graph();
//                    $graph->setAccessToken(Session::get('onedrive')->token->data->access_token);
//
//                    $onedrive = new Client(
//                        $client_id,
//                        $graph,
//                        new GuzzleHttpClient(),
//                        [
//                            // Restore the previous state while instantiating this client to proceed
//                            // in obtaining an access token.
//                            'client_id' => $client_id,
//                            'state' => Session::get('onedrive')
//                        ]
//                    );
//                    $fetchRoot = $onedrive->getRoot();
//                    $driveItems = $fetchRoot->getChildren();
//                    $dtdpFolder = null;
//                    foreach($driveItems as $item){
//                        if($item->name == 'DTDP'){
//                            $dtdpFolder = $item;
//                            break;
//                        }
//                    }
//
//                    if (!$dtdpFolder) {
//                        $dtdpFolder = $fetchRoot->createFolder('DTDP', ['name_conflict_behavior', NameConflictBehavior::REPLACE]);
//                    }
//
//                    $oldPath = $dtdpFolder;
//
//                    foreach ($arrPath as $key => $path) {
//                        try {
//                            $oldPath = $oldPath->createFolder($path, ['name_conflict_behavior', NameConflictBehavior::REPLACE]);
//                        } catch (ClientException  $ex) {
//                            $is_error = true;
//                        }
//                    }
//
//                    if(!$is_error){
//                        $form['path_work'] = $oldPath->id;
//                    }
//
//                }
//
//            } catch (\Exception $e) {
//                $is_error = true;
//            }
//
//            if($is_error){
//                return Redirect::back()->with("warning", "Vui lòng đăng nhập OneDrive")->withInput();
//            }
//
//        });
//    }


    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, "cid_supplier")->getResults();
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class, "cid_customer")->getResults();
    }

    public function khachhang()
    {
        return $this->belongsTo(Customer::class, "cid_customer");
    }

    public function nhacungcap()
    {
        return $this->belongsTo(Supplier::class, "cid_supplier");
    }

    public function OrderSupplier()
    {
        return $this->hasMany(OrderSupplier::class, "cid_form")->getResults();
    }

    public function OrderSuppliers()
    {
        return $this->belongsTo(OrderSupplier::class, "id", "cid_form");
    }

    public function ordercustomers()
    {
        return $this->hasMany(OrderCustomer::class, "cid_form", 'id');
    }

    public function OrderCustomer()
    {
        return $this->hasMany(OrderCustomer::class, "cid_form")->getResults();
    }

    public function User()
    {
        return $this->belongsTo(Users::class, "cid_users")->getResults();
    }

    public function getTongAttribute()
    {
        $result = 0;
        $ordercustomer = $this->ordercustomers();
        if ($ordercustomer) {
            $result = $ordercustomer->sum('tong');
        }
        return $result;
    }

//    public function OrderCustomers()
//    {
//        return $this->hasMany(OrderCustomer::class, "cid_form");
//    }

    public function getTamungAttribute()
    {
        $result = 0;
        $ordercustomer = $this->OrderCustomers();
        if ($ordercustomer) {
            $result = $ordercustomer->sum('tamung');
        }
        return $result;
//        return $this->OrderCustomers()->sum('tamung');
    }

    public function getTenKhachHangAttribute()
    {
        $result = "";
        $customer = $this->khachhang;
        if ($customer) {
            $result = $customer->name;
        }
        return $result;
    }

    public function getIsDoneAttribute()
    {
        $result = false;
        $ordersupplier = $this->OrderSuppliers;
        if (isset($ordersupplier)) {
            if ($ordersupplier->approved == '2' && $ordersupplier->approved_2 == '2') {
                $result = true;
            }
        }
        return $result;
    }

    public function getTongcongnoAttribute()
    {
        $result = 0;
        $ordersupplier = $this->OrderSuppliers;
        if (isset($ordersupplier)) {

            if ($ordersupplier->approved_cong_chung != "2") {
                $result = $result + (float)$ordersupplier->congchung;
            }
            if ($ordersupplier->approved_dau_cong_ty != "2") {
                $result = $result + (float)$ordersupplier->daucongty;
            }
            if ($ordersupplier->approved_sao_y != "2") {
                $result = $result + (float)$ordersupplier->saoy;
            }
            if ($ordersupplier->approved_ngoai_vu != "2") {
                $result = $result + (float)$ordersupplier->ngoaivu;
            }
            if ($ordersupplier->approved_phi_van_chuyen != "2") {
                $result = $result + (float)$ordersupplier->phivanchuyen;
            }
            if ($ordersupplier->approved_vat != "2") {
                $result = $result + (float)$ordersupplier->vat;
            }
            if ($ordersupplier->tamung) {
                $result = $result - (float)$ordersupplier->tamung;
            }
        }


        return $result;
    }
}
