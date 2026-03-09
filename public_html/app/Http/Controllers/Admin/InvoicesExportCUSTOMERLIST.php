<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithStyles;
use App\Model\Phieuthu as DTPhieuthu;
use App\Model\OrderSupplier as DTOrderSupplier;
use App\Model\Report as DTReport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Model\Forms as DTForms;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use DB;

class InvoicesExportCUSTOMERLIST implements FromView, WithCustomCsvSettings, WithEvents, ShouldAutoSize
{
    protected $sql = "";
    protected $search = [];
    protected $dataset = [];
    protected $name_customer = '';

    public function __construct($sql, $search, $name_customer, $dataset=[])
    {
        $this->sql = $sql;
        $this->search = $search;
        $this->dataset = $dataset;
        $this->name_customer = $name_customer;

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $to = $event->sheet->getDelegate()->getHighestRowAndColumn();
                $event->sheet->styleCells(
                    'A1:H3',
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );
                $event->sheet->styleCells(
                    'A4:H' . ($to['row'] - 1),
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
                    'A' . $to['row'] . ':E' . $to['row'],
                    [
                        //Set border Style
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],

                        ],
                    ]
                );
                $event->sheet->styleCells(
                    'F' . $to['row'] . ':H' . $to['row'],
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
//    public function styles(Worksheet $sheet)
//    {
////        return [
////            // Style the first row as bold text.
////            1 => ['font' => ['bold' => true]],
////
////            // Styling a specific cell by coordinate.
////            'B2' => ['font' => ['italic' => true]],
////
////            // Styling an entire column.
////            'C' => ['font' => ['size' => 16]],
////        ];
//
//        $sheet->getStyle('A4:H25')->applyFromArray([
//            'borders' => [
//                'allBorders' => [
//                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                    'color' => ['argb' => '000000'],
//                ],
//            ],
//        ]);
//    }

    public function view(): View
    {

        $View = [];


        $View['data_list'] = $this->dataset;

        $View['search'] = $this->search;
        $View['name_customer'] = $this->name_customer;

        return view("admin.excel.excelcustomerlist", $View);


    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8'
        ];
    }
}

?>
