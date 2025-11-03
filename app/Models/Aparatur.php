<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aparatur extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = [
        'nama_lengkap',
        'jabatan',
        'foto',
        'parent_id', // ID atasan
        'urutan',    // Nomor urut
    ];

    
    // --- INI ADALAH PERBAIKANNYA ---

    /**
     * Mendefinisikan relasi ke atasan (satu aparatur memiliki satu atasan).
     * Ini adalah relasi "belongsTo" ke model Aparatur itu sendiri.
     */
    public function atasan()
    {
        // 'parent_id' adalah foreign key (kunci asing) di tabel 'aparaturs'
        // yang merujuk ke 'id' di tabel 'aparaturs' juga.
        return $this->belongsTo(Aparatur::class, 'parent_id');
    }

    /**
     * Mendefinisikan relasi ke bawahan (satu aparatur bisa punya banyak bawahan).
     * (Ini adalah kebalikan dari relasi atasan, berguna untuk bagan)
     */
    public function bawahan()
    {
        return $this->hasMany(Aparatur::class, 'parent_id')->orderBy('urutan');
    }
}

