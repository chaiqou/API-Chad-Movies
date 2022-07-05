<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $requestau
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try
		{
			$user = JWTAuth::parseToken()->authenticate();
		}
		catch (\Exception $exception)
		{
			if ($exception instanceof TokenExpiredException)
			{
				$newToken = JWTAuth::parseToken()->refresh();
				return response()->json(['accesss' => false, 'token' => $newToken, 'status' => 'expired'], 200);
			}
			elseif ($exception instanceof TokenInvalidException)
			{
				return response()->json(['accesss' => false, 'message' => 'Token Invalid'], 401);
			}
			else
			{
				return response()->json(['accesss' => false, 'message' => 'Token not found'], 401);
			}
		}
		return $next($request);
	}
}
