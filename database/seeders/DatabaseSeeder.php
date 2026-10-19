<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Memanggil UnitSeeder yang baru kita buat
        $this->call([
            UnitSeeder::class,
        ]);
    }
}