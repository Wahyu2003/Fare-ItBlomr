<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nik')->nullable();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum("role", ['admin', 'siswa', 'guru']);
            $table->text('face_encoding')->nullable();
            $table->string('no_hp_siswa')->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->string('foto')->nullable();
            $table->string('nama_ortu')->nullable();
            $table->string('no_hp_ortu')->nullable();
            $table->foreign('kelas_id')->references('id_kelas')->on('kelas')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
