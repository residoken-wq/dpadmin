<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Model\Phieuthu as DTPhieuthu;
use App\Model\OrderSupplier as DTOrderSupplier;
use App\Model\Report as DTReport;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoicesExportCongNoNCC implements FromView, WithCustomCsvSettings, WithEvents, ShouldAutoSize
{
    protected $dataset = [];

    public function __construct($dataset = [])
    {
        $this->dataset = $dataset;
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
//        $View['data_list'] = DTOrderSupplier::select("id", "cid_form", "cid_supplier", "created_at", DB::raw(" sum({$this->mytong}-tamung) as total"))->whereRaw(DB::raw($this->sql))->groupBy("cid_supplier")->orderBy($this->sort[0], $this->sort[1])->get();
        $View['data_list'] = $this->dataset;
        return view("admin.excel.excellcongnoncc", $View);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8'
        ];
    }
}

?>
