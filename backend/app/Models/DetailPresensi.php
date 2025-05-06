<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPresensi extends Model
{
    protected $table = 'detail_presensi';
    protected $primaryKey = 'id_detail_presensi';

    protected $fillable = [
        'waktu_presensi',
        'kehadiran',
        'jenis_absen',
        'id_user',
        'id_jadwal_pelajaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function jadwalPelajaran(): BelongsTo
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal_pelajaran');
    }
}