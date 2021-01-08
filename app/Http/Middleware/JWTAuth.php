<?php

namespace App\Http\Middleware;

use App\Http\Services\JWTService;
use Closure;

class JWTAuth
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
        $token = $request->get('token', null);

        if(!$token) {
            \Log::debug('TOKEN FAILED');
            return response()->json('No token provided', 400);
        }

        $verified = JWTService::verify($token);

        if(!$verified) {
            return response()->json('Forbidden', 403);
        }

        unset($request['token']);

        return $next($request);
    }
}
