<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // 1. Tambahkan ini
use App\Models\VillageProfile;      // 2. Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 3. Tambahkan kode ini
        try {
            // Ambil data desa (ID=1)
            $desa = VillageProfile::firstOrCreate(['id' => 1]);
            
            // Bagikan variabel $desa ke SEMUA view
            View::share('desa', $desa);

        } catch (\Exception $e) {
            // Tangani error jika database belum siap
            View::share('desa', (object)[
                'name' => 'Nama Desa',
                'kabupaten' => 'Nama Kabupaten',
                'logo' => null,
                'address' => 'Alamat Kantor',
                'kecamatan' => 'Nama Kecamatan',
                'provinsi' => 'Nama Provinsi',
                'telepon' => '08xxxxxxxx',
                'email' => 'email@desa.id',
            ]);
        }
    }
}