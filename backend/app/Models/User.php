<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_user';
    
    protected $fillable = [
        'nik', 'nama', 'kelas_id', 'no_hp_siswa', 'nama_ortu', 'no_hp_ortu', 'username', 'password', 'role', 'foto', 'face_encoding'
    ];

    // Relasi dengan model Kelas (untuk kelas_id)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }
}
