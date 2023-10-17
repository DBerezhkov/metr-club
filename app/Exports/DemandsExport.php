<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DemandsExport implements  FromView, WithStyles
{

    private $demands;

    public function __construct($demands)
    {
        $this->demands = $demands;
    }


    public function view(): View
    {
        return view('admin.demand.export', ['demands' => $this->demands]);
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);

    }
}
