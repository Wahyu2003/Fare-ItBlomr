<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $jadwalPelajaran = JadwalPelajaran::with('mataPelajaran')->get();
        return view('jadwalPelajaran.index', compact('jadwalPelajaran'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::all();
        return view('jadwalPelajaran.create', compact('mataPelajaran'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu', // Validasi enum hari
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kelas' => 'required|in:10,11,12',
            'multimedia' => 'required|in:Multimedia 1,Multimedia 2',
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        JadwalPelajaran::create([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas' => $request->kelas,
            'multimedia' => $request->multimedia,
            'id_mata_pelajaran' => $request->id_mata_pelajaran,
        ]);

        return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $mataPelajaran = MataPelajaran::all();
        return view('jadwalPelajaran.edit', compact('jadwalPelajaran', 'mataPelajaran'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu', // Validasi enum hari
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kelas' => 'required|in:10,11,12',
            'multimedia' => 'required|in:Multimedia 1,Multimedia 2',
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $jadwalPelajaran->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas' => $request->kelas,
            'multimedia' => $request->multimedia,
            'id_mata_pelajaran' => $request->id_mata_pelajaran,
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