<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mapel', function (Blueprint $table) {
            $table->id('id_mapel'); // Kolom id_mapel sebagai primary key
            $table->string('nama_mapel'); // Kolom nama_mapel untuk nama mata pelajaran
            $table->time('jam'); // Kolom jam untuk waktu mata pelajaran
            $table->unsignedBigInteger('id_kelas'); // Kolom id_kelas untuk relasi dengan tabel kelas
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraint
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel');
    }
};
