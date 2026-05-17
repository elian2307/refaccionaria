<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\oferta;
use App\Models\User;

class OfertasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ofertas = oferta::all();

        return response([
            'success' => true,
            'message' => $ofertas->isEmpty() ? 'No ofertas found' : 'Ofertas retrieved successfully',
            'ofertas' => $ofertas
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating oferta (API usually does not need this)'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'subasta_id' => 'required|exists:subastas,id',
            'proveedor_id' => 'required|exists:users,id',
            'precio_ofertado' => 'required|numeric',
            'dias_entrega' => 'required|integer',
            'condicion_pieza' => 'required|string|max:255',
            'meses_garantia' => 'nullable|integer',
            'es_aceptada' => 'nullable|boolean',
            'fecha_oferta' => 'required|date',
        ]);

        $oferta = oferta::create($validateData);

        $user = User::find($validateData['proveedor_id']);

        if ($user) {
            $user->agregarPuntosGamificacion(15);
        }

        return response([
            'success' => true,
            'msg' => 'Oferta created successfully',
            'oferta' => $oferta,
            'gamificacion' => $user ? $user->resumenGamificacion() : null
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $oferta = oferta::find($id);

        if (!$oferta) {
            return response([
                'success' => false,
                'msg' => 'Oferta not found'
            ], 404);
        }

        return response([
            'success' => true,
            'oferta' => $oferta
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $oferta = oferta::find($id);

        if (!$oferta) {
            return response([
                'success' => false,
                'msg' => 'Oferta not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing oferta (API usually does not need this)',
            'oferta' => $oferta
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oferta = oferta::find($id);

        if (!$oferta) {
            return response([
                'success' => false,
                'msg' => 'Oferta not found'
            ], 404);
        }

        $validateData = $request->validate([
            'subasta_id' => 'sometimes|required|exists:subastas,id',
            'proveedor_id' => 'sometimes|required|exists:users,id',
            'precio_ofertado' => 'sometimes|required|numeric',
            'dias_entrega' => 'sometimes|required|integer',
            'condicion_pieza' => 'sometimes|required|string|max:255',
            'meses_garantia' => 'nullable|integer',
            'es_aceptada' => 'nullable|boolean',
            'fecha_oferta' => 'sometimes|required|date',
        ]);

        $oferta->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Oferta updated successfully',
            'oferta' => $oferta
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $oferta = oferta::find($id);

        if (!$oferta) {
            return response([
                'success' => false,
                'msg' => 'Oferta not found'
            ], 404);
        }

        $oferta->delete();

        return response([
            'success' => true,
            'msg' => 'Oferta deleted successfully'
        ], 200);
    }
}