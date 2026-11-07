<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class oferta extends Model
{
    protected $table = 'ofertas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subasta_id',
        'proveedor_id',
        'precio_ofertado',
        'dias_entrega',
        'condicion_pieza',
        'meses_garantia',
        'es_aceptada',
        'fecha_oferta',
    ];
}
