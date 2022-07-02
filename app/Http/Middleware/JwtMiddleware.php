<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $requestau
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
