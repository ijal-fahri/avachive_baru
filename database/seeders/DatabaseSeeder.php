<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil OwnerSeeder yang baru kita buat
        $this->call([
            OwnerSeeder::class,
            // Anda bisa menambahkan seeder lain di sini jika perlu
        ]);
    }
}