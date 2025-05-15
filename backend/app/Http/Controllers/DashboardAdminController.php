<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPresensi;
use Illuminate\Support\Facades\Http;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    // Menampilkan Dashboard Admin
    public function index()
    {
        $kelasList = Kelas::all();

        $today = Carbon::today();
        $presensiData = DetailPresensi::whereDate('waktu_presensi', $today)
            ->with(['user.kelas'])
            ->get();

        // Hitung jumlah presensi berdasarkan status kehadiran
        $jumlahHadir = $presensiData->where('kehadiran', 'tepat waktu')->count();
        $jumlahIzin = $presensiData->where('kehadiran', 'izin')->count();
        $jumlahAlpa = $presensiData->where('kehadiran', 'alpha')->count();

        // Kirimkan data ke view
        return view('dashboard', compact('kelasList', 'presensiData', 'jumlahHadir', 'jumlahIzin', 'jumlahAlpa'));
    }

    // Fungsi untuk memperbarui data dashboard berdasarkan kelas yang dipilih
    public function updateDashboardAdmin(Request $request)
    {
        $kelasId = $request->input('kelas', null); // Ambil kelas dari request

        $today = Carbon::today();

        // Ambil data presensi berdasarkan kelas yang dipilih dan tanggal hari ini
        $presensiData = DetailPresensi::with('user.kelas')
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->whereHas('user', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->whereDate('waktu_presensi', $today)
            ->get();

        // Hitung jumlah presensi berdasarkan status kehadiran
        $jumlahHadir = $presensiData->where('kehadiran', 'tepat waktu')->count();
        $jumlahIzin = $presensiData->where('kehadiran', 'izin')->count();
        $jumlahAlpa = $presensiData->where('kehadiran', 'alpha')->count();

        // Ambil data suhu dan status relay dari Firebase
        $firebaseData = Http::get('https://smartsmn4-default-rtdb.asia-southeast1.firebasedatabase.app/ds18b20.json');
        $firebaseData = $firebaseData->json();
        $relayStatus = $firebaseData['relay_status'] ?? 'OFF';
        $temperature = $firebaseData['temperature'] ?? 'N/A';

        // Cek status kehadiran guru hari ini
        $guruHadir = DetailPresensi::whereDate('waktu_presensi', $today)
            ->whereHas('user', function ($q) {
                $q->where('role', 'guru');
            })
            ->exists();

        // Mengembalikan data dalam format JSON untuk dikonsumsi oleh front-end
        return response()->json([
            'dataSiswaHariIni' => $presensiData,
            'jumlahHadir' => $jumlahHadir,
            'jumlahIzin' => $jumlahIzin,
            'jumlahAlpa' => $jumlahAlpa,
            'relayStatus' => $relayStatus,
            'temperature' => $temperature,
            'guruHadir' => $guruHadir,
        ]);
    }

    public function presensiWajah()
    {
        $today = Carbon::today();

        $belumPresensi = User::whereDoesntHave('detailPresensi', function ($query) use ($today) {
            $query->whereDate('waktu_presensi', $today);
        })->with('kelas')->get();

        // Ambil data presensi hari ini beserta relasi user dan kelas
        $sudahPresensi = DetailPresensi::whereDate('waktu_presensi', $today)
            ->with(['user.kelas'])
            ->get();

        // Ambil semua data kelas untuk dropdown filter
        $kelasList = Kelas::all();

        // Gunakan view detailPresensi.index
        return view('dashboard', compact('sudahPresensi', 'kelasList'));
    }
}
