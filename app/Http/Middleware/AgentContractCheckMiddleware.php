<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentContractCheckMiddleware
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
        if(is_null(auth()->user()->agent_contract_type_id)) {
            return redirect()->route('profile.index');
        }
        return $next($request);
    }
}
