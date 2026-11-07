<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   
        public function run(): void
{
    $this->call(usersSeeder::class);
    $this->call(subastasSeeder::class);
    $this->call(ofertasSeeder::class); // Súbelo aquí
    $this->call(pedidosSeeder::class);
    $this->call(resenasSeeder::class);
    
    // Los de imágenes pueden ir al final
    $this->call(img_subastasSeeder::class);
    $this->call(direccionesSeeder::class);
}

        
    
}
