<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class usersSeeder extends Seeder
{
    public function run(): void
    {
        //  2 registros con DB
        DB::table('users')->insert([
            [
                'nombre' => 'Admin',
                'apellidos' => 'Principal',
                'email' => 'admin@joee.com',
                'password' => Hash::make('12345678'),
                'rol' => 'admin',
                'tipo_usuario' => 'admin',
                'telefono' => '6141111111',
                'reputacion' => 5.00,
                'is_premium' => true,
                'fecha_registro' => now(),
                'foto_perfil' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos',
                'apellidos' => 'Vendedor',
                'email' => 'vendedor@joee.com',
                'password' => Hash::make('12345678'),
                'rol' => 'vendedor',
                'tipo_usuario' => 'refaccionaria',
                'telefono' => '6142222222',
                'reputacion' => 4.50,
                'is_premium' => false,
                'fecha_registro' => now(),
                'foto_perfil' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        //  2 registros con modelo
        User::create([
            'nombre' => 'Ana',
            'apellidos' => 'Compradora',
            'email' => 'comprador1@joee.com',
            'password' => Hash::make('12345678'),
            'rol' => 'comprador',
            'tipo_usuario' => 'usuario',
            'telefono' => '6143333333',
            'reputacion' => 3.80,
            'is_premium' => false,
            'fecha_registro' => now(),
            'foto_perfil' => null,
            'is_active' => true,
        ]);

        User::create([
            'nombre' => 'Luis',
            'apellidos' => 'Comprador',
            'email' => 'comprador2@joee.com',
            'password' => Hash::make('12345678'),
            'rol' => 'comprador',
            'tipo_usuario' => 'usuario',
            'telefono' => '6144444444',
            'reputacion' => 4.10,
            'is_premium' => false,
            'fecha_registro' => now(),
            'foto_perfil' => null,
            'is_active' => true,
        ]);

        User::create([
            'nombre' => 'Admin Test',
            'apellidos' => 'Sistema',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'rol' => 'admin',
            'tipo_usuario' => 'admin',
            'telefono' => '6145555555',
            'reputacion' => 5.00,
            'is_premium' => true,
            'fecha_registro' => now(),
            'is_active' => true,
        ]);

        User::create([
            'nombre' => 'Vendedor Test',
            'apellidos' => 'Sistema',
            'email' => 'vendedor@test.com',
            'password' => Hash::make('12345678'),
            'rol' => 'vendedor',
            'tipo_usuario' => 'refaccionaria',
            'telefono' => '6146666666',
            'reputacion' => 4.20,
            'is_premium' => false,
            'fecha_registro' => now(),
            'is_active' => true,
        ]);

        User::create([
            'nombre' => 'Comprador Test',
            'apellidos' => 'Sistema',
            'email' => 'comprador@test.com',
            'password' => Hash::make('12345678'),
            'rol' => 'comprador',
            'tipo_usuario' => 'usuario',
            'telefono' => '6147777777',
            'reputacion' => 3.50,
            'is_premium' => false,
            'fecha_registro' => now(),
            'is_active' => true,
        ]);
    }
}