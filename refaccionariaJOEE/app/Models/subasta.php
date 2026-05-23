<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class subasta extends Model
{
    use Sluggable;

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
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function img_subastas()
    {
        return $this->hasMany(img_subasta::class, 'subasta_id');
    }

    public function ofertas()
    {
        return $this->hasMany(oferta::class, 'subasta_id');
    }

    public function getSlugSourceAttribute()
    {
        return "{$this->nombre_refaccion} {$this->marca_vehiculo} {$this->modelo_vehiculo} {$this->anio_vehiculo} {$this->user_id}";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_source',
                'separator' => '-'
            ]
        ];
    }
}