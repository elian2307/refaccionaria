<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\direccion;

class direccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('direcciones')->insert([
            'user_id' => 1,
            'calle' => 'Calle ignacio zaragoza',
            'numero_exterior' => '123',
            'numero_interior' => 'A',
            'colonia' => 'Colonia Inventada',
            'municipio' => 'Municipio Imaginario',
            'codigo_postal' => '12345',
            'estado' => 'Estado Fantasma',
        ]);
         DB::table('direcciones')->insert([
            'user_id' => 2,
            'calle' => 'Calle pedro infante',
            'numero_exterior' => '124',
            'numero_interior' => 'B',
            'colonia' => 'Colonia Inovitada',
            'municipio' => 'Municipio loko',
            'codigo_postal' => '34567',
            'estado' => 'Estado Chihuahua',
        ]);

    }
}
