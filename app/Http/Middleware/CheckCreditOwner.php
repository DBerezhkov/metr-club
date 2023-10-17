<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCreditOwner
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
        if ($request->route('credit') !== null) {
            if (!Auth::user()->hasRole('admin') && (Auth::id() != $request->route('credit')->agent_id) && (!(Auth::user()->can('processing')))
                && (!$employees->contains('id',  $request->route('credit')->agent_id) || !$user->hasRole('supervisor'))) {
                abort(403);
            }
        }

        return $next($request);

    }
}
