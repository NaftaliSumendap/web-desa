<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Pastikan nama tabelnya 'desa' sesuai permintaan Anda
        Schema::create('desa', function (Blueprint $table) {
            $table->id(); // Akan kita gunakan ID=1

            // Info Dasar (BARU)
            $table->string('name')->default('Desa Tombasian Atas');
            $table->string('slug')->default('tombasian-atas');
            $table->string('logo')->nullable();
            $table->string('kepala_desa')->nullable();
            
            // Visi, Misi, Sejarah (Sudah Ada)
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('sejarah')->nullable();
            
            // Info Kontak (Sudah Ada + BARU)
            $table->string('address')->nullable(); // Ganti dari alamat_kantor
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('jam_kerja')->nullable();

            // Info Wilayah (Sudah Ada + BARU)
            $table->string('luas_wilayah')->nullable();
            $table->text('batas_wilayah')->nullable();
            $table->text('kondisi_topografi')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desa');
    }
};
