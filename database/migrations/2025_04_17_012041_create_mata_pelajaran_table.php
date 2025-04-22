<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id('id_mata_pelajaran');
            $table->string('nama_mata_pelajaran'); // Nama mata pelajaran
            $table->enum('kelas', ['10', '11', '12']); // Kelas
            $table->enum('multimedia', ['Multimedia 1', 'Multimedia 2']); // Jurusan multimedia
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};