<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\img_subasta;
use Illuminate\Support\Carbon;

class img_subastasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('img_subastas')->insert([
            'subasta_id' => 1,
            'url' => 'https://lajdm.com/images/engine/watermark/en/212-505-dsc_2799.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            
        ]);
         DB::table('img_subastas')->insert([
            'subasta_id' => 2,
            'url' => 'https://jspecauto.s3.amazonaws.com/wp-content/uploads/2024/04/dsc-0340-2010-2015-toyota-prius-hybrid-2zr-fxe-p410-automatic-transmission-for-sale-copy.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $dato = new img_subasta();
        $dato->subasta_id = 3;
        $dato->url = 'https://http2.mlstatic.com/D_NQ_NP_642136-MLM85729579280_062025-O.webp';
        $dato->save();

        $dato = new img_subasta();
        $dato->subasta_id = 4;
        $dato->url = 'https://http2.mlstatic.com/D_NQ_NP_660853-MLM48851682860_012022-O.webp';
        $dato->save();
    }
}
