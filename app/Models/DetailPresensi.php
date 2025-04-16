<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPresensi extends Model
{
    protected $table = 'detail_presensi'; // Tentukan nama tabel secara eksplisit

    protected $fillable = [
        'waktu_presensi',
        'kehadiran',
        'jenis_absen',
        'id_user',
        'id_presensi',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function presensi(): BelongsTo {
        return $this->belongsTo(Presensi::class, 'id_presensi');
    }
}