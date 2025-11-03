<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Import model User
use Illuminate\Support\Facades\Hash; // <-- Import Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus user lama jika ada (opsional)
        User::truncate();

        // Buat 1 user admin
        User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.id', // Ini email login Anda
            'password' => Hash::make('password'), // Ini password Anda
        ]);
    }
}
