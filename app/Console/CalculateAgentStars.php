<?php

namespace App\Console;

use App\Models\Demand;
use App\Models\User;
use Illuminate\Support\Carbon;

class CalculateAgentStars
{
    public function __invoke() {
        $users = User::all();
        foreach ($users as $user) {
            $user_rating = collect(['rating' => 0, 'demands' => 0]);
            $demands_count = Demand::where('agent_id', $user->id)->whereBetween('created_at', [Carbon::now()->subDays(90), Carbon::now()])->count();
            if ($demands_count > 9) $user_rating->put('rating', 3);
            elseif ($demands_count > 4) $user_rating->put('rating', 2);
            elseif ($demands_count > 0) $user_rating->put('rating', 1);
            $user_rating->put('demands', $demands_count);
            $user->update(['rating' => $user_rating]);
        }
    }
}
