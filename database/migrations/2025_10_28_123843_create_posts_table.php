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
    // PERBAIKAN: "publicS" diubah menjadi "public"
    public function up() 
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Kolom untuk judul
            $table->string('kategori')->default('pemerintahan'); // Kolom untuk kategori
            $table->text('isi_berita'); // Kolom untuk isi berita
            $table->string('gambar')->nullable(); // Kolom untuk path gambar (boleh kosong)
            $table->timestamps(); // Otomatis membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
