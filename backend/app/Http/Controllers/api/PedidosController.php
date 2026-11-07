<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = pedido::all();

        return response([
            'success' => true,
            'message' => $pedidos->isEmpty() ? 'No pedidos found' : 'Pedidos retrieved successfully',
            'pedidos' => $pedidos
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating pedido (API usually does not need this)'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'subasta_id' => 'required|exists:subastas,id',
            'oferta_id' => 'required|exists:ofertas,id',
            'monto_total' => 'required|numeric',
            'monto_comision' => 'required|numeric',
            'estado_pago' => 'required|string|max:255',
            'estado_envio' => 'required|string|max:255',
            'numero_rastreo' => 'nullable|string|max:255',
            'fecha_pedido' => 'required|date',
        ]);

        $pedido = pedido::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Pedido created successfully',
            'pedido' => $pedido
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = pedido::find($id);

        if (!$pedido) {
            return response([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        return response([
            'success' => true,
            'pedido' => $pedido
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pedido = pedido::find($id);

        if (!$pedido) {
            return response([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing pedido (API usually does not need this)',
            'pedido' => $pedido
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pedido = pedido::find($id);

        if (!$pedido) {
            return response([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        $validateData = $request->validate([
            'subasta_id' => 'sometimes|required|exists:subastas,id',
            'oferta_id' => 'sometimes|required|exists:ofertas,id',
            'monto_total' => 'sometimes|required|numeric',
            'monto_comision' => 'sometimes|required|numeric',
            'estado_pago' => 'sometimes|required|string|max:255',
            'estado_envio' => 'sometimes|required|string|max:255',
            'numero_rastreo' => 'nullable|string|max:255',
            'fecha_pedido' => 'sometimes|required|date',
        ]);

        $pedido->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Pedido updated successfully',
            'pedido' => $pedido
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pedido = pedido::find($id);

        if (!$pedido) {
            return response([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        $pedido->delete();

        return response([
            'success' => true,
            'msg' => 'Pedido deleted successfully'
        ], 200);
    }
}