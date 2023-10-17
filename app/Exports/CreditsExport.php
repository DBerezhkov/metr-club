<?php

namespace App\Exports;

use App\Models\CreditProgram;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CreditsExport implements  FromView, WithStyles
{

    private $credits;

    public function __construct($credits)
    {
        $this->credits = $credits;
    }


    public function view(): View
    {
        foreach ($this->credits as $credit){
            $credit->credit_program = CreditProgram::find($credit->type);
        }
        return view('admin.credit.export', ['credits' => $this->credits]);
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);

    }
}
