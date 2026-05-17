<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

class GamificacionController extends Controller
{
    public function show()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'gamificacion' => $user->resumenGamificacion()
        ], 200);
    }
}