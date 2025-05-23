<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas'; // Tentukan nama tabel secara eksplisit

    protected $fillable = [
        'nama_kelas'
    ];

    public function presensi(): HasMany {
        return $this->hasMany(Presensi::class, 'id_kelas');
    }
}