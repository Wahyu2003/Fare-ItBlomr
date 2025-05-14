<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class siswa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siswaData = [];

        // Kelas 10 - 8 siswa
        $siswaData = array_merge($siswaData, [
            [
                'nik' => '102023001',
                'nama' => 'Ahmad Fauzi',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 1',
                'nama_ortu' => 'Budi Santoso',
                'no_hp_ortu' => '081234567891',
                'no_hp_siswa' => '081234567811',
                'username' => 'ahmadf10',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '102023002',
                'nama' => 'Bella Putri',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 2',
                'nama_ortu' => 'Dewi Lestari',
                'no_hp_ortu' => '081234567892',
                'no_hp_siswa' => '081234567812',
                'username' => 'bella10',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '102023003',
                'nama' => 'Cahyo Nugroho',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 1',
                'nama_ortu' => 'Eko Prasetyo',
                'no_hp_ortu' => '081234567893',
                'no_hp_siswa' => '081234567813',
                'username' => 'cahyo10',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '102023004',
                'nama' => 'Dinda Rahma',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 2',
                'nama_ortu' => 'Fajar Setiawan',
                'no_hp_ortu' => '081234567894',
                'no_hp_siswa' => '081234567814',
                'username' => 'dinda10',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '102023005',
                'nama' => 'Eko Prasetyo',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 1',
                'nama_ortu' => 'Gunawan Wibowo',
                'no_hp_ortu' => '081234567895',
                'no_hp_siswa' => '081234567815',
                'username' => 'eko10',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '102023006',
                'nama' => 'Fitri Ayu',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 2',
                'nama_ortu' => 'Hendra Kurniawan',
                'no_hp_ortu' => '081234567896',
                'no_hp_siswa' => '081234567816',
                'username' => 'fitri10',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '102023007',
                'nama' => 'Gilang Ramadhan',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 1',
                'nama_ortu' => 'Indra Lesmana',
                'no_hp_ortu' => '081234567897',
                'no_hp_siswa' => '081234567817',
                'username' => 'gilang10',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '102023008',
                'nama' => 'Hana Safitri',
                'role' => 'siswa',
                'kelas' => '10 Multimedia 2',
                'nama_ortu' => 'Joko Susilo',
                'no_hp_ortu' => '081234567898',
                'no_hp_siswa' => '081234567818',
                'username' => 'hana10',
                'password' => bcrypt('siswa123'),
            ],
        ]);

        // Kelas 11 - 7 siswa
        $siswaData = array_merge($siswaData, [
            [
                'nik' => '112023001',
                'nama' => 'Irfan Maulana',
                'role' => 'siswa',
                'kelas' => '11 Multimedia 1',
                'nama_ortu' => 'Kurniawan Adi',
                'no_hp_ortu' => '081234567901',
                'no_hp_siswa' => '081234567821',
                'username' => 'irfan11',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '112023002',
                'nama' => 'Jihan Aulia',
                'role' => 'siswa',
                'kelas' => '11 Multimedia 2',
                'nama_ortu' => 'Lukman Hakim',
                'no_hp_ortu' => '081234567902',
                'no_hp_siswa' => '081234567822',
                'username' => 'jihan11',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '112023003',
                'nama' => 'Kevin Pratama',
                'role' => 'siswa',
                'kelas' => '11 Multimedia 1',
                'nama_ortu' => 'Maman Abdurahman',
                'no_hp_ortu' => '081234567903',
                'no_hp_siswa' => '081234567823',
                'username' => 'kevin11',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '112023004',
                'nama' => 'Lia Amelia',
                'role' => 'siswa',
                'kelas' => '11 Multimedia 2',
                'nama_ortu' => 'Nur Hidayat',
                'no_hp_ortu' => '081234567904',
                'no_hp_siswa' => '081234567824',
                'username' => 'lia11',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '112023005',
                'nama' => 'Muhammad Rizky',
                'role' => 'siswa',
                'kelas' => '11 Multimedia 1',
                'nama_ortu' => 'Oki Setiawan',
                'no_hp_ortu' => '081234567905',
                'no_hp_siswa' => '081234567825',
                'username' => 'rizky11',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '112023006',
                'nama' => 'Nadia Putri',
                'role' => 'siswa',
                'kelas' => '11 Multimedia 2',
                'nama_ortu' => 'Puji Astuti',
                'no_hp_ortu' => '081234567906',
                'no_hp_siswa' => '081234567826',
                'username' => 'nadia11',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '112023007',
                'nama' => 'Oki Setiawan',
                'role' => 'siswa',
                'kelas' => '11 Multimedia 1',
                'nama_ortu' => 'Qori Hidayat',
                'no_hp_ortu' => '081234567907',
                'no_hp_siswa' => '081234567827',
                'username' => 'oki11',
                'password' => bcrypt('siswa123'),
            ],
        ]);

        // Kelas 12 - 6 siswa
        $siswaData = array_merge($siswaData, [
            [
                'nik' => '122023001',
                'nama' => 'Putri Ayu',
                'role' => 'siswa',
                'kelas' => '12 Multimedia 1',
                'nama_ortu' => 'Rudi Hartono',
                'no_hp_ortu' => '081234567911',
                'no_hp_siswa' => '081234567831',
                'username' => 'putri12',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '122023002',
                'nama' => 'Qori Hidayat',
                'role' => 'siswa',
                'kelas' => '12 Multimedia 2',
                'nama_ortu' => 'Siti Nurhaliza',
                'no_hp_ortu' => '081234567912',
                'no_hp_siswa' => '081234567832',
                'username' => 'qori12',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '122023003',
                'nama' => 'Rizki Ramadhan',
                'role' => 'siswa',
                'kelas' => '12 Multimedia 1',
                'nama_ortu' => 'Tono Wijaya',
                'no_hp_ortu' => '081234567913',
                'no_hp_siswa' => '081234567833',
                'username' => 'rizki12',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '122023004',
                'nama' => 'Siti Rahma',
                'role' => 'siswa',
                'kelas' => '12 Multimedia 2',
                'nama_ortu' => 'Umar Said',
                'no_hp_ortu' => '081234567914',
                'no_hp_siswa' => '081234567834',
                'username' => 'siti12',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '122023005',
                'nama' => 'Tegar Prakoso',
                'role' => 'siswa',
                'kelas' => '12 Multimedia 1',
                'nama_ortu' => 'Vino G Bastian',
                'no_hp_ortu' => '081234567915',
                'no_hp_siswa' => '081234567835',
                'username' => 'tegar12',
                'password' => bcrypt('siswa123'),
            ],
            [
                'nik' => '122023006',
                'nama' => 'Umi Kulsum',
                'role' => 'siswa',
                'kelas' => '12 Multimedia 2',
                'nama_ortu' => 'Wahyu Nugroho',
                'no_hp_ortu' => '081234567916',
                'no_hp_siswa' => '081234567836',
                'username' => 'umi12',
                'password' => bcrypt('siswa123'),
            ],
        ]);

        foreach ($siswaData as $data) {
            User::create($data);
        }
    }
}