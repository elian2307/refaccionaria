<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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

    public function img_subastas()
    {
        return $this->hasMany(img_subasta::class, 'subasta_id');
    }

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => function ($model) {
                $fullSlug = "{$model->nombre_refaccion} {$model->marca_vehiculo} {$model->modelo_vehiculo} {$model->anio_vehiculo} {$model->user_id}";

                return Str::slug($fullSlug, '-');
                },
                'separator' => '-'

            ]
        ];
    }

}
