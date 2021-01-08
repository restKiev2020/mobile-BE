<?php

namespace App\Http\Middleware;

use Closure;

class BlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::user()->blocked) {
            return response()->json(\Lang::get('auth.failed.blocked'));
        }

        return $next($request);
    }
}
