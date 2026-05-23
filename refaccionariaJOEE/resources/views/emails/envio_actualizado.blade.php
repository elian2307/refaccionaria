@component('mail::message')
# Actualización de envío

Tu orden **ORD-{{ $pedido->id }}** tiene una actualización de envío.

**Refacción:** {{ $pedido->subasta?->nombre_refaccion ?? 'No disponible' }}  
**Estado de envío:** {{ strtoupper($pedido->estado_envio) }}  
**Número de rastreo:** {{ $pedido->numero_rastreo ?: 'Pendiente' }}

Puedes revisar el estado desde tu panel de órdenes.

@component('mail::button', ['url' => config('app.url')])
Ver mis órdenes
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent