<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desa;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        Desa::updateOrCreate(
            ['slug' => 'tombasian-atas'],
            [
                'name' => 'Desa Tombasian Atas',
                'slug' => 'tombasian-atas',
                'logo' => 'images/logo-desa.png',
                'address' => 'Jl. Raya Tombasian, Jaga II',
                'kecamatan' => 'Kawangkoan Barat',
                'kabupaten' => 'Kabupaten Minahasa',
                'provinsi' => 'Sulawesi Utara',
                'kode_pos' => '12345',
                'telepon' => '0812-3456-7890',
                'email' => 'info@tombasian-atas.desa.id',
                'website' => 'https://desatombasian.test',
                'kepala_desa' => 'Bapak Contoh Nama',
                'visi' => 'Terwujudnya masyarakat sejahtera...',
                'misi' => 'Meningkatkan pelayanan publik, pembangunan infrastruktur...',
                'latitude' => '-0.0000000',
                'longitude' => '0.0000000',
            ]
        );
    }
}