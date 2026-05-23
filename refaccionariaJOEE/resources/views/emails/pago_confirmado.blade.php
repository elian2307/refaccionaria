@component('mail::message')
# Pago confirmado

La orden **ORD-{{ $pedido->id }}** fue pagada correctamente por PayPal.

**Refacción:** {{ $pedido->subasta?->nombre_refaccion ?? 'No disponible' }}  
**Total pagado:** ${{ number_format((float) $pedido->monto_total, 2) }} MXN  
**Estado de pago:** {{ strtoupper($pedido->estado_pago) }}

@if($pedido->paypal_order_id)
**Orden PayPal:** {{ $pedido->paypal_order_id }}
@endif

@if($pedido->paypal_capture_id)
**Captura PayPal:** {{ $pedido->paypal_capture_id }}
@endif

El vendedor ya puede preparar el envío de la refacción.

Gracias,<br>
{{ config('app.name') }}
@endcomponent