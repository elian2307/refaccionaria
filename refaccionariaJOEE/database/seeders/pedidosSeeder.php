<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\pedido;

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
            'numero_rastreo' => random_int(100000, 999999),
            'fecha_pedido' => now(),        
        ]);
         DB::table('pedidos')->insert([
            'subasta_id' => 2,
            'oferta_id' => 2,
            'monto_total' => 550.00,
            'monto_comision' => 55.00,
            'estado_pago' => 'pagado',
            'estado_envio' => 'pendiente',
            'numero_rastreo' => random_int(100000, 999999),
            'fecha_pedido' => now(),        
        ]);

        $dato = new pedido();
        $dato->subasta_id = 1;
        $dato->oferta_id = 1;
        $dato->monto_total = 500.00;
        $dato->monto_comision = 50.00;
        $dato->estado_pago = 'reembolsado';
        $dato->estado_envio = 'pendiente';
        $dato->numero_rastreo = random_int(100000, 999999);
        $dato->fecha_pedido = now();
        $dato->save();


        $dato = new pedido();
        $dato->subasta_id = 2; 
        $dato->oferta_id = 2;
        $dato->monto_total = 550.00;
        $dato->monto_comision = 55.00;
        $dato->estado_pago = 'pendiente';
        $dato->estado_envio = 'pendiente';
        $dato->numero_rastreo = random_int(100000, 999999);
        $dato->fecha_pedido = now();
        $dato->save();
    
    }
}
