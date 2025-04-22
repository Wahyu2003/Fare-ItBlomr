<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropColumn('hari'); // Hapus kolom hari yang lama
        });

        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])->after('id_jadwal_pelajaran'); // Tambah kolom hari baru dengan enum
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropColumn('hari');
        });

        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->date('hari')->after('id_jadwal_pelajaran');
        });
    }
};