<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\DetailPresensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardAdminController extends Controller
{
    // Menampilkan Dashboard Admin
    public function index()
    {
        // Ambil semua data kelas dari tabel kelas
        $kelasList = Kelas::all();

        // Tampilkan view dashboard di luar folder admin
        return view('dashboard', compact('kelasList'));  // Pastikan path-nya sesuai dengan tempat view disimpan
    }

    // Fungsi untuk memperbarui data dashboard berdasarkan kelas yang dipilih
    public function updateDashboardAdmin(Request $request)
    {
        $kelasId = $request->input('kelas', null); // Ambil kelas dari request

        // Ambil data presensi berdasarkan kelas yang dipilih dan tanggal hari ini
        $presensiData = DetailPresensi::with('user.kelas')
            ->whereHas('user', function($query) use ($kelasId) {
                if ($kelasId) {
                    $query->where('kelas_id', $kelasId); // Filter berdasarkan kelas
                }
            })
            ->whereDate('waktu_presensi', Carbon::today())
            ->get();

        // Hitung jumlah kehadiran, izin, alpa untuk kelas yang dipilih
        $jumlahHadir = $presensiData->where('kehadiran', 'Hadir')->count();
        $jumlahIzin = $presensiData->where('kehadiran', 'Izin')->count();
        $jumlahAlpa = $presensiData->where('kehadiran', 'Alpa')->count();

        // Ambil data suhu dan status relay dari Firebase
        $firebaseData = Http::get('https://smartsmn4-default-rtdb.asia-southeast1.firebasedatabase.app/ds18b20.json');
        $firebaseData = $firebaseData->json();

        // Ambil status relay dan suhu dari Firebase
        $relayStatus = $firebaseData['relay_status'] ?? 'OFF';
        $temperature = $firebaseData['temperature'] ?? 'N/A'; // Default 'N/A' jika tidak ada data suhu

        // Ambil status kehadiran guru
        $guruHadir = 'Tidak Hadir'; // Default
        $guruPresensi = DetailPresensi::whereHas('user', function($query) {
                $query->where('role', 'guru');
            })
            ->whereDate('waktu_presensi', Carbon::today())
            ->exists();

        if ($guruPresensi) {
            $guruHadir = 'Hadir';
        }

        // Mengembalikan data dalam format JSON
        return response()->json([
            'presensiData' => $presensiData,
            'jumlahHadir' => $jumlahHadir,
            'jumlahIzin' => $jumlahIzin,
            'jumlahAlpa' => $jumlahAlpa,
            'relayStatus' => $relayStatus,
            'temperature' => $temperature,
            'guruHadir' => $guruHadir,
        ]);
    }
}
