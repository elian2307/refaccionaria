<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\resena;


class resenasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('resenas')->insert([
            'pedido_id' => 2,
            'autor_id' => 1,
            'receptor_id' => 2,
            'calificacion' => 5,
            'comentario' => 'Excelente experiencia, producto de alta calidad y entrega rápida.',
            'fecha_resena' => now(),
        ]);
         DB::table('resenas')->insert([
            'pedido_id' => 1,
            'autor_id' => 2,
            'receptor_id' => 1,
            'calificacion' => 6,
            'comentario' => 'Buen producto, aunque la entrega tardó un poco más de lo esperado.',
            'fecha_resena' => now(),
        ]);

        $dato = new resena();
        $dato->pedido_id = 2;
        $dato->autor_id = 1;
        $dato->receptor_id = 2;
        $dato->calificacion = 5;
        $dato->comentario = 'Excelente experiencia, producto de alta calidad y entrega rápida.';
        $dato->fecha_resena = now();
        $dato->save();

        $dato = new resena();
        $dato->pedido_id = 1;
        $dato->autor_id = 2;
        $dato->receptor_id = 1;
        $dato->calificacion = 6;
        $dato->comentario = 'Buen producto, aunque la entrega tardó un poco más de lo esperado.';
        $dato->fecha_resena = now();
        $dato->save();
    }
}
