<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Kelas; // Import model Kelas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->input('role', 'siswa'); // Default ke siswa
        $kelasFilter = $request->input('kelas'); // Filter untuk kelas
        $guruFilter = $request->input('guru'); // Filter untuk guru

        // Inisialisasi query untuk jadwal pelajaran dengan relasi
        $jadwalPelajaran = JadwalPelajaran::with('mataPelajaran', 'guru');

        // Filter untuk siswa berdasarkan kelas_id
        if ($roleFilter === 'siswa' && $kelasFilter) {
            $jadwalPelajaran->whereHas('mataPelajaran', function ($query) use ($kelasFilter) {
                $query->where('kelas_id', $kelasFilter); // Menggunakan kelas_id
            });
        }

        // Filter untuk guru berdasarkan guru_id
        if ($roleFilter === 'guru' && $guruFilter) {
            $jadwalPelajaran->where('guru_id', $guruFilter);
        }

        $jadwalPelajaran = $jadwalPelajaran->get();

        // Ambil data untuk filter kelas dan guru
        $kelasOptions = Kelas::pluck('nama_kelas', 'id_kelas'); // Mengambil nama kelas dan id_kelas
        $guruOptions = User::where('role', 'guru')->select('id_user', 'nama')->get();

        return view('jadwalPelajaran.index', compact('jadwalPelajaran', 'roleFilter', 'kelasFilter', 'guruFilter', 'kelasOptions', 'guruOptions'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::with('kelas')->get(); // Ambil mata pelajaran dengan relasi kelas
        $gurus = User::where('role', 'guru')->get(); // Ambil semua guru
        return view('jadwalPelajaran.create', compact('mataPelajaran', 'gurus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
            'guru_id' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        JadwalPelajaran::create([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan' => $request->ruangan,
            'id_mata_pelajaran' => $request->id_mata_pelajaran,
            'guru_id' => $request->guru_id,
        ]);

        return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $mataPelajaran = MataPelajaran::with('kelas')->get(); // Ambil mata pelajaran dengan relasi kelas
        $gurus = User::where('role', 'guru')->get(); // Ambil semua guru
        return view('jadwalPelajaran.edit', compact('jadwalPelajaran', 'mataPelajaran', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
            'guru_id' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $jadwalPelajaran->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan' => $request->ruangan,
            'id_mata_pelajaran' => $request->id_mata_pelajaran,
            'guru_id' => $request->guru_id,
        ]);

        return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $jadwalPelajaran->delete();

        return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
}
