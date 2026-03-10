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
            'estado' => 'abierta',
            'fecha_expiracion' => now()->addDays(7),
        ]);
        $dato = new subasta();
        $dato->user_id = 1;
        $dato->marca_vehiculo = 'Honda';
        $dato->modelo_vehiculo = 'Civic';
        $dato->anio_vehiculo = '2010';
        $dato->nombre_refaccion = 'Motor';
        $dato->descripcion_problema = 'Motor en buen estado, con poco uso, ideal para Honda Civic 2010.';
        $dato->urgencia = 'alta';
        $dato->estado = 'abierta';
        $dato->fecha_expiracion = now()->addDays(7);
        $dato->save();
    }
}
