<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDemandOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $employees = $user->employees()->withTrashed()->get();

        if ($request->route('demand') !== null) {
            if ((Auth::id() != $request->route('demand')->agent_id) && (!(Auth::user()->can('processing')))
                && (!$employees->contains('id',  $request->route('demand')->agent_id) || !$user->hasRole('supervisor'))) {
                abort(403);
            }
        }

        return $next($request);

    }
}
