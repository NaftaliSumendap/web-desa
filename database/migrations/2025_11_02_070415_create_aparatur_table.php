<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        // Langkah 1: Buat tabel dan semua kolomnya
        Schema::create('aparaturs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('jabatan');
            $table->string('foto')->nullable();
            
            // Definisikan kolomnya saja, jangan foreign key dulu
            $table->unsignedBigInteger('parent_id')->nullable(); 
            
            $table->integer('urutan')->default(0); 
            $table->timestamps();
        });

        // Langkah 2: Tambahkan foreign key setelah tabelnya PASTI ada
        Schema::table('aparaturs', function (Blueprint $table) {
            // Baru tambahkan constraint di sini
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('aparaturs') // Merujuk ke tabel 'aparatur'
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aparaturs');
    }
};
