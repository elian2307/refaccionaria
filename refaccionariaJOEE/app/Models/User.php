<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject

{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'email_verified_at',
        'password',
        'rol',
        'tipo_usuario',
        'id_fiscal',
        'telefono',
        'reputacion',
        'is_premium',
        'fecha_registro',
        'foto_perfil',
        'is_active',
        'puntos_gamificacion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
            'puntos_gamificacion' => 'integer',
            
        ];
    }

    /**
     * Get the identifier that will be stored in the JWT token.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return an array with custom claims to be added to the JWT token.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function agregarPuntosGamificacion(int $puntos): void
    {
        $this->increment('puntos_gamificacion', $puntos);
        $this->refresh();
    }

    public function resumenGamificacion(): array
    {
        $puntos = (int) $this->puntos_gamificacion;

        $nivel = $this->calcularNivelGamificacion($puntos);
        $progreso = $this->calcularProgresoGamificacion($puntos, $nivel);

        return [
            'puntos' => $puntos,
            'nivel' => $nivel['nivel'],
            'nombre_nivel' => $nivel['nombre'],
            'insignia' => $nivel['insignia'],
            'beneficio' => $nivel['beneficio'],
            'puntos_siguiente_nivel' => $nivel['siguiente_nivel'],
            'puntos_restantes' => $progreso['puntos_restantes'],
            'progreso' => $progreso['porcentaje'],
            'logros' => $this->obtenerLogrosGamificacion($puntos),
        ];
    }

    private function calcularNivelGamificacion(int $puntos): array
    {
        if ($puntos >= 1000) {
            return [
                'nivel' => 5,
                'nombre' => 'Maestro JOEE',
                'insignia' => 'Maestro de subastas',
                'beneficio' => 'Perfil destacado visualmente dentro del sistema.',
                'siguiente_nivel' => null,
                'minimo' => 1000,
            ];
        }

        if ($puntos >= 500) {
            return [
                'nivel' => 4,
                'nombre' => 'Experto en refacciones',
                'insignia' => 'Experto confiable',
                'beneficio' => 'Sus subastas pueden mostrarse con estilo destacado.',
                'siguiente_nivel' => 1000,
                'minimo' => 500,
            ];
        }

        if ($puntos >= 250) {
            return [
                'nivel' => 3,
                'nombre' => 'Subastador activo',
                'insignia' => 'Subastador confiable',
                'beneficio' => 'Etiqueta de confianza visible en su perfil.',
                'siguiente_nivel' => 500,
                'minimo' => 250,
            ];
        }

        if ($puntos >= 100) {
            return [
                'nivel' => 2,
                'nombre' => 'Participante',
                'insignia' => 'Usuario activo',
                'beneficio' => 'Etiqueta de usuario activo en el dashboard.',
                'siguiente_nivel' => 250,
                'minimo' => 100,
            ];
        }

        return [
            'nivel' => 1,
            'nombre' => 'Principiante',
            'insignia' => 'Nuevo participante',
            'beneficio' => 'Puede publicar subastas y realizar ofertas.',
            'siguiente_nivel' => 100,
            'minimo' => 0,
        ];
    }

    private function calcularProgresoGamificacion(int $puntos, array $nivel): array
    {
        if ($nivel['siguiente_nivel'] === null) {
            return [
                'puntos_restantes' => 0,
                'porcentaje' => 100,
            ];
        }

        $siguienteNivel = $nivel['siguiente_nivel'];

        $porcentaje = ($puntos / $siguienteNivel) * 100;

        return [
            'puntos_restantes' => max($siguienteNivel - $puntos, 0),
            'porcentaje' => min(round($porcentaje), 100),
        ];
    }

    private function obtenerLogrosGamificacion(int $puntos): array
    {
        return [
            [
                'nombre' => 'Primeros pasos',
                'descripcion' => 'Comienza a participar dentro del sistema.',
                'desbloqueado' => $puntos >= 0,
            ],
            [
                'nombre' => 'Participante activo',
                'descripcion' => 'Alcanza 100 puntos de gamificación.',
                'desbloqueado' => $puntos >= 100,
            ],
            [
                'nombre' => 'Subastador confiable',
                'descripcion' => 'Alcanza 250 puntos de gamificación.',
                'desbloqueado' => $puntos >= 250,
            ],
            [
                'nombre' => 'Experto en refacciones',
                'descripcion' => 'Alcanza 500 puntos de gamificación.',
                'desbloqueado' => $puntos >= 500,
            ],
            [
                'nombre' => 'Maestro JOEE',
                'descripcion' => 'Alcanza 1000 puntos de gamificación.',
                'desbloqueado' => $puntos >= 1000,
            ],
        ];
    }

}