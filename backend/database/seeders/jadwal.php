<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalPelajaran;
use App\Models\User;
use App\Models\MataPelajaran;

class jadwal extends Seeder
{
    public function run()
    {
        // Ambil data guru saja (role = guru)
        $guruIds = User::where('role', 'guru')->pluck('id_user')->toArray();

        // Ambil semua mata pelajaran
        $mapelIds = MataPelajaran::pluck('id_mata_pelajaran')->toArray();

        // Contoh hari yang dipakai di enum
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Data dummy jadwal pelajaran, contoh tiap guru dapat beberapa jadwal
        $jadwalPelajaranData = [
            [
                'hari' => 'Senin',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
                'ruangan' => 'A101',
                'id_mata_pelajaran' => $mapelIds[0] ?? 1,
                'guru_id' => $guruIds[0] ?? 1,
            ],
            [
                'hari' => 'Selasa',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '10:00:00',
                'ruangan' => 'B201',
                'id_mata_pelajaran' => $mapelIds[1] ?? 2,
                'guru_id' => $guruIds[1] ?? 2,
            ],
            [
                'hari' => 'Rabu',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '11:30:00',
                'ruangan' => 'C301',
                'id_mata_pelajaran' => $mapelIds[2] ?? 3,
                'guru_id' => $guruIds[0] ?? 1,
            ],
            [
                'hari' => 'Kamis',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '14:30:00',
                'ruangan' => 'A101',
                'id_mata_pelajaran' => $mapelIds[3] ?? 4,
                'guru_id' => $guruIds[1] ?? 2,
            ],
            [
                'hari' => 'Jumat',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
                'ruangan' => 'B201',
                'id_mata_pelajaran' => $mapelIds[4] ?? 5,
                'guru_id' => $guruIds[0] ?? 1,
            ],
        ];

        foreach ($jadwalPelajaranData as $jadwal) {
            JadwalPelajaran::create($jadwal);
        }
    }
}
