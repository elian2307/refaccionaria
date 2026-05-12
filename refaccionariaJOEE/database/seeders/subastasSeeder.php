<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\subasta;

class subastasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subastas')->insert([
            'user_id' => 1,
            'marca_vehiculo' => 'Honda',
            'modelo_vehiculo' => 'Civic',
            'anio_vehiculo' => '2010',
            'nombre_refaccion' => 'Motor',
            'descripcion_problema' => 'Motor en buen estado, con poco uso, ideal para Honda Civic 2010.',
            'urgencia' => 'alta',
            'estado' => 'abierta',
            'fecha_expiracion' => now()->addDays(7),
        ]);
         DB::table('subastas')->insert([
            'user_id' => 2,
            'marca_vehiculo' => 'Toyota',
            'modelo_vehiculo' => 'Camry',
            'anio_vehiculo' => '2015',
            'nombre_refaccion' => 'Transmisión Automática',
            'descripcion_problema' => 'Transmisión automática en buen estado, con poco uso, ideal para Toyota Camry 2015.',
            'urgencia' => 'media',
            'estado' => 'cerrada',
            'fecha_expiracion' => now()->addDays(7),
        ]);
        $dato = new subasta();
        $dato->user_id = 1;
        $dato->marca_vehiculo = 'Honda';
        $dato->modelo_vehiculo = 'Civic';
        $dato->anio_vehiculo = '2010';
        $dato->nombre_refaccion = 'Volante';
        $dato->descripcion_problema = 'Volante en buen estado, con poco uso, ideal para Honda Civic 2010.';
        $dato->urgencia = 'alta';
        $dato->estado = 'finalizada';
        $dato->fecha_expiracion = now()->addDays(7);
        $dato->save();

        $dato = new subasta();
        $dato->user_id = 2;
        $dato->marca_vehiculo = 'Toyota';
        $dato->modelo_vehiculo = 'Tacoma';
        $dato->anio_vehiculo = '2022';
        $dato->nombre_refaccion = 'Amortiguador';
        $dato->descripcion_problema = 'Amortiguador en buen estado, con poco uso, ideal para Toyota Tacoma 2022.';
        $dato->urgencia = 'media';
        $dato->estado = 'cancelada';
        $dato->fecha_expiracion = now()->addDays(7);
        $dato->save();
    }

}
