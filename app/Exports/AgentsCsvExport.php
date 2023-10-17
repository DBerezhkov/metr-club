<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AgentsCsvExport implements FromView, WithStyles
{
    private $users;

    /**
     * @param $users
     */
    public function __construct($users)
    {
        $this->users = $users;
    }


    public function view(): View
    {
        return view('admin.users.export', ['users' => $this->users]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
    }
}
