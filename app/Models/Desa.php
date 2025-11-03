<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';

    protected $fillable = [
        'name','slug','logo','address','kecamatan','kabupaten','provinsi',
        'kode_pos','telepon','email','website','kepala_desa','visi','misi',
        'latitude','longitude'
    ];
}