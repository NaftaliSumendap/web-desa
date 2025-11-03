<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'kategori',
        'isi_berita',
        'gambar',
        'slug', // Tambahkan ini jika Anda berencana menggunakannya
        // 'user_id', // Tambahkan ini jika Anda ingin melacak siapa penulisnya
    ];
}