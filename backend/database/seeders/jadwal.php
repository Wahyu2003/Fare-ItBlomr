<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\User;
use Carbon\Carbon;

class jadwal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data guru
        $guruAbdulMajid = User::where('nama', 'like', '%Abdul Majid%')->first();
        $guruSriWinami = User::where('nama', 'like', '%Sri Winami%')->first();
        $guruSriFitri = User::where('nama', 'like', '%Sri Fitri Widlastuti%')->first();
        $guruMarzuki = User::where('nama', 'like', '%Marzuki%')->first();
        $guruIkhwan = User::where('nama', 'like', '%Ikhwan Sahroni%')->first();
        $guruNiken = User::where('nama', 'like', '%Niken Hildawati%')->first();
        $guruSupriyanto = User::where('nama', 'like', '%Supriyanto%')->first();
        $guruEka = User::where('nama', 'like', '%Eka Wulandari%')->first();
        $guruAnis = User::where('nama', 'like', '%Anis Fitriyanti%')->first();
        $guruLufita = User::where('nama', 'like', '%Lufita Krismarini%')->first();

        // Ambil mata pelajaran
        $mapelPJOK = MataPelajaran::where('nama_mata_pelajaran', 'Pend. Jasmani, Olahraga Kesehatan')->first();
        $mapelSejarah = MataPelajaran::where('nama_mata_pelajaran', 'Sejarah')->first();
        $mapelBInggris = MataPelajaran::where('nama_mata_pelajaran', 'Bahasa Inggris')->first();
        $mapelMatematika = MataPelajaran::where('nama_mata_pelajaran', 'Matematika')->first();
        $mapelAkuntansi = MataPelajaran::where('nama_mata_pelajaran', 'Akuntansi Keuangan')->first();
        $mapelPajak = MataPelajaran::where('nama_mata_pelajaran', 'Akuntansi Pemerintahan Desa')->first();
        $mapelKomputerAkuntansi = MataPelajaran::where('nama_mata_pelajaran', 'Komputer Akuntansi')->first();
        $mapelSiklusAkuntansi = MataPelajaran::where('nama_mata_pelajaran', 'Siklus Akuntansi Perusahaan')->first();
        $mapelSIA = MataPelajaran::where('nama_mata_pelajaran', 'Sistem Informasi Akuntansi')->first();
        $mapelBK = MataPelajaran::where('nama_mata_pelajaran', 'BK')->first();
        $mapelPKK = MataPelajaran::where('nama_mata_pelajaran', 'Projek Kreatif Kewirausahaan')->first();

        // Data jadwal pelajaran
        $jadwalPelajaran = [
            // Senin
            [
                'hari' => 'Senin',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
                'ruangan' => 'AKL.3',
                'guru_id' => $guruSupriyanto->id_user,
                'id_mata_pelajaran' => $mapelPajak->id_mata_pelajaran,
                // Kelas dan multimedia akan diambil dari mata pelajaran
            ],
            [
                'hari' => 'Senin',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '10:00:00',
                'ruangan' => 'AKL.1',
                'guru_id' => $guruEka->id_user,
                'id_mata_pelajaran' => $mapelAkuntansi->id_mata_pelajaran,
            ],

            // Selasa
            [
                'hari' => 'Selasa',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
                'ruangan' => 'AKL.6',
                'guru_id' => $guruIkhwan->id_user,
                'id_mata_pelajaran' => $mapelSiklusAkuntansi->id_mata_pelajaran,
            ],
            [
                'hari' => 'Selasa',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '10:00:00',
                'ruangan' => 'AKL.4',
                'guru_id' => $guruSriFitri->id_user,
                'id_mata_pelajaran' => $mapelKomputerAkuntansi->id_mata_pelajaran,
            ],

            // Rabu
            [
                'hari' => 'Rabu',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
                'ruangan' => 'A4',
                'guru_id' => $guruLufita->id_user,
                'id_mata_pelajaran' => $mapelPJOK->id_mata_pelajaran,
            ],
            [
                'hari' => 'Rabu',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '10:00:00',
                'ruangan' => 'BK',
                'guru_id' => $guruAbdulMajid->id_user,
                'id_mata_pelajaran' => $mapelBK->id_mata_pelajaran,
            ],

            // Kamis
            [
                'hari' => 'Kamis',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
                'ruangan' => 'A1',
                'guru_id' => $guruSriWinami->id_user,
                'id_mata_pelajaran' => $mapelBK->id_mata_pelajaran,
            ],
            [
                'hari' => 'Kamis',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '10:00:00',
                'ruangan' => 'B2',
                'guru_id' => $guruNiken->id_user,
                'id_mata_pelajaran' => $mapelBInggris->id_mata_pelajaran,
            ],

            // Jumat
            [
                'hari' => 'Jumat',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
                'ruangan' => 'A3',
                'guru_id' => $guruMarzuki->id_user,
                'id_mata_pelajaran' => $mapelMatematika->id_mata_pelajaran,
            ],
            [
                'hari' => 'Jumat',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '10:00:00',
                'ruangan' => 'A2',
                'guru_id' => $guruAnis->id_user,
                'id_mata_pelajaran' => $mapelSejarah->id_mata_pelajaran,
            ],
        ];

        foreach ($jadwalPelajaran as $jadwal) {
            // Ambil data kelas dan multimedia dari mata pelajaran
            $mataPelajaran = MataPelajaran::find($jadwal['id_mata_pelajaran']);
            
            JadwalPelajaran::create([
                'hari' => $jadwal['hari'],
                'jam_mulai' => $jadwal['jam_mulai'],
                'jam_selesai' => $jadwal['jam_selesai'],
                'ruangan' => $jadwal['ruangan'],
                'guru_id' => $jadwal['guru_id'],
                'id_mata_pelajaran' => $jadwal['id_mata_pelajaran'],
                'kelas' => $mataPelajaran->kelas,
                'multimedia' => $mataPelajaran->multimedia
            ]);
        }
    }
}