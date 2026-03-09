<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    //
    protected $table = 'DT_Order_Customer';
    protected $primary = 'id';
    protected $timestamp = true;

    protected $fillable = [
          'cid_customer',
          'cid_form',
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
    ];

    public function Forms()
    {
        return $this->belongsTo(Forms::class, "cid_form")->getResults();
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class, "cid_customer")->getResults();
    }

    public function phieudichthuat(){
        return $this->belongsTo(Forms::class, "cid_form");
    }

    public function phieuthu()
    {
        return $this->belongsTo(Phieuthu::class, "cid_form");
    }
    public function phieuchi()
    {
        return $this->hasMany(Phieuchi::class, "cid_form");
    }

    public function getNgayTraHoSoAttribute(){
        $phieudich = $this->phieudichthuat;
        $result = '';
        if($phieudich){
            $result = \Carbon\Carbon::parse($phieudich->ngaytrahoso.' '.$phieudich->giotrahoso);
        }
        return $result;
    }
}
