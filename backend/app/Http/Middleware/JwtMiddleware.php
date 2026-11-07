<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Solo intenta si hay header Authorization
            if (!$request->hasHeader('Authorization')) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Token requerido'
                ], 401);
            }

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Usuario no encontrado'
                ], 404);
            }

        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Token inválido',
                'error' => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}