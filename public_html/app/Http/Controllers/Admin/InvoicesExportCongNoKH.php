<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Model\Phieuthu as DTPhieuthu;
use App\Model\OrderCustomer as DTOrderCustomer;
use App\Model\Report as DTReport;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

use DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoicesExportCongNoKH implements FromView, WithCustomCsvSettings, WithEvents, ShouldAutoSize
{
    protected $sql = " id > 0 ";
    protected $dataset = [];
    protected $sort = [];

    /*   public function init($this->sql){
         $this->sql=$this->sql;
       }*/
    public function __construct($sql, $sort, $dataset = [])
    {
        $this->sql = $sql;
        $this->dataset = $dataset;
        $this->sort = $sort;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $to = $event->sheet->getDelegate()->getHighestRowAndColumn();
                $event->sheet->styleCells(
                    'A1:C' . ($to['row']),
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

        // ibxml_use_internal_errors(false);


        $View = [];


        $View['data_list'] = collect($this->dataset);


        return view("admin.excel.excellcongnokh", $View);


    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8'

        ];
    }
}

?>
