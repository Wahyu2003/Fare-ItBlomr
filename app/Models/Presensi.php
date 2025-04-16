<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presensi extends Model
{
    protected $table = 'presensi'; // Tentukan nama tabel secara eksplisit

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'id_kelas'
    ];

    public function kelas(): BelongsTo {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function detailPresensi(): HasMany {
        return $this->hasMany(DetailPresensi::class, 'id_presensi');
    }
}