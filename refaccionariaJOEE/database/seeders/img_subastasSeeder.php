<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\img_subasta;

class img_subastasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('img_subastas')->insert([
            'subasta_id' => 1,
            'url' => 'https://example.com/imagen1.jpg',
            
        ]);
         DB::table('img_subastas')->insert([
            'subasta_id' => 2,
            'url' => 'https://example.com/imagen2.jpg',
            
        ]);
        $dato = new img_subasta();
        $dato->subasta_id = 1;
        $dato->url = 'https://example.com/imagen1.jpg';
        $dato->save();

        $dato = new img_subasta();
        $dato->subasta_id = 2;
        $dato->url = 'https://example.com/imagen2.jpg';
        $dato->save();
    }
}
