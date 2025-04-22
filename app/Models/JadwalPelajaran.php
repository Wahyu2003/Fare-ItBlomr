<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';
    protected $primaryKey = 'id_jadwal_pelajaran';

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kelas',
        'multimedia',
        'id_mata_pelajaran',
    ];

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function detailPresensi(): HasMany
    {
        return $this->hasMany(DetailPresensi::class, 'id_jadwal_pelajaran');
    }
}