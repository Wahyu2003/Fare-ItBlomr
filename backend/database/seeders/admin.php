<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $gurus = [
        [
            'nik' => '3456789',
            'nama' => 'admin',
            'username' => 'admin2',
            'password' => bcrypt('admin2'), // Menggunakan hash Bcrypt Laravel
            'role' => 'admin',
            'no_hp_siswa' => null,
            'foto' => null
        ]
    ];

    foreach ($gurus as $guru) {
        User::create($guru);
    }

    }
}
