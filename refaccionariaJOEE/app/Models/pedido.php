<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'subasta_id',
        'oferta_id',
        'monto_total',
        'monto_comision',
        'estado_pago',
        'estado_envio',
        'numero_rastreo',
        'fecha_pedido',
        'paypal_order_id',
        'paypal_capture_id',
        'paypal_status',
        'paypal_payer_email',
        'fecha_pago',
    ];

    public function subasta()
    {
        return $this->belongsTo(subasta::class, 'subasta_id');
    }

    public function oferta()
    {
        return $this->belongsTo(oferta::class, 'oferta_id');
    }
}