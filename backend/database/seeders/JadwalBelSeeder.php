<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalBelSeeder extends Seeder
{
    public function run()
    {
        $jadwal = [];

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($hari as $h) {
            $jadwal[] = [
                'hari' => $h,
                'tanggal' => null, // jadwal rutin harian
                'jam' => '07:00:00',
                'keterangan' => 'Bel masuk pagi',
                'file_suara' => '0001',
                'aktif' => true,
                'is_manual' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $jadwal[] = [
                'hari' => $h,
                'tanggal' => null,
                'jam' => '12:00:00',
                'keterangan' => 'Bel istirahat siang',
                'file_suara' => '0001.mp3',
                'aktif' => true,
                'is_manual' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $jadwal[] = [
                'hari' => $h,
                'tanggal' => null,
                'jam' => '13:00:00',
                'keterangan' => 'Bel masuk siang',
                'file_suara' => '0001.mp3',
                'aktif' => true,
                'is_manual' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $jadwal[] = [
                'hari' => $h,
                'tanggal' => null,
                'jam' => '15:00:00',
                'keterangan' => 'Bel pulang',
                'file_suara' => '0001.mp3',
                'aktif' => true,
                'is_manual' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('jadwal_bel')->insert($jadwal);
    }
}
