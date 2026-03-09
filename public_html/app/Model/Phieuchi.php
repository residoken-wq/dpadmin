<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Phieuchi extends Model
{
    //
    protected $table = 'DT_Phieu_Chi';
    protected $primary = 'id';
    protected $timestamp = true;

    public function Form()
    {
        return $this->belongsTo(Forms::class, "cid_form")->getResults();
    }

    public function User()
    {
        return $this->belongsTo(Users::class, "cid_user")->getResults();
    }

    public function getLN($m, $y)
    {
        $t = $this->whereRaw("
               MONTH(created_at) = '{$m}' AND YEAR(created_at) = '{$y}'

            ")->sum("price");
        return (int)$t;
    }

    public function scopeOfFlag($query, $value){
        $query->where('flag', $value);
    }
}
