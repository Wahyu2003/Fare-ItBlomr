<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

// class User extends Model
class User extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id_user';
    protected $hidden = ['password'];
    protected $dates = ['deleted_at'];
    protected $guarded = [];


    protected $fillable = [
        'nik', 'nama', 'kelas_id', 'no_hp_siswa', 'nama_ortu', 'no_hp_ortu', 'username', 'password', 'role', 'foto', 'face_encoding'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class, 'id_user', 'id_user');
    }
}
