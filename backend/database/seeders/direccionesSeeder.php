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

        $dato = new direccion();
        $dato->user_id = 1;
        $dato->calle = 'Calle ignacio zaragoza';
        $dato->numero_exterior = '123';
        $dato->numero_interior = 'A';
        $dato->colonia = 'Colonia Inventada';
        $dato->municipio = 'Municipio Imaginario';
        $dato->codigo_postal = '12345';
        $dato->estado = 'Estado Francia';
        $dato->save();

        $dato = new direccion();
        $dato->user_id = 2;
        $dato->calle = 'Calle pedro infante';
        $dato->numero_exterior = '124';
        $dato->numero_interior = 'B';
        $dato->colonia = 'Colonia Inovitada';
        $dato->municipio = 'Municipio loko';
        $dato->codigo_postal = '34567';
        $dato->estado = 'Estado Chihuahua';
        $dato->save();

    }
}
