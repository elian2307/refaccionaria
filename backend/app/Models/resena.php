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

    public function autor() {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function receptor() {
        return $this->belongsTo(User::class, 'receptor_id');
    }

    public function pedido() {
        return $this->belongsTo(pedido::class, 'pedido_id');
    }
}
