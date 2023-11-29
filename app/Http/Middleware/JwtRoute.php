<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtRoute extends BaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        }catch (\Exception $e) {
            if($e instanceof TokenInvalidException){
                return response()->json(['message'=>"Token inválido"]);
            } else if($e instanceof TokenExpiredException) {
                return response()->json(['message'=>"Token expirado"]);
            } else {
                return response()->json(['message'=>"Token não informado"]);
            }
        }
        return $next($request);
    }
}
