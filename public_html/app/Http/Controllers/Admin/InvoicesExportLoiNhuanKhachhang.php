<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Model\OrderCustomer as OrderCustomer;
use App\Model\Report as DTReport;
use DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoicesExportLoiNhuanKhachhang implements FromView, WithEvents, ShouldAutoSize
{
    protected $sql = " id > 0 ";
    protected $filter = '1';
    protected $id_customer;

    /*   public function init($this->sql){
         $this->sql=$this->sql;
       }*/
    public function __construct($sql, $filter, $id_customer)
    {
        $this->sql = $sql;
        $this->filter = $filter;
        $this->id_customer = $id_customer;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $to = $event->sheet->getDelegate()->getHighestRowAndColumn();
                $event->sheet->styleCells(
                    'A1:D' . ($to['row']),
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


        $this->View = [];
        $this->View['search'] = $search = ['filter' => $this->filter];

        $this->View['id_customer'] = $this->id_customer;

        if ($search['filter'] == '1') {


            $this->View['data_list'] = DTReport::whereRaw(DB::raw($this->sql))->orderBy("my_date", "DESC")->get();
        }
        if ($search['filter'] == '2') {
            $this->View['data_list'] = $t = DTReport::select("*", DB::raw("MONTH(my_date) as my_month"), DB::raw("YEAR(my_date) as my_year"))->whereRaw(DB::raw($this->sql))->
            groupBy(DB::raw("MONTH(my_date),YEAR(created_at)"))
                ->orderBy("my_date", "DESC")->get();;


        }
        if ($search['filter'] == '3') {
            $this->View['data_list'] = DTReport::select("*", DB::raw("YEAR(my_date) as my_year"))->whereRaw(DB::raw($this->sql))->
            groupBy(DB::raw("YEAR(my_date)"))->orderBy("my_date", "DESC")->get();;
        }


        return view("admin.excel.excelloinhuankhachhang", $this->View);


    }
}
