<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBel extends Model
{
    use HasFactory;

    protected $table = 'jadwal_bel';

    protected $fillable = [
        'hari', 'tanggal', 'jam', 'keterangan', 'file_suara', 'aktif', 'is_manual'
    ];
}
