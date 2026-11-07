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
    ];
}
