<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class resena extends Model
{
    protected $table = 'resenas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pedido_id',
        'autor_id',
        'receptor_id',
        'calificacion',
        'comentario',
        'fecha_resena',
    ];
}
