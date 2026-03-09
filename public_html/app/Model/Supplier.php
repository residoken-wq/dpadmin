<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $table = 'DT_Supplier';
    protected $primary = 'id';
    protected $timestamp = true;

    public function Form()
    {
        return $this->hasMany(Forms::class, "cid_supplier")->getResults();
    }

    public function hoadon()
    {
        return $this->hasMany(OrderSupplier::class, "cid_supplier");
    }

    public function getTotalCongNoAttribute(){
        $result = 0;
        $listHoadon = $this->hoadon;
        foreach($listHoadon as $item){
            $result += $item->tongcongno;
        }
        return $result;
    }
}
