<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Tentukan nama tabel secara eksplisit

    protected $fillable = [
        'nik',
        'nama',
        'username',
        'role',
        'face_encoding',
        'no_hp',
        'kelas',
        'foto',
        'password',
        'id_ortu'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function detailPresensi(): HasMany {
        return $this->hasMany(DetailPresensi::class, 'id_user');
    }

    public function ortu(): BelongsTo {
        return $this->belongsTo(Ortu::class, 'id_ortu');
    }
}