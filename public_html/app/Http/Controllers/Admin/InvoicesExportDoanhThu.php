<?php
namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Model\Phieuthu as DTPhieuthu;
use DB;
use Maatwebsite\Excel\Concerns\WithEvents;

class InvoicesExportDoanhThu implements FromCollection
{
    protected $sql=" id > 0 ";
    protected $filter='1';
 /*   public function init($sql){
      $this->sql=$sql;
    }*/
    public function __construct($sql,$filter){
    	$this->sql=$sql;
    	$this->filter=$filter;
    }
    public function collection()
    {


         if($this->filter=='1'){
           return 		DTPhieuthu::select(DB::raw("DATE(created_at)"),DB::raw("SUM(price) as total"))->whereRaw(DB::raw($this->sql))->
                                  groupBy(DB::raw("DATE(created_at)"))->orderBy("id","DESC")->get();
                                  ;
        }
        if($this->filter=='2'){
            return DTPhieuthu::select(DB::raw("MONTH(created_at)"),DB::raw("YEAR(created_at)"),DB::raw("SUM(price) as total"))->whereRaw(DB::raw($this->sql))->
                                  groupBy(DB::raw("MONTH(created_at)"))->orderBy("id","DESC")->get();
                                  ;
        }
        if($this->filter=='3'){
            return DTPhieuthu::select(DB::raw("YEAR(created_at)"),DB::raw("SUM(price) as total"))->whereRaw(DB::raw($this->sql))->
                                  groupBy(DB::raw("YEAR(created_at)"))->orderBy("id","DESC")->get();
                                  ;
        }
    }
}
