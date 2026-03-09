<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pedidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pedidos')->insert([
            'subasta_id' => 1,
                'oferta_id' => 1,
                'monto_total' => 500.00,
            'monto_comision' => 50.00,
            'estado_pago' => 'pendiente',
            'estado_envio' => 'pendiente',
            'numero_rastreo' => null,
            'fecha_pedido' => now(),        
        ]);
         DB::table('pedidos')->insert([
            'subasta_id' => 2,
            'oferta_id' => 2,
            'monto_total' => 550.00,
            'monto_comision' => 55.00,
            'estado_pago' => 'pendiente',
            'estado_envio' => 'pendiente',
            'numero_rastreo' => null,
            'fecha_pedido' => now(),        
        ]);
    }
}
