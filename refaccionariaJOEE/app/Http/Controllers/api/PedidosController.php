<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido;
use App\Mail\EnvioActualizadoMail;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PedidosController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        $query = pedido::with([
            'subasta',
            'subasta.user:id,nombre,apellidos,email,rol',
            'oferta',
            'oferta.proveedor:id,nombre,apellidos,email,rol'
        ])->orderBy('created_at', 'desc');

        if ($user->rol === 'vendedor') {
            $query->whereHas('subasta', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if ($user->rol === 'comprador') {
            $query->whereHas('oferta', function ($q) use ($user) {
                $q->where('proveedor_id', $user->id);
            });
        }

        $pedidos = $query->get();

        return response([
            'success' => true,
            'message' => $pedidos->isEmpty() ? 'No pedidos found' : 'Pedidos retrieved successfully',
            'pedidos' => $pedidos
        ], 200);
    }

    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating pedido (API usually does not need this)'
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

        if ($user->rol !== 'admin') {
            return response([
                'success' => false,
                'msg' => 'Los pedidos se crean automáticamente al aceptar una puja'
            ], 403);
        }

        $validateData = $request->validate([
            'subasta_id' => 'required|exists:subastas,id',
            'oferta_id' => 'required|exists:ofertas,id',
            'monto_total' => 'required|numeric',
            'monto_comision' => 'required|numeric',
            'estado_pago' => 'required|in:pendiente,pagado,reembolsado',
            'estado_envio' => 'required|in:pendiente,enviado,entregado',
            'numero_rastreo' => 'nullable|string|max:255',
            'fecha_pedido' => 'required|date',
        ]);

        $validateData['numero_rastreo'] = $validateData['numero_rastreo'] ?? 'Pendiente';

        $pedido = pedido::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Pedido created successfully',
            'pedido' => $pedido
        ], 201);
    }

    public function show(string $id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        $pedido = pedido::with([
            'subasta',
            'subasta.user:id,nombre,apellidos,email,rol',
            'oferta',
            'oferta.proveedor:id,nombre,apellidos,email,rol'
        ])->find($id);

        if (!$pedido) {
            return response([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        if (
            $user->rol === 'vendedor' &&
            $pedido->subasta &&
            $pedido->subasta->user_id !== $user->id
        ) {
            return response([
                'success' => false,
                'msg' => 'No puedes ver un pedido que no pertenece a tus subastas'
            ], 403);
        }

        if (
            $user->rol === 'comprador' &&
            $pedido->oferta &&
            $pedido->oferta->proveedor_id !== $user->id
        ) {
            return response([
                'success' => false,
                'msg' => 'No puedes ver un pedido que no pertenece a tus pujas'
            ], 403);
        }

        return response([
            'success' => true,
            'pedido' => $pedido
        ], 200);
    }

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

    public function update(Request $request, string $id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        $pedido = pedido::with(['subasta.user', 'oferta.proveedor'])->find($id);

        if (!$pedido) {
            return response([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        if (!in_array($user->rol, ['vendedor', 'admin'])) {
            return response([
                'success' => false,
                'msg' => 'Solo el vendedor puede actualizar el envío del pedido'
            ], 403);
        }

        if (
            $user->rol !== 'admin' &&
            $pedido->subasta &&
            $pedido->subasta->user_id !== $user->id
        ) {
            return response([
                'success' => false,
                'msg' => 'No puedes actualizar un pedido que no pertenece a tus subastas'
            ], 403);
        }

        $validateData = $request->validate([
            'estado_envio' => 'sometimes|required|in:pendiente,enviado,entregado',
            'numero_rastreo' => 'nullable|string|max:255',
        ]);

        if (isset($validateData['estado_envio']) && $validateData['estado_envio'] !== 'pendiente' && $pedido->estado_pago !== 'pagado') {
            return response([
                'success' => false,
                'msg' => 'No puedes marcar el envío como enviado o entregado hasta que el pago esté confirmado por PayPal'
            ], 422);
        }

        if (array_key_exists('numero_rastreo', $validateData) && !$validateData['numero_rastreo']) {
            $validateData['numero_rastreo'] = 'Pendiente';
        }

        $estadoAnterior = $pedido->estado_envio;
        $rastreoAnterior = $pedido->numero_rastreo;

        $pedido->update($validateData);
        $pedido->refresh();
        $pedido->load(['subasta.user', 'oferta.proveedor']);

        $cambioEnvio = $estadoAnterior !== $pedido->estado_envio || $rastreoAnterior !== $pedido->numero_rastreo;

        if ($cambioEnvio && $pedido->oferta && $pedido->oferta->proveedor && $pedido->oferta->proveedor->email) {
            $this->enviarCorreoSeguro($pedido->oferta->proveedor->email, new EnvioActualizadoMail($pedido));
        }

        return response([
            'success' => true,
            'msg' => 'Pedido updated successfully',
            'pedido' => $pedido
        ], 200);
    }

    public function destroy(string $id)
    {
        $user = auth('api')->user();

        if (!$user || $user->rol !== 'admin') {
            return response([
                'success' => false,
                'msg' => 'Solo admin puede eliminar pedidos'
            ], 403);
        }

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

    private function enviarCorreoSeguro(string $email, $mailable): void
    {
        try {
            Mail::to($email)->send($mailable);
        } catch (Throwable $e) {
            report($e);
        }
    }
}