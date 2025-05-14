<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan beberapa data user sebagai contoh dengan data yang lebih realistis
        DB::table('users')->insert([
            [
                'nik' => '3172012345678901',
                'nama' => 'Andi Pratama',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'kelas_id' => null,
                'foto' => 'admin.jpg',
                'nama_ortu' => null,
                'no_hp_ortu' => null,
            ],
            [
                'nik' => '3172012345678902',
                'nama' => 'Budi Santoso',
                'username' => 'budi.santoso',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'kelas_id' => 1, // Kelas 10 Multimedia 1
                'foto' => 'guru1.jpg',
                'nama_ortu' => null,
                'no_hp_ortu' => null,
            ],
            [
                'nik' => '3172012345678903',
                'nama' => 'Citra Dewi',
                'username' => 'citra.dewi',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'kelas_id' => 2, // Kelas 10 Multimedia 2
                'foto' => 'guru2.jpg',
                'nama_ortu' => null,
                'no_hp_ortu' => null,
            ],
            [
                'nik' => '3172012345678904',
                'nama' => 'Dian Novita',
                'username' => 'dian.novita',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'kelas_id' => 1, // Kelas 10 Multimedia 1
                'foto' => 'siswa1.jpg',
                'nama_ortu' => 'Ibu Siti',
                'no_hp_ortu' => '081234567890',
            ],
            [
                'nik' => '3172012345678905',
                'nama' => 'Eka Rahmawati',
                'username' => 'eka.rahmawati',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'kelas_id' => 1, // Kelas 10 Multimedia 1
                'foto' => 'siswa2.jpg',
                'nama_ortu' => 'Bapak Joko',
                'no_hp_ortu' => '081298765432',
            ],
            [
                'nik' => '3172012345678906',
                'nama' => 'Farhan Alfarisi',
                'username' => 'farhan.alfarisi',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'kelas_id' => 2, // Kelas 10 Multimedia 2
                'foto' => 'siswa3.jpg',
                'nama_ortu' => 'Ibu Ani',
                'no_hp_ortu' => '082134567890',
            ],
            [
                'nik' => '3172012345678907',
                'nama' => 'Galih Nugraha',
                'username' => 'galih.nugraha',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'kelas_id' => 2, // Kelas 10 Multimedia 2
                'foto' => 'siswa4.jpg',
                'nama_ortu' => 'Bapak Bambang',
                'no_hp_ortu' => '082298765432',
            ],
        ]);
    }
}
