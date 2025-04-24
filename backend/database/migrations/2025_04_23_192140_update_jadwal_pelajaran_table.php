<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            // Hapus kolom kelas dan multimedia
            $table->dropColumn(['kelas', 'multimedia']);
            
            // Tambahkan kolom ruangan
            $table->string('ruangan')->nullable()->after('jam_selesai');
            
            // Tambahkan kolom guru_id sebagai foreign key ke tabel users
            $table->unsignedBigInteger('guru_id')->nullable()->after('id_mata_pelajaran');
            $table->foreign('guru_id')->references('id_user')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            // Tambah kembali kolom kelas dan multimedia
            $table->enum('kelas', ['10', '11', '12'])->after('jam_selesai');
            $table->enum('multimedia', ['Multimedia 1', 'Multimedia 2'])->after('kelas');
            
            // Hapus kolom ruangan dan guru_id
            $table->dropColumn('ruangan');
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });
    }
};