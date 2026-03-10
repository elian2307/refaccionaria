<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class direccion extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'municipio',
        'estado',
        'codigo_postal',
    ];
}
