<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id('id_jadwal_pelajaran');
            $table->date('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('kelas', ['10', '11', '12']); // Kolom kelas sebagai enum
            $table->enum('multimedia', ['Multimedia 1', 'Multimedia 2']); // Kolom multimedia sebagai enum
            $table->unsignedBigInteger('id_mata_pelajaran'); // Hubungan dengan tabel mataPelajaran
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajaran')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajaran');
    }
};
