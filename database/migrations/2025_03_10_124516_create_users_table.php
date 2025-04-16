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
            $table->enum("role", ['admin', 'guru', 'siswa']);
            $table->text('face_encoding')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('kelas')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_ortu')->nullable();
            $table->foreign('id_ortu')->references('id_ortu')->on('ortu')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};