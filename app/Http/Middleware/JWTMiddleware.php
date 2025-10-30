<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Contracts\Providers\JWT;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->hasHeader('Authorization')) {
            return response()->json([
                'error' => 'Token not provided'
            ], 401);

        }
        try{
            JWTAuth::parseToken()->authenticate();
        }catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'messages' => 'Token not valid'
            ], 401);
        }

        return $next($request); 
    }
}
