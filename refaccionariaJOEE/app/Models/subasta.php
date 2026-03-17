<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subasta extends Model
{
    protected $table = 'subastas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'marca_vehiculo',
        'modelo_vehiculo',
        'anio_vehiculo',
        'nombre_refaccion',
        'descripcion_problema',
        'urgencia',
        'estado',
        'fecha_expiracion',
    ];
}
