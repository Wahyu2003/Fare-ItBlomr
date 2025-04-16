<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ortu', function (Blueprint $table) {
            $table->id('id_ortu');
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('no_hp');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ortu');
    }
};