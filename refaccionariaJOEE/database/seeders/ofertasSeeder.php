<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ofertasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ofertas')->insert([
            'subasta_id' => 1,
            'proveedor_id' => 2,
            'precio_ofertado' => 500.00,
            'dias_entrega' => 7,
            'condicion_pieza' => 'nueva',
            'meses_garantia' => 12,
            'es_aceptada' => false,
            'fecha_oferta' => now(),

        ]);
         DB::table('ofertas')->insert([
            'subasta_id' => 2,
            'proveedor_id' => 1,
            'precio_ofertado' => 550.00,
            'dias_entrega' => 14,
            'condicion_pieza' => 'usada',
            'meses_garantia' => 6,
            'es_aceptada' => false,
            'fecha_oferta' => now(),
        ]);
    }
}
