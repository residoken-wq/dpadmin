<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Phieuthu extends Model
{
    //
   	protected $table='DT_Phieu_Thu';
   	protected $primary='id';
   	protected $timestamp=true;
   	public function Form(){
   		return $this->belongsTo(Forms::class,"cid_form")->getResults();
   	}
   	public function User(){
   		return $this->belongsTo(Users::class,"cid_user")->getResults();
   	}
      public function totalprice($date){
         return $this->where(DB::raw("DATE(created_at)"),$date)->sum('price');
      }
        public  function getLN($m,$y){
         $t= $this->whereRaw("
               MONTH(created_at) = '{$m}' AND YEAR(created_at) = '{$y}'

            ")->sum("price");
         return (int)$t;
      }
}
