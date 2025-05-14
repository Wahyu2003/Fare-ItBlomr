<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_presensi', function (Blueprint $table) {
            $table->id('id_detail_presensi');
            $table->dateTime('waktu_presensi');
            $table->enum('kehadiran', ['tepat waktu', 'telat', 'alpha', 'izin', 'sakit']);
            $table->enum('jenis_absen', ['belum keluar', 'pulang', 'tidak hadir','masuk']);
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_jadwal_pelajaran'); // Ubah dari id_presensi ke id_jadwal_pelajaran
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_jadwal_pelajaran')->references('id_jadwal_pelajaran')->on('jadwal_pelajaran')->onDelete('cascade'); // Ubah referensi ke jadwal_pelajaran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_presensi');
    }
};
