<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class guru extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder untuk Guru
$gurus = [
    [
        'nik' => '1234567890123456',
        'nama' => 'Sri Winami, S.Pd.',
        'username' => 'sriwinami',
        'password' => 'password123', // Tanpa hash
        'role' => 'guru',
        'no_hp_siswa' => '081234567890',
        'foto' => 'fotos/guru1.jpg'
    ],
    [
        'nik' => '2345678901234567',
        'nama' => 'Sri Fitri Widlastuti, S.Pd.',
        'username' => 'srifitri',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '082345678901',
        'foto' => 'fotos/guru2.jpg'
    ],
    [
        'nik' => '3456789012345678',
        'nama' => 'Marzuki, S.Pd.',
        'username' => 'marzuki',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '083456789012',
        'foto' => 'fotos/guru3.jpg'
    ],
    [
        'nik' => '4567890123456789',
        'nama' => 'Ikhwan Sahroni M. El M. S.Ak',
        'username' => 'ikhwan',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '084567890123',
        'foto' => 'fotos/guru4.jpg'
    ],
    [
        'nik' => '5678901234567890',
        'nama' => 'Niken Hildawati, S.Pd.',
        'username' => 'niken',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '085678901234',
        'foto' => 'fotos/guru5.jpg'
    ],
    [
        'nik' => '6789012345678901',
        'nama' => 'M. Munali, S.Pd.',
        'username' => 'munali',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '086789012345',
        'foto' => 'fotos/guru6.jpg'
    ],
    [
        'nik' => '7890123456789012',
        'nama' => 'Lufita Krismarini, S.Pd.',
        'username' => 'lufita',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '087890123456',
        'foto' => 'fotos/guru7.jpg'
    ],
    [
        'nik' => '8901234567890123',
        'nama' => 'Abdul Majid, S.Pd.I.',
        'username' => 'abdulmajid',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '088901234567',
        'foto' => 'fotos/guru8.jpg'
    ],
    [
        'nik' => '9012345678901234',
        'nama' => 'Yuli Umi Rahayu, S.E., M.M.',
        'username' => 'yuliumi',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '089012345678',
        'foto' => 'fotos/guru9.jpg'
    ],
    [
        'nik' => '0123456789012345',
        'nama' => 'Anis Firinyanti, S.Pd.',
        'username' => 'anis',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '080123456789',
        'foto' => 'fotos/guru10.jpg'
    ],
    [
        'nik' => '1122334455667788',
        'nama' => 'Supriyanto, S.Pd.',
        'username' => 'supriyanto',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '081122334455',
        'foto' => 'fotos/guru11.jpg'
    ],
    [
        'nik' => '2233445566778899',
        'nama' => 'Yayuk Widhyawati, S.S',
        'username' => 'yayuk',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '082233445566',
        'foto' => 'fotos/guru12.jpg'
    ],
    [
        'nik' => '3344556677889900',
        'nama' => 'Eka Wulandari F., S.Pd., M.Pd.',
        'username' => 'eka',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '083344556677',
        'foto' => 'fotos/guru13.jpg'
    ],
    [
        'nik' => '4455667788990011',
        'nama' => 'Margiyanto, S.Pd., M.P.',
        'username' => 'margiyanto',
        'password' => 'password123',
        'role' => 'guru',
        'no_hp_siswa' => '084455667788',
        'foto' => 'fotos/guru14.jpg'
    ]
];

foreach ($gurus as $guru) {
    User::create($guru);
}
    }
}
