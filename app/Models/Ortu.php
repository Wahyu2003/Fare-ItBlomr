<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ortu extends Model
{
    protected $table = 'ortu'; // Tentukan nama tabel secara eksplisit

    protected $fillable = [
        'nama',
        'username',
        'no_hp',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class, 'id_ortu');
    }
}