<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'id_fiscal' => null,
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
            'id_fiscal' => null,
            'telefono' => '0987654321',
            'reputacion' => 4.0,
            'is_premium' => false,
            'fecha_registro' => now(),
        ]);

             
}
}