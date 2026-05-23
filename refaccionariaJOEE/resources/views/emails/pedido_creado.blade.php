@component('mail::message')
# Tu oferta fue aceptada

Hola {{ $pedido->oferta?->proveedor?->nombre ?? 'usuario' }}.

El vendedor aceptó tu oferta y se generó la orden **ORD-{{ $pedido->id }}**.

**Refacción:** {{ $pedido->subasta?->nombre_refaccion ?? 'No disponible' }}  
**Vehículo:** {{ $pedido->subasta ? $pedido->subasta->marca_vehiculo . ' ' . $pedido->subasta->modelo_vehiculo . ' ' . $pedido->subasta->anio_vehiculo : 'No disponible' }}  
**Total a pagar:** ${{ number_format((float) $pedido->monto_total, 2) }} MXN

El pago sigue pendiente. Entra a tu panel de órdenes y paga con PayPal para que el vendedor pueda continuar con el envío.

@component('mail::button', ['url' => config('app.url')])
Ver mis órdenes
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent