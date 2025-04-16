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
            $table->enum('jenis_absen', ['belum keluar', 'pulang', 'tidak hadir']);
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_presensi');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_presensi')->references('id_presensi')->on('presensi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_presensi');
    }
};