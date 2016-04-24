<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class authJWT
{
    public function handle($request, Closure $next)
    {
        try {

            $user = JWTAuth::toUser($request->input('token'));

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error'=>'Token é Invalido']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error'=>'Token expirou']);
            }else{
                return response()->json(['error'=>'Algo esta errado!']);
            }
        }
        return $next($request);
    }
}