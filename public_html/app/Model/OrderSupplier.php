<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderSupplier extends Model
{
    //
    protected $table = 'DT_Order_Supplier';
    protected $primary = 'id';
    protected $timestamp = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cid_supplier',
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
        'approved_2',
        'nguoinhantien',
        'ghichu',
        'approved_cong_chung',
        'approved_dau_cong_ty',
        'approved_sao_y',
        'approved_ngoai_vu',
        'approved_phi_van_chuyen',
        'approved_phi_dich_thuat',
        'approved_vat',
    ];

    protected $guarded = [
        'id'
    ];

    public function Forms()
    {
        return $this->belongsTo(Forms::class, "cid_form")->getResults();
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, "cid_supplier")->getResults();
    }

    public function nhacungcap()
    {
        return $this->belongsTo(Supplier::class, "cid_supplier");
    }

    public function phieudichthuat()
    {
        return $this->belongsTo(Forms::class, "cid_form");
    }

    public function getNgayTraHoSoAttribute()
    {
        $phieudich = $this->phieudichthuat;
        $result = '';
        if ($phieudich) {
            $result = \Carbon\Carbon::parse($phieudich->ngaytrahoso . ' ' . $phieudich->giotrahoso);
        }
        return $result;
    }

    public function getTongcongnoAttribute()
    {
        $result = 0;
        if ($this->approved != "2" && $this->approved_2 != "2") {

            if ($this->approved_cong_chung == "1") {
                $result = $result + $this->congchung;
            }
            if ($this->approved_dau_cong_ty == "1") {
                $result = $result + $this->daucongty;
            }
            if ($this->approved_sao_y == "1") {
                $result = $result + $this->saoy;
            }
            if ($this->approved_ngoai_vu == "1") {
                $result = $result + $this->ngoaivu;
            }
            if ($this->approved_phi_van_chuyen == "1") {
                $result = $result + $this->phivanchuyen;
            }
            if ($this->approved_vat == "1") {
                $result = $result + $this->vat;
            }
            if ($this->tamung) {
                $result = $result - $this->tamung;
            }
//            dd($result, $this);
        }

        return $result;
    }
}
