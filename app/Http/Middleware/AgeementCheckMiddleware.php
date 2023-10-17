<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgeementCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!(auth()->user()->agreement)) {
            echo 'Yabadabadooo';
            return redirect()->route('agree');
        }

        return $next($request);
    }
}
