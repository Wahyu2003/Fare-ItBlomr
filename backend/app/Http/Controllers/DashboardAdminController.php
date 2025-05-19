<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPresensi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        // Kirimkan data presensi dan kelas ke view tanpa data firebase
        return view('dashboard', compact('kelasList', 'presensiData', 'jumlahHadir', 'jumlahIzin', 'jumlahAlpa'));
    }

    public function updateDashboardAdmin(Request $request)
    {
        $kelasId = $request->input('kelas', null);

        $today = Carbon::today();

        $presensiData = DetailPresensi::with('user.kelas')
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->whereHas('user', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->whereDate('waktu_presensi', $today)
            ->get();

        $jumlahHadir = $presensiData->where('kehadiran', 'tepat waktu')->count();
        $jumlahIzin = $presensiData->where('kehadiran', 'izin')->count();
        $jumlahAlpa = $presensiData->where('kehadiran', 'alpha')->count();

        $guruHadir = DetailPresensi::whereDate('waktu_presensi', $today)
            ->whereHas('user', function ($q) {
                $q->where('role', 'guru');
            })
            ->exists();

        return response()->json([
            'dataSiswaHariIni' => $presensiData,
            'jumlahHadir' => $jumlahHadir,
            'jumlahIzin' => $jumlahIzin,
            'jumlahAlpa' => $jumlahAlpa,
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

        dd($sudahPresensi);

        // Gunakan view detailPresensi.index
        return view('dashboard', compact('sudahPresensi', 'kelasList'));
    }
}
