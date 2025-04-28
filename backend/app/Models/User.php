<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'nik', 'nama', 'kelas', 'no_hp_siswa', 'nama_ortu', 'no_hp_ortu', 'username', 'password', 'role', 'foto','face_encoding'
    ];
}
