<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\PagoConfirmadoMail;
use App\Models\pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PaypalController extends Controller
{
    public function crearOrden(Request $request, string $pedidoId)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        $pedido = pedido::with(['subasta.user', 'oferta.proveedor'])->find($pedidoId);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        if (!$this->puedePagarPedido($user, $pedido)) {
            return response()->json([
                'success' => false,
                'msg' => 'No puedes pagar un pedido que no pertenece a tus pujas'
            ], 403);
        }

        if ($pedido->estado_pago === 'pagado') {
            return response()->json([
                'success' => false,
                'msg' => 'Este pedido ya está pagado'
            ], 422);
        }

        $accessToken = $this->obtenerAccessToken();

        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'msg' => 'No se pudo autenticar con PayPal. Revisa tus credenciales.'
            ], 500);
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->post($this->baseUrl() . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => 'PEDIDO-' . $pedido->id,
                        'description' => 'Orden ORD-' . $pedido->id . ' - Subastas JOEE',
                        'custom_id' => (string) $pedido->id,
                        'amount' => [
                            'currency_code' => $this->currency(),
                            'value' => $this->formatearMonto($pedido->monto_total),
                        ],
                    ]
                ],
                'application_context' => [
                    'brand_name' => 'Subastas JOEE',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                ],
            ]);

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'msg' => 'PayPal no pudo crear la orden',
                'paypal_error' => $response->json(),
            ], 500);
        }

        $paypalData = $response->json();

        $pedido->update([
            'paypal_order_id' => $paypalData['id'] ?? null,
            'paypal_status' => $paypalData['status'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'paypal_order_id' => $paypalData['id'] ?? null,
            'pedido' => $pedido->fresh(),
        ], 200);
    }

    public function capturarOrden(Request $request, string $pedidoId)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'msg' => 'Usuario no autenticado'
            ], 401);
        }

        $pedido = pedido::with(['subasta.user', 'oferta.proveedor'])->find($pedidoId);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'msg' => 'Pedido not found'
            ], 404);
        }

        if (!$this->puedePagarPedido($user, $pedido)) {
            return response()->json([
                'success' => false,
                'msg' => 'No puedes pagar un pedido que no pertenece a tus pujas'
            ], 403);
        }

        if ($pedido->estado_pago === 'pagado') {
            return response()->json([
                'success' => true,
                'msg' => 'Este pedido ya estaba pagado',
                'pedido' => $pedido
            ], 200);
        }

        $paypalOrderId = $request->input('paypal_order_id') ?: $pedido->paypal_order_id;

        if (!$paypalOrderId) {
            return response()->json([
                'success' => false,
                'msg' => 'No hay una orden de PayPal para capturar'
            ], 422);
        }

        if ($pedido->paypal_order_id && $pedido->paypal_order_id !== $paypalOrderId) {
            return response()->json([
                'success' => false,
                'msg' => 'La orden de PayPal no coincide con este pedido'
            ], 422);
        }

        $accessToken = $this->obtenerAccessToken();

        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'msg' => 'No se pudo autenticar con PayPal. Revisa tus credenciales.'
            ], 500);
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->withBody('{}', 'application/json')
            ->post($this->baseUrl() . '/v2/checkout/orders/' . $paypalOrderId . '/capture');

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'msg' => 'PayPal no pudo capturar el pago',
                'paypal_error' => $response->json(),
            ], 500);
        }

        $paypalData = $response->json();
        $capture = $paypalData['purchase_units'][0]['payments']['captures'][0] ?? null;
        $payerEmail = $paypalData['payer']['email_address'] ?? null;

        if (($paypalData['status'] ?? null) !== 'COMPLETED') {
            $pedido->update([
                'paypal_order_id' => $paypalOrderId,
                'paypal_status' => $paypalData['status'] ?? null,
                'paypal_payer_email' => $payerEmail,
            ]);

            return response()->json([
                'success' => false,
                'msg' => 'El pago no quedó completado en PayPal',
                'paypal_status' => $paypalData['status'] ?? null,
                'pedido' => $pedido->fresh(),
            ], 422);
        }

        $pedido->update([
            'estado_pago' => 'pagado',
            'paypal_order_id' => $paypalOrderId,
            'paypal_capture_id' => $capture['id'] ?? null,
            'paypal_status' => $paypalData['status'] ?? null,
            'paypal_payer_email' => $payerEmail,
            'fecha_pago' => now(),
        ]);

        $pedido->refresh();
        $pedido->load(['subasta.user', 'oferta.proveedor']);

        if ($pedido->oferta && $pedido->oferta->proveedor && $pedido->oferta->proveedor->email) {
            $this->enviarCorreoSeguro($pedido->oferta->proveedor->email, new PagoConfirmadoMail($pedido));
        }

        if ($pedido->subasta && $pedido->subasta->user && $pedido->subasta->user->email) {
            $this->enviarCorreoSeguro($pedido->subasta->user->email, new PagoConfirmadoMail($pedido));
        }

        return response()->json([
            'success' => true,
            'msg' => 'Pago confirmado correctamente',
            'pedido' => $pedido,
            'paypal' => $paypalData,
        ], 200);
    }

    private function obtenerAccessToken(): ?string
    {
        $clientId = $this->clientId();
        $clientSecret = $this->clientSecret();

        if (!$clientId || !$clientSecret) {
            return null;
        }

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post($this->baseUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            report(new \Exception('PayPal OAuth error: ' . $response->body()));
            return null;
        }

        return $response->json('access_token');
    }

    private function puedePagarPedido($user, pedido $pedido): bool
    {
        if ($user->rol === 'admin') {
            return true;
        }

        return $user->rol === 'comprador'
            && $pedido->oferta
            && (int) $pedido->oferta->proveedor_id === (int) $user->id;
    }

    private function formatearMonto($monto): string
    {
        return number_format((float) $monto, 2, '.', '');
    }

    private function mode(): string
    {
        return config('services.paypal.mode', 'sandbox') === 'live' ? 'live' : 'sandbox';
    }

    private function baseUrl(): string
    {
        return $this->mode() === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    private function clientId(): ?string
    {
        return $this->mode() === 'live'
            ? config('services.paypal.live_client_id')
            : config('services.paypal.sandbox_client_id');
    }

    private function clientSecret(): ?string
    {
        return $this->mode() === 'live'
            ? config('services.paypal.live_client_secret')
            : config('services.paypal.sandbox_client_secret');
    }

    private function currency(): string
    {
        return config('services.paypal.currency', 'MXN');
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