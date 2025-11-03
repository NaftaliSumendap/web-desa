<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (mass assignable).
     * Ini HARUS sesuai dengan nama kolom di form Anda.
     */
    protected $fillable = [
        'judul',
        'kategori',
        'isi_berita',
        'gambar',
    ];
}
