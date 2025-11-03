<?php

namespace App\Http\Controllers;

// 1. Tambahkan "use" statement ini
use App\Models\Desa;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // 2. Tambahkan method __construct() ini
    public function __construct()
    {
        // Cek jika tabel 'desas' ada, untuk mencegah error saat migrasi
        if (Schema::hasTable('desa')) {
            
            // Ambil data desa
            $desa = Desa::first();
            
            // Bagikan data $desa ke SEMUA file view
            View::share('desa', $desa);
        }
    }
}