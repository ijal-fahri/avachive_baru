<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'owner', // Jadikan 'name' unik untuk login
            'usertype' => 'owner',
            'password' => Hash::make('password'), // Ganti password Anda
            'cabang_id' => null,
            // Hapus baris 'email'
        ]);
    }
}