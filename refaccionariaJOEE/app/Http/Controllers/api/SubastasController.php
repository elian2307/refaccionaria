<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\subasta;

class SubastasController extends Controller
{
    public function index()
    {
        $subastas = subasta::with('img_subastas')->get();

        return response([
            'success' => true,
            'message' => $subastas->isEmpty() ? 'No subastas found' : 'Subastas retrieved successfully',
            'subastas' => $subastas
        ], 200);
    }

    public function misSubastas()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        if (!in_array($user->rol, ['vendedor', 'admin'])) {
            return response([
                'success' => false,
                'msg' => 'No tienes permiso para ver subastas publicadas'
            ], 403);
        }

        $query = subasta::with('img_subastas')
        ->withCount('ofertas')
        ->orderBy('created_at', 'desc');

        if ($user->rol !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $subastas = $query->get();

        return response([
            'success' => true,
            'subastas' => $subastas
        ], 200);
    }

    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating subasta (API usually does not need this)'
        ], 200);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        if (!in_array($user->rol, ['vendedor', 'admin'])) {
            return response([
                'success' => false,
                'msg' => 'Solo los vendedores pueden crear subastas'
            ], 403);
        }

        $validateData = $request->validate([
            'marca_vehiculo' => 'required|string|max:255',
            'modelo_vehiculo' => 'required|string|max:255',
            'anio_vehiculo' => 'required|integer',
            'nombre_refaccion' => 'required|string|max:255',
            'descripcion_problema' => 'required|string',
            'urgencia' => 'required|in:baja,media,alta',
            'estado' => 'required|string|max:50',
            'fecha_expiracion' => 'required|date',
        ]);

        $validateData['user_id'] = $user->id;

        $subasta = subasta::create($validateData);

        $user->agregarPuntosGamificacion(25);

        return response([
            'success' => true,
            'msg' => 'Subasta creada correctamente',
            'subasta' => $subasta,
            'gamificacion' => $user->resumenGamificacion()
        ], 201);
    }

    public function show(string $slug)
    {
        $subasta = subasta::with('img_subastas')->where('slug', $slug)->first();

        if (!$subasta) {
            return response([
                'success' => false,
                'msg' => 'Subasta not found'
            ], 404);
        }

        return response([
            'success' => true,
            'subasta' => $subasta
        ], 200);
    }

    public function edit(string $id)
    {
        $subasta = subasta::find($id);

        if (!$subasta) {
            return response([
                'success' => false,
                'msg' => 'Subasta not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing subasta (API usually does not need this)',
            'subasta' => $subasta
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        if (!in_array($user->rol, ['vendedor', 'admin'])) {
            return response([
                'success' => false,
                'msg' => 'Solo los vendedores pueden editar subastas'
            ], 403);
        }

        $subasta = subasta::find($id);

        if (!$subasta) {
            return response([
                'success' => false,
                'msg' => 'Subasta not found'
            ], 404);
        }

        if ($user->rol !== 'admin' && $subasta->user_id !== $user->id) {
            return response([
                'success' => false,
                'msg' => 'No puedes editar una subasta que no es tuya'
            ], 403);
        }

        $validateData = $request->validate([
            'marca_vehiculo' => 'sometimes|required|string|max:255',
            'modelo_vehiculo' => 'sometimes|required|string|max:255',
            'anio_vehiculo' => 'sometimes|required|integer',
            'nombre_refaccion' => 'sometimes|required|string|max:255',
            'descripcion_problema' => 'sometimes|required|string',
            'urgencia' => 'sometimes|required|in:baja,media,alta',
            'estado' => 'sometimes|required|string|max:50',
            'fecha_expiracion' => 'sometimes|required|date',
        ]);

        $subasta->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Subasta actualizada correctamente',
            'subasta' => $subasta
        ], 200);
    }

    public function destroy(string $id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        if (!in_array($user->rol, ['vendedor', 'admin'])) {
            return response([
                'success' => false,
                'msg' => 'Solo los vendedores pueden eliminar subastas'
            ], 403);
        }

        $subasta = subasta::find($id);

        if (!$subasta) {
            return response([
                'success' => false,
                'msg' => 'Subasta not found'
            ], 404);
        }

        if ($user->rol !== 'admin' && $subasta->user_id !== $user->id) {
            return response([
                'success' => false,
                'msg' => 'No puedes eliminar una subasta que no es tuya'
            ], 403);
        }

        $subasta->delete();

        return response([
            'success' => true,
            'msg' => 'Subasta eliminada correctamente'
        ], 200);
    }
}