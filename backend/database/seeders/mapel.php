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
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Pend. Jasmani, Olahraga Kesehatan',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Sejarah',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Sejarah',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Bahasa Inggris',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Bahasa Inggris',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Matematika',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Matematika',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Akuntansi Keuangan',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Akuntansi Keuangan',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Akuntansi Pemerintahan Desa',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Akuntansi Pemerintahan Desa',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Komputer Akuntansi',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Komputer Akuntansi',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Siklus Akuntansi Perusahaan',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Siklus Akuntansi Perusahaan',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Sistem Informasi Akuntansi',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Sistem Informasi Akuntansi',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'BK',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'BK',
                'kelas_id' => '2',
            ],
            [
                'nama_mata_pelajaran' => 'Projek Kreatif Kewirausahaan',
                'kelas_id' => '1',
            ],
            [
                'nama_mata_pelajaran' => 'Projek Kreatif Kewirausahaan',
                'kelas_id' => '2',
            ]
        ];

        foreach ($mataPelajaran as $mp) {
            MataPelajaran::create($mp);
        }
    }
}