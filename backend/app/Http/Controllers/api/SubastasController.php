<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\subasta;
use App\Models\User;

class SubastasController extends Controller
{
    public function index()
    {
        $subastas = subasta::all();

        return response([
            'success' => true,
            'message' => $subastas->isEmpty() ? 'No subastas found' : 'Subastas retrieved successfully',
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
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'marca_vehiculo' => 'required|string|max:255',
            'modelo_vehiculo' => 'required|string|max:255',
            'anio_vehiculo' => 'required|integer',
            'nombre_refaccion' => 'required|string|max:255',
            'descripcion_problema' => 'required|string',
            'urgencia' => 'required|in:baja,media,alta',
            'estado' => 'required|string|max:50',
            'fecha_expiracion' => 'required|date',
        ]);

        $subasta = subasta::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Subasta created successfully',
            'subasta' => $subasta
        ], 201);
    }

    public function show(string $id)
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
        $subasta = subasta::find($id);

        if (!$subasta) {
            return response([
                'success' => false,
                'msg' => 'Subasta not found'
            ], 404);
        }

        $validateData = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
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
            'msg' => 'Subasta updated successfully',
            'subasta' => $subasta
        ], 200);
    }

    public function destroy(string $id)
    {
        $subasta = subasta::find($id);

        if (!$subasta) {
            return response([
                'success' => false,
                'msg' => 'Subasta not found'
            ], 404);
        }

        $subasta->delete();

        return response([
            'success' => true,
            'msg' => 'Subasta deleted successfully'
        ], 200);
    }
}