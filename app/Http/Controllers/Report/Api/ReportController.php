<?php

namespace App\Http\Controllers\Report\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\Api\MakeReportRequest;
use App\Models\Bank;
use App\Models\CreditProgram;
use App\Models\Demand;
use App\Models\Insurance;
use App\Models\Report;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function GetReports(){
        return Report::where('user_id', '=', Auth::id())->orderBy('id', 'desc')->get();
    }

    public function Search($q, $exeptions) {
        $exeptions =  array_map('intval', explode(',', $exeptions));
        $converter = array(
            'f' => 'а',	',' => 'б',	'd' => 'в',	'u' => 'г',	'l' => 'д',	't' => 'е',	'`' => 'ё',
            ';' => 'ж',	'p' => 'з',	'b' => 'и',	'q' => 'й',	'r' => 'к',	'k' => 'л',	'v' => 'м',
            'y' => 'н',	'j' => 'о',	'g' => 'п',	'h' => 'р',	'c' => 'с',	'n' => 'т',	'e' => 'у',
            'a' => 'ф',	'[' => 'х',	'w' => 'ц',	'x' => 'ч',	'i' => 'ш',	'o' => 'щ',	'm' => 'ь',
            's' => 'ы',	']' => 'ъ',	"'" => "э",	'.' => 'ю',	'z' => 'я',
            'F' => 'А',	'<' => 'Б',	'D' => 'В',	'U' => 'Г',	'L' => 'Д',	'T' => 'Е',	'~' => 'Ё',
            ':' => 'Ж',	'P' => 'З',	'B' => 'И',	'Q' => 'Й',	'R' => 'К',	'K' => 'Л',	'V' => 'М',
            'Y' => 'Н',	'J' => 'О',	'G' => 'П',	'H' => 'Р',	'C' => 'С',	'N' => 'Т',	'E' => 'У',
            'A' => 'Ф',	'{' => 'Х',	'W' => 'Ц',	'X' => 'Ч',	'I' => 'Ш',	'O' => 'Щ',	'M' => 'Ь',
            'S' => 'Ы',	'}' => 'Ъ',	'"' => 'Э',	'>' => 'Ю',	'Z' => 'Я',
        );
        $convertedString = strtr($q, $converter);
        $demands = Demand::orderBy('id', 'asc')
            ->where('agent_id', '=', Auth::id())
            ->where(function ($query) use ($convertedString, $q) {
                $query->where('name', 'LIKE', "%".$q."%")
                      ->orwhere('name', 'LIKE', "%".$convertedString."%" );
            })
            ->whereNotIn('id', $exeptions)
            ->limit(4)
            ->get();

        foreach ($demands as $demand) {
            $demand->banks_list = json_decode($demand->banks_list);
        }
        return $demands;
    }

    public function GetBanks() {
        return Bank::all();
    }

    public function GetCreditPrograms() {
        return CreditProgram::all();
    }

    public function GetInsurances() {
        return Insurance::all();
    }

    public function MakeReport(MakeReportRequest $request) {
        $report = new Report();
        $report->user_id = Auth::id();
        $report->mortgage_data = collect($request->mortgage_report);
        $report->insurance_data = collect($request->insurance_report);
        $report->status = 0;
        $summ = 0;
        foreach($request->mortgage_report as $mortgage) {
            $summ += $mortgage['summ'];
        }
        foreach($request->insurance_report as $insurance) {
            $summ += $insurance['summ'];
        }
        $report->summ = $summ;
        //$report->period = Carbon::createFromFormat('Y-m-d H:i:s', now())->format('Y M');
        $str = ucfirst(Carbon::parse(Carbon::now()->subMonths(2))->isoFormat('MMMM Y'));
        $report->period = mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($str, 'utf-8'), 1, mb_strlen($str)-1, 'utf-8');
        $report->save();
        return response()->json('Отчёт успешно создан!');
    }

}
