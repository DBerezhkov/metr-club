<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserActivityMiddleware
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
        $user = $request->user();
        $this->update($user, now());
        return $next($request);
    }
    protected function update(User $user, Carbon $active_at): void {
        $user->update(compact('active_at'));
    }
}
