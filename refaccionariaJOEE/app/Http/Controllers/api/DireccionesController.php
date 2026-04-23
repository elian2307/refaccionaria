<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\direccion;
use App\Models\User;

class DireccionesController extends Controller
{
    public function index()
    {
        $direcciones = direccion::all();

        return response([
            'success' => true,
            'message' => $direcciones->isEmpty() ? 'No addresses found' : 'Addresses retrieved successfully',
            'direcciones' => $direcciones
        ], 200);
    }

    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating address (API usually does not need this)'
        ], 200);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'calle' => 'required|string|max:255',
            'numero_exterior' => 'required|string|max:50',
            'numero_interior' => 'nullable|string|max:50',
            'colonia' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
        ]);

        $direccion = direccion::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Address created successfully',
            'direccion' => $direccion
        ], 201);
    }

    public function show(string $id)
    {
        $direccion = direccion::find($id);

        if (!$direccion) {
            return response([
                'success' => false,
                'msg' => 'Address not found'
            ], 404);
        }

        return response([
            'success' => true,
            'direccion' => $direccion
        ], 200);
    }

    public function edit(string $id)
    {
        $direccion = direccion::find($id);

        if (!$direccion) {
            return response([
                'success' => false,
                'msg' => 'Address not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing address (API usually does not need this)',
            'direccion' => $direccion
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $direccion = direccion::find($id);

        if (!$direccion) {
            return response([
                'success' => false,
                'msg' => 'Address not found'
            ], 404);
        }

        $validateData = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'calle' => 'sometimes|required|string|max:255',
            'numero_exterior' => 'sometimes|required|string|max:50',
            'numero_interior' => 'nullable|string|max:50',
            'colonia' => 'sometimes|required|string|max:255',
            'municipio' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|string|max:255',
            'codigo_postal' => 'sometimes|required|string|max:20',
        ]);

        $direccion->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Address updated successfully',
            'direccion' => $direccion
        ], 200);
    }

    public function destroy(string $id)
    {
        $direccion = direccion::find($id);

        if (!$direccion) {
            return response([
                'success' => false,
                'msg' => 'Address not found'
            ], 404);
        }

        $direccion->delete();

        return response([
            'success' => true,
            'msg' => 'Address deleted successfully'
        ], 200);
    }
}