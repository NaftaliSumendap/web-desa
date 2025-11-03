<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'desa';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'kepala_desa',
        'visi',
        'misi',
        'sejarah',
        'address',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'jam_kerja',
        'luas_wilayah',
        'batas_wilayah',
        'kondisi_topografi',
        'latitude',
        'longitude',
    ];
}