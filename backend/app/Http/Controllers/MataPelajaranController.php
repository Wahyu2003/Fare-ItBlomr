<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Kelas; // Import model Kelas untuk relasi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MataPelajaranController extends Controller
{
    // Menampilkan semua mata pelajaran
    public function getMataPelajaran()
    {
        $mataPelajaran = MataPelajaran::with('kelas')->get(); // Memuat relasi dengan kelas
        return response()->json($mataPelajaran);
    }

    // Menyimpan data mata pelajaran
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_mata_pelajaran' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id_kelas', // Validasi kelas_id yang ada di tabel kelas
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Menyimpan data mata pelajaran
        $mataPelajaran = MataPelajaran::create([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
            'kelas_id' => $request->kelas_id, // Menyimpan kelas_id
        ]);

        return response()->json([
            'success' => true,
            'mataPelajaran' => $mataPelajaran,
        ], 200);
    }

    // Menghapus mata pelajaran
    public function destroy($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return response()->json(['success' => true]);
    }

    // Metode baru untuk menampilkan form
    public function create()
    {
        $kelas = Kelas::all(); // Menampilkan semua kelas untuk pilihan pada form
        return view('mataPelajaran.add', compact('kelas')); // Passing data kelas ke view
    }

    // Metode baru untuk menyimpan dari form biasa
    public function storeForm(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_mata_pelajaran' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id_kelas', // Validasi kelas_id yang ada di tabel kelas
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menyimpan data mata pelajaran
        MataPelajaran::create([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
            'kelas_id' => $request->kelas_id, // Menyimpan kelas_id
        ]);

        return redirect()->route('jadwalPelajaran.create')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }
}