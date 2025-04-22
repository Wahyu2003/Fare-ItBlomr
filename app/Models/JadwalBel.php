<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBel extends Model
{
    use HasFactory;

    protected $table = 'jadwal_bel';  // Nama tabel
    
    protected $fillable = [
        'hari', 'jam', 'keterangan'
    ];
}