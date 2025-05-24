<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Menampilkan semua kelas untuk daftar kelas
    public function index()
    {
        if (url()->previous() !== url()->current()) {
        session(['kelas_previous_url' => url()->previous()]);
        }
        // Mengambil semua data kelas
        $kelas = Kelas::all();

        // Menampilkan view daftar kelas
        return view('kelas.index', compact('kelas')); // Menampilkan view kelas.index dengan data kelas
    }

    // Menampilkan view untuk form tambah kelas
    public function create()
    {
        return view('kelas.create'); // Menampilkan form untuk menambah kelas
    }

    // Menyimpan data kelas baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:24',
        ]);

        // Menyimpan kelas baru
        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit kelas
    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    // Mengupdate data kelas
    public function update(Request $request, Kelas $kelas)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:24|unique:kelas,nama_kelas,' . $kelas->id_kelas . ',id_kelas',
        ], [
            'nama_kelas.unique' => 'Nama kelas sudah digunakan.',
        ]);

        // Mengupdate data kelas
        $kelas->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diubah');
    }

    // Menghapus kelas
    public function destroy($id)
    {
        // $id->delete(); // Menghapus data kelas
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');

        // return response()->json(['success' => true]);
    }
}
