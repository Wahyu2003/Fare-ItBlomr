<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_bel', function (Blueprint $table) {
            $table->id();
            $table->string('hari')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam');
            $table->string('keterangan');
            $table->string('file_suara')->nullable();
            $table->boolean('aktif')->default(true);
            $table->boolean('is_manual')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_bel');
    }
};
