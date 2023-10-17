<?php

namespace App\Console\Commands;

use App\Models\Demand;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class StarsCalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stars:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate agent stars';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        $users->each(function ($user) {
            $user_rating = collect(['rating' => 0, 'demands' => 0]);
            $demands_count = Demand::where('agent_id', $user->id)->whereBetween('created_at', [Carbon::now()->subDays(90), Carbon::now()])->count();
            if ($demands_count > 9) $user_rating->put('rating', 3);
            elseif ($demands_count > 4) $user_rating->put('rating', 2);
            elseif ($demands_count > 0) $user_rating->put('rating', 1);
            else $user_rating->put('rating', 0);
            $user_rating->put('demands', $demands_count);
            $user->update(['rating' => $user_rating]);
        });
    }
}
