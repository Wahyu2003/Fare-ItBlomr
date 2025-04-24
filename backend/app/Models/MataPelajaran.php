<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mata_pelajaran';

    protected $fillable = [
        'nama_mata_pelajaran',
        'kelas',
        'multimedia',
    ];

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'id_mata_pelajaran');
    }
}