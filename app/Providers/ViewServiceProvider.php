<?php

namespace App\Providers;

use App\Models\Desa;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // <-- 1. Tambahkan ini

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. Hapus/Ganti method boot() Anda dengan ini:

        // Kita cek dulu apakah tabel 'desas' sudah ada.
        // Ini sangat penting untuk mencegah error saat menjalankan 'php artisan migrate'
        // sebelum tabel 'desas' dibuat.
        if (Schema::hasTable('desa')) {
            
            // Ambil data desa SATU KALI saja.
            // Kita bisa cache ini nanti jika perlu, tapi 'first()' sudah cepat.
            $desa = Desa::first(); 
            
            // Bagikan variabel '$desa' ke SEMUA file view.
            View::share('desa', $desa);
        }
    }
}