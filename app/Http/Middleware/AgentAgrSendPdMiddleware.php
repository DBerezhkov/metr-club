<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentAgrSendPdMiddleware
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
        if(auth()->user()->agr_send_pd_is_read == 0){
            return redirect()->route('profile.index');
        }
        return $next($request);
    }
}
