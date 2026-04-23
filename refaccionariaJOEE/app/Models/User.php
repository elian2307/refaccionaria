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

}