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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id(); // Kolom 'id' auto-increment
            $table->string('judul');
            $table->string('kategori');
            $table->text('isi_berita'); // 'text' untuk konten yang panjang
            $table->string('gambar')->nullable(); // 'nullable' berarti boleh kosong
            $table->string('slug')->unique()->nullable(); // 'unique' agar tidak ada yg sama
            // $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Contoh jika dihubungkan ke user
            $table->timestamps(); // Kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beritas');
    }
};