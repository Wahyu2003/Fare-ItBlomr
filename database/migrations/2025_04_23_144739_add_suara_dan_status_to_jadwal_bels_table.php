<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jadwal_bel', function (Blueprint $table) {
            $table->string('file_suara')->nullable(); // Untuk menyimpan path file suara
            $table->boolean('aktif')->default(true);  // Untuk status aktif/tidak aktif
        });
    }
    
    public function down()
    {
        Schema::table('jadwal_bels', function (Blueprint $table) {
            $table->dropColumn(['file_suara', 'aktif']);
        });
    }
    
};
