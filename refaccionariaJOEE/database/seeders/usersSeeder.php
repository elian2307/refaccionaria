<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nombre' => 'Orlando',
            'email' => 'orlando@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1234567'),
            'tipo_usuario' => 'admin',
            'id_fiscal' => 'MOVO12344444',
            'telefono' => '1234567890',
            'reputacion' => 4.5,
            'is_premium' => true,
            'fecha_registro' => now(),
        ]);
         DB::table('users')->insert([
            'nombre' => 'Maria',
            'email' => 'maria@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('2345678'),
            'tipo_usuario' => 'usuario',
            'id_fiscal' => 'MOVO12344455',
            'telefono' => '0987654321',
            'reputacion' => 4.0,
            'is_premium' => false,
            'fecha_registro' => now(),
        ]);
    $dato = new User();
    $dato->nombre = 'Carlos';
    $dato->email = 'carlos@example.com';
    $dato->email_verified_at = now();
    $dato->password = bcrypt('3456789');
    $dato->tipo_usuario = 'usuario';
    $dato->id_fiscal = 'MOVO12344466';
    $dato->telefono = '1122334455';
    $dato->reputacion = 4.2;
    $dato->is_premium = true;
    $dato->fecha_registro = now();
    $dato->save();


    $dato = new User();
    $dato->nombre = 'Ana';
    $dato->email = 'ana@example.com';
    $dato->email_verified_at = now();
    $dato->password = bcrypt('4567890');
    $dato->tipo_usuario = 'usuario';
    $dato->id_fiscal = 'MOVO12344477';
    $dato->telefono = '0987654321';
    $dato->reputacion = 4.0;
    $dato->is_premium = false;
    $dato->fecha_registro = now();
    $dato->save();
}
}