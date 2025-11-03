<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post; // Pastikan model Post di-import

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus data lama (opsional, tapi bagus untuk seeder)
        Post::truncate();

        Post::create([
            'judul' => 'Kegiatan Gotong Royong Warga Desa Kersik',
            'kategori' => 'kemasyarakatan', // Tambahkan kategori
            'isi_berita' => 'Warga Desa Kersik mengadakan gotong royong untuk membersihkan lingkungan... (isi berita lengkap)',
            'gambar' => 'images/berita1.jpg' // Pastikan path ini benar
        ]);

        Post::create([
            'judul' => 'Penyuluhan Stunting oleh PKK Desa Kersik',
            'kategori' => 'pemerintahan', // Tambahkan kategori
            'isi_berita' => 'Tim PKK Desa Kersik memberikan penyuluhan pentingnya gizi untuk mencegah... (isi berita lengkap)',
            'gambar' => 'images/berita2.jpg'
        ]);

        Post::create([
            'judul' => 'Musyawarah Desa (Musdes) Penetapan APBDes 2025',
            'kategori' => 'pembangunan', // Tambahkan kategori
            'isi_berita' => 'Pemerintah Desa Kersik bersama BPD telah melaksanakan Musdes untuk... (isi berita lengkap)',
            'gambar' => 'images/berita3.jpg'
        ]);
    }
}