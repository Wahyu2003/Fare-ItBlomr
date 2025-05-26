<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama_kelas'
    ];
}
