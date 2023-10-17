<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Demand;
use App\Models\User;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index() {
        $users = User::orderBy('id', 'asc')->where('agreement', '=', '1')->get()->count();
        $usersactive = User::select('*')
            ->whereMonth('active_at', Carbon::now()->month)
            ->get()
            ->count();
        $usersall = User::orderBy('id', 'asc')->get()->count();
        $demands = Demand::select('*')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->get()
                ->count();
        $demands_today = Demand::select('*')
                ->whereDate('created_at', Carbon::today())
                ->withoutTrashed()
                ->get()
                ->count();
        $demands_yesterday = Demand::select('*')
                ->whereDate('created_at', Carbon::yesterday())
                ->withoutTrashed()
                ->get()
                ->count();

        $dateStart = Carbon::now()->startOfYear();
        $dateEnd = Carbon::now();
        if (Carbon::now()->quarter > 1) {
            $dateEnd = Carbon::now()->subMonths(3)->endOfQuarter();
            $banks_stat[] = $this->calculateQuarterStat(Carbon::now()->startOfQuarter(), Carbon::now());
            $banks_stat[] = $this->calculateQuarterStat($dateStart, $dateEnd);
        }
        else {
            $banks_stat[] = $this->calculateQuarterStat($dateStart, $dateEnd);
        }

        $year_stat = $this->calculateYearStat();

        $count_registration_today = User::query()->whereDate('created_at', Carbon::today())->count();
        $count_registration_yesterday = User::query()->whereDate('created_at', Carbon::yesterday())->count();

        return view('admin.home.index', [
            'users' => $users,
            'usersall' => $usersall,
            'usersactive' => $usersactive,
            'demands' => $demands,
            'demands_today' => $demands_today,
            'demands_yesterday' => $demands_yesterday,
            'banks_stat' => $banks_stat,
            'year_stat' => $year_stat,
            'quarter' => Carbon::now()->quarter,
            'count_registration_today' => $count_registration_today,
            'count_registration_yesterday' => $count_registration_yesterday,
        ]);
    }

    public function calculateQuarterStat($dateStart, $dateEnd) {
        $banks_list_all = [];
        $banks_stat = [];
        $banks = Bank::select('id', 'name')->get()->toArray();
        $demands_for_charts = Demand::select('banks_list')
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->get()
            ->toArray();

        foreach($demands_for_charts as $demand) {
            $banks_list_all = array_merge($banks_list_all, json_decode($demand['banks_list']));
        }
        $banks_list_all = array_count_values($banks_list_all);

        foreach ($banks as $bank => $val) {
            $banks_stat[$val['id']] = ['name' => $val['name'], 'count' => 0];
        }

        foreach($banks_list_all as $key => $value) {
            $banks_stat[$key]['count'] = $value;
        }
        return $banks_stat;
    }

    public function calculateYearStat($year = 2022) {
        $demands = Demand::orderBy('created_at', 'asc')->whereBetween('created_at', [Carbon::create($year)->startOfYear(), Carbon::create($year)->endOfYear()])
            ->get()
            ->groupBy(function ($demands) {
              return Carbon::parse($demands->created_at)->format('M');
            })
            ->toArray();

        $count = ['Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0,
        ];

        $summ = ['Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0,
        ];

        foreach ($demands as $month=>$dem) {
            foreach ($dem as $d) {
                $count[$month] += count(json_decode($d['banks_list']));
                $summ[$month] += round(($d['credit_summ'] * 0.000001), 3);
            }

        }
        return [$count, $summ];
    }
}
