<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\resena;

class ResenasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resenas = resena::all();

        return response([
            'success' => true,
            'message' => $resenas->isEmpty() ? 'No resenas found' : 'Resenas retrieved successfully',
            'resenas' => $resenas
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating resena (API usually does not need this)'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'autor_id' => 'required|exists:users,id',
            'receptor_id' => 'required|exists:users,id',
            'calificacion' => 'required|numeric',
            'comentario' => 'required|string',
            'fecha_resena' => 'required|date',
        ]);

        $resena = resena::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Resena created successfully',
            'resena' => $resena
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resena = resena::find($id);

        if (!$resena) {
            return response([
                'success' => false,
                'msg' => 'Resena not found'
            ], 404);
        }

        return response([
            'success' => true,
            'resena' => $resena
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $resena = resena::find($id);

        if (!$resena) {
            return response([
                'success' => false,
                'msg' => 'Resena not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing resena (API usually does not need this)',
            'resena' => $resena
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $resena = resena::find($id);

        if (!$resena) {
            return response([
                'success' => false,
                'msg' => 'Resena not found'
            ], 404);
        }

        $validateData = $request->validate([
            'pedido_id' => 'sometimes|required|exists:pedidos,id',
            'autor_id' => 'sometimes|required|exists:users,id',
            'receptor_id' => 'sometimes|required|exists:users,id',
            'calificacion' => 'sometimes|required|numeric',
            'comentario' => 'sometimes|required|string',
            'fecha_resena' => 'sometimes|required|date',
        ]);

        $resena->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Resena updated successfully',
            'resena' => $resena
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resena = resena::find($id);

        if (!$resena) {
            return response([
                'success' => false,
                'msg' => 'Resena not found'
            ], 404);
        }

        $resena->delete();

        return response([
            'success' => true,
            'msg' => 'Resena deleted successfully'
        ], 200);
    }
}