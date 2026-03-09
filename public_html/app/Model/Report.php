<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Report extends Model
{
    //
   	protected $table='DT_Report';
   	protected $primary='id';
   	protected $timestamp=false;
   	public function TongChi($filter){
   //   echo Phieuchi::select(DB::raw("sum(price) as total"))->whereRaw(" DATE(created_at) ='".$current_date."'")->toSql();
      if($filter=='1'){
        return Phieuchi::select(DB::raw("sum(price) as total"))->whereRaw(" DATE(created_at) ='".$this->my_date."'")->first();
      }
      if($filter=='2'){
       
          return Phieuchi::select(DB::raw("sum(price) as total"))->whereRaw("YEAR(created_at) ='".$this->my_year."' AND  MONTH(created_at) ='".$this->my_month."'")->first();
      }
      if($filter=='3'){
        return Phieuchi::select(DB::raw("sum(price) as total"))->whereRaw(" YEAR(created_at) ='".$this->my_year."'")->first();
      }
   		
   	}
   	public function TongThu($filter){
   		

      if($filter=='1'){
     return Phieuthu::select(DB::raw("sum(price) as total"))->whereRaw(" DATE(created_at) ='".$this->my_date."'")->first();
      }
      if($filter=='2'){
        
        
          return Phieuthu::select(DB::raw("sum(price) as total"))->whereRaw("YEAR(created_at) ='".$this->my_year."' AND  MONTH(created_at) ='".$this->my_month."'")->first();
      }
      if($filter=='3'){
        return Phieuthu::select(DB::raw("sum(price) as total"))->whereRaw(" YEAR(created_at) ='".$this->my_year."'")->first();
      }
   	}
    public function TongPhieuSupplier($filter){
      

      if($filter=='1'){
     return OrderSupplier::select(DB::raw("sum(tong) as total"))->whereRaw(" DATE(created_at) ='".$this->my_date."'")->first();
      }
      if($filter=='2'){
        
        
          return OrderSupplier::select(DB::raw("sum(tong) as total"))
                ->whereRaw(" YEAR(created_at) = '".$this->my_year."' AND MONTH(created_at) ='".$this->my_month."'")
             
                ->first();
      }
      if($filter=='3'){
        return OrderSupplier::select(DB::raw("sum(tong) as total"))->whereRaw(" YEAR(created_at) ='".$this->my_year."'")->first();
      }
    }
     public function TongPhieuCustomer($filter){
      

      if($filter=='1'){
     return OrderCustomer::select(DB::raw("sum(tong) as total"))
            ->whereRaw(" DATE(created_at) ='".$this->my_date."'")->first();
      }
      if($filter=='2'){
         
          
          return OrderCustomer::select(DB::raw("sum(tong) as total"))
              ->whereRaw(" YEAR(created_at) = '".$this->my_year."' AND  MONTH(created_at) ='".$this->my_month."'")
            
              ->first();
      }
      if($filter=='3'){
        return OrderCustomer::select(DB::raw("sum(tong) as total"))->whereRaw(" YEAR(created_at) ='".$this->my_year."'")->first();
      }

    } 


    public function KH_TongThu($filter,$id_customer){
      
      if($filter=='1'){
        return OrderCustomer::select(DB::raw(" sum(tong) AS tong, SUM(tamung) as tamung ,sum(tong-tamung) as total"))->whereRaw(" cid_customer={$id_customer} AND  DATE(created_at) ='".$this->my_date."'")->first();
      }
      if($filter=='2'){
       
          return OrderCustomer::select(DB::raw(" sum(tong) AS tong, SUM(tamung) as tamung ,sum(tong-tamung) as total"))->whereRaw("cid_customer={$id_customer} AND YEAR(created_at) ='".$this->my_year."' AND  MONTH(created_at) ='".$this->my_month."'")->first();
      }
      if($filter=='3'){
        return OrderCustomer::select(DB::raw(" sum(tong) AS tong, SUM(tamung) as tamung ,sum(tong-tamung) as total"))->whereRaw("cid_customer={$id_customer} AND YEAR(created_at) ='".$this->my_year."'")->first();
      }
      
    }

   

}
