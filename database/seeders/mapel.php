<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\JadwalPelajaran;

class mapel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder untuk Mata Pelajaran dengan kode ruangan
$mataPelajaran = [
    [
        'nama_mata_pelajaran' => 'Pend. Jasmani, Olahraga Kesehatan',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Sejarah',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Bahasa Inggris',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Matematika',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Akuntansi Keuangan',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Akuntansi Pemerintahan Desa',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Komputer Akuntansi',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Siklus Akuntansi Perusahaan',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Sistem Informasi Akuntansi',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'BK',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ],
    [
        'nama_mata_pelajaran' => 'Projek Kreatif Kewirausahaan',
        'kelas' => '11',
        'multimedia' => 'Multimedia 1'
    ]
];

foreach ($mataPelajaran as $mp) {
    MataPelajaran::create($mp);
}
    }
}
