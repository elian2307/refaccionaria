<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\oferta;
use App\Models\subasta;
use App\Models\pedido;
use App\Mail\PedidoCreadoMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class OfertasController extends Controller
{
    public function index()
    {
        $ofertas = oferta::all();

        return response([
            'success' => true,
            'message' => $ofertas->isEmpty() ? 'No ofertas found' : 'Ofertas retrieved successfully',
            'ofertas' => $ofertas
        ], 200);
    }

    public function misOfertas()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        if (!in_array($user->rol, ['comprador', 'admin'])) {
            return response([
                'success' => false,
                'msg' => 'Solo los compradores pueden ver sus pujas realizadas'
            ], 403);
        }

        $query = oferta::with('subasta')
            ->orderBy('created_at', 'desc');

        if ($user->rol !== 'admin') {
            $query->where('proveedor_id', $user->id);
        }

        $ofertas = $query->get();

        return response([
            'success' => true,
            'ofertas' => $ofertas
        ], 200);
    }

    public function ofertasPorSubasta(string $id)
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
                'msg' => 'Solo los vendedores pueden ver las pujas recibidas'
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
                'msg' => 'No puedes ver pujas de una subasta que no es tuya'
            ], 403);
        }

        $ofertas = oferta::with('proveedor:id,nombre,apellidos,email,rol')
            ->where('subasta_id', $subasta->id)
            ->orderBy('precio_ofertado', 'desc')
            ->get();

        return response([
            'success' => true,
            'subasta' => $subasta,
            'ofertas' => $ofertas
        ], 200);
    }

    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating oferta (API usually does not need this)'
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

        if (!in_array($user->rol, ['comprador', 'admin'])) {
            return response([
                'success' => false,
                'msg' => 'Solo los compradores pueden hacer pujas'
            ], 403);
        }

        $validateData = $request->validate([
            'subasta_id' => 'required|exists:subastas,id',
            'precio_ofertado' => 'required|numeric|min:0.01',
        ]);

        $subasta = subasta::find($validateData['subasta_id']);

        if (!$subasta) {
            return response([
                'success' => false,
                'msg' => 'Subasta not found'
            ], 404);
        }

        if ($subasta->estado !== 'abierta') {
            return response([
                'success' => false,
                'msg' => 'No puedes pujar en una subasta que no está abierta'
            ], 422);
        }

        if ($subasta->user_id === $user->id) {
            return response([
                'success' => false,
                'msg' => 'No puedes pujar en tu propia subasta'
            ], 403);
        }

        $pujaMayor = oferta::where('subasta_id', $subasta->id)
            ->max('precio_ofertado');

        if ($pujaMayor !== null && $validateData['precio_ofertado'] <= $pujaMayor) {
            return response([
                'success' => false,
                'msg' => 'Tu puja debe ser mayor a la puja actual',
                'puja_actual' => $pujaMayor
            ], 422);
        }

        $validateData['proveedor_id'] = $user->id;
        $validateData['dias_entrega'] = 1;
        $validateData['condicion_pieza'] = 'nueva';
        $validateData['meses_garantia'] = 0;
        $validateData['es_aceptada'] = false;
        $validateData['fecha_oferta'] = now();

        $oferta = oferta::create($validateData);

        $user->agregarPuntosGamificacion(15);

        return response([
            'success' => true,
            'msg' => 'Puja realizada correctamente',
            'oferta' => $oferta,
            'gamificacion' => $user->resumenGamificacion()
        ], 201);
    }

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

    public function aceptarOferta(string $id)
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
                'msg' => 'Solo los vendedores pueden aceptar pujas'
            ], 403);
        }

        $oferta = oferta::with(['subasta', 'proveedor'])->find($id);

        if (!$oferta) {
            return response([
                'success' => false,
                'msg' => 'Oferta not found'
            ], 404);
        }

        if (!$oferta->subasta) {
            return response([
                'success' => false,
                'msg' => 'La oferta no tiene una subasta relacionada'
            ], 404);
        }

        if ($user->rol !== 'admin' && $oferta->subasta->user_id !== $user->id) {
            return response([
                'success' => false,
                'msg' => 'No puedes aceptar una puja de una subasta que no es tuya'
            ], 403);
        }

        if ($oferta->subasta->estado === 'finalizada') {
            return response([
                'success' => false,
                'msg' => 'Esta subasta ya fue finalizada'
            ], 422);
        }

        $pedido = null;

        DB::transaction(function () use ($oferta, &$pedido) {
            oferta::where('subasta_id', $oferta->subasta_id)
                ->update(['es_aceptada' => false]);

            $oferta->update([
                'es_aceptada' => true
            ]);

            $oferta->subasta->update([
                'estado' => 'finalizada'
            ]);

            $montoTotal = $oferta->precio_ofertado;
            $montoComision = $montoTotal * 0.05;

            $pedido = pedido::updateOrCreate(
                [
                    'subasta_id' => $oferta->subasta_id,
                    'oferta_id' => $oferta->id,
                ],
                [
                    'monto_total' => $montoTotal,
                    'monto_comision' => $montoComision,
                    'estado_pago' => 'pendiente',
                    'estado_envio' => 'pendiente',
                    'numero_rastreo' => 'Pendiente',
                    'fecha_pedido' => now(),
                    'paypal_order_id' => null,
                    'paypal_capture_id' => null,
                    'paypal_status' => null,
                    'paypal_payer_email' => null,
                    'fecha_pago' => null,
                ]
            );
        });

        $oferta->load(['subasta', 'proveedor']);
        $pedido->load(['subasta.user', 'oferta.proveedor']);

        if ($pedido->oferta && $pedido->oferta->proveedor && $pedido->oferta->proveedor->email) {
            $this->enviarCorreoSeguro($pedido->oferta->proveedor->email, new PedidoCreadoMail($pedido));
        }

        return response([
            'success' => true,
            'msg' => 'Puja aceptada y pedido creado correctamente. El pago queda pendiente para PayPal.',
            'oferta' => $oferta,
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

        $oferta = oferta::find($id);

        if (!$oferta) {
            return response([
                'success' => false,
                'msg' => 'Oferta not found'
            ], 404);
        }

        if ($user->rol !== 'admin' && $oferta->proveedor_id !== $user->id) {
            return response([
                'success' => false,
                'msg' => 'No puedes editar una puja que no es tuya'
            ], 403);
        }

        $validateData = $request->validate([
            'precio_ofertado' => 'sometimes|required|numeric|min:0.01',
            'dias_entrega' => 'sometimes|required|integer|min:1',
            'condicion_pieza' => 'sometimes|required|in:nueva,usada,reconstruida',
            'meses_garantia' => 'nullable|integer|min:0',
        ]);

        $oferta->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Puja actualizada correctamente',
            'oferta' => $oferta
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

        $oferta = oferta::find($id);

        if (!$oferta) {
            return response([
                'success' => false,
                'msg' => 'Oferta not found'
            ], 404);
        }

        if ($user->rol !== 'admin' && $oferta->proveedor_id !== $user->id) {
            return response([
                'success' => false,
                'msg' => 'No puedes eliminar una puja que no es tuya'
            ], 403);
        }

        if ($oferta->es_aceptada) {
            return response([
                'success' => false,
                'msg' => 'No puedes eliminar una puja que ya fue aceptada'
            ], 422);
        }

        $oferta->delete();

        return response([
            'success' => true,
            'msg' => 'Puja eliminada correctamente'
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