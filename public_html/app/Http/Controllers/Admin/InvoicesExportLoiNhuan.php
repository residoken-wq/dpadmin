<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Model\Phieuthu as DTPhieuthu;
use App\Model\Report as DTReport;
use DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoicesExportLoiNhuan implements FromView, WithEvents, ShouldAutoSize
{
    protected $sql=" id > 0 ";
    protected $filter='1';
 /*   public function init($this->sql){
      $this->sql=$this->sql;
    }*/
    public function __construct($sql,$filter){
    	$this->sql=$sql;
    	$this->filter=$filter;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $to = $event->sheet->getDelegate()->getHighestRowAndColumn();
                $event->sheet->styleCells(
                    'A1:E'.($to['row']),
                    [
                        //Set border Style
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],

                        ],
                    ]
                );
            },
        ];
    }

    public function view(): View
    {


        $this->View=[];
        $this->View['search']=['filter'=>$this->filter];

         if($this->filter=='1'){
               $this->View['data_list']=DTReport::whereRaw(DB::raw($this->sql))->orderBy("my_date","DESC")->get();
        }
        if($this->filter=='2'){
             $this->View['data_list']=DTReport::select("*",DB::raw("MONTH(my_date) as my_month"),DB::raw("YEAR(created_at) AS my_year"))->whereRaw(DB::raw($this->sql))->
                                      groupBy(DB::raw("MONTH(my_date)"))->orderBy("my_date","DESC")->get();
                                      ;
        }
        if($this->filter=='3'){
               $this->View['data_list']=DTReport::select("*",DB::raw("YEAR(my_date) as my_year"))->whereRaw(DB::raw($this->sql))->
                                      groupBy(DB::raw("YEAR(my_date)"))->orderBy("my_date","DESC")->get()
                                      ;
        }
         return view("admin.excel.excelloinhuan",$this->View);



    }
}
