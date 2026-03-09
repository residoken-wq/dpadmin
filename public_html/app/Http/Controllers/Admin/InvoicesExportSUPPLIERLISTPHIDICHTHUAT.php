<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Model\Phieuthu as DTPhieuthu;
use App\Model\OrderSupplier as DTOrderSupplier;
use App\Model\Report as DTReport;
use App\Model\Forms as DTForms;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoicesExportSUPPLIERLISTPHIDICHTHUAT implements FromView, WithCustomCsvSettings, WithEvents, ShouldAutoSize
{
    protected $id = 0;
    protected $sql = "";
    protected $search = [];
    protected $dataset = [];
    protected $name_supplier = "";

    public function __construct($sql, $id, $search, $name_supplier, $dataset = [])
    {
        $this->id = $id;
        $this->sql = $sql;
        $this->search = $search;
        $this->dataset = $dataset;
        $this->name_supplier = $name_supplier;
    }

    public function view(): View
    {

        $View = [];


        $View['data_list'] = $this->dataset;


        $View['search'] = $this->search;
        $View['name_supplier'] = $this->name_supplier;


        return view("admin.excel.excelsupplierlistphidichthuat", $View);


    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $to = $event->sheet->getDelegate()->getHighestRowAndColumn();
                $event->sheet->styleCells(
                    'A5:E' . ($to['row'] - 1),
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
                $event->sheet->styleCells(
                    'F5:F' . $to['row'],
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

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8'
        ];
    }
}

?>
