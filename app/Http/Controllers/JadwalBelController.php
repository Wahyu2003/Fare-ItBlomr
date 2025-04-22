<?php

namespace App\Http\Controllers;

use App\Models\JadwalBel;
use Illuminate\Http\Request;

class JadwalBelController extends Controller
{
    // Menampilkan daftar jadwal
    public function index()
    {
        $jadwals = JadwalBel::all(); // Mengambil semua data jadwal
        return view('jadwal_bel.index', compact('jadwals'));
    }

    // Menampilkan form untuk menambah jadwal
    public function create()
    {
        return view('jadwal_bel.create');
    }

    // Menyimpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string|max:20',
            'jam' => 'required|date_format:H:i',
            'keterangan' => 'required|string|max:255',
        ]);

        JadwalBel::create($request->all());

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit jadwal
    public function edit(JadwalBel $jadwalBel)
    {
        return view('jadwal_bel.edit', compact('jadwalBel'));
    }

    // Memperbarui jadwal
    public function update(Request $request, JadwalBel $jadwalBel)
    {
        $request->validate([
            'hari' => 'required|string|max:20',
            'jam' => 'required|date_format:H:i',
            'keterangan' => 'required|string|max:255',
        ]);

        $jadwalBel->update($request->all());

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    // Menghapus jadwal
    public function destroy(JadwalBel $jadwalBel)
    {
        $jadwalBel->delete();

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
