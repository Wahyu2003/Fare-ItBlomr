<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MataPelajaranController extends Controller
{
    // Tampil list mata pelajaran
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $kelasFilter = $request->get('kelas');

        $query = MataPelajaran::with('kelas');

        if ($kelasFilter) {
            $query->where('kelas_id', $kelasFilter);
        }

        $mataPelajaran = $query->get(); // tanpa pagination

        return view('mataPelajaran.index', compact('mataPelajaran', 'kelasList', 'kelasFilter'));
    }

    // Tampil form tambah data
    public function create()
    {
        $kelas = Kelas::all();
        return view('mataPelajaran.add', compact('kelas'));
    }

    // Simpan data dari form tambah
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mata_pelajaran' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id_kelas',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        MataPelajaran::create($request->only('nama_mata_pelajaran', 'kelas_id'));

        return redirect()->route('mataPelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    // Tampil form edit data
    public function edit($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $kelas = Kelas::all();
        return view('mataPelajaran.edit', compact('mataPelajaran', 'kelas'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_mata_pelajaran' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id_kelas',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->update($request->only('nama_mata_pelajaran', 'kelas_id'));

        return redirect()->route('mataPelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->route('mataPelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }

    public function filterKelas(Request $request)
    {
        $query = MataPelajaran::with('kelas');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $mataPelajaran = $query->get();

        return response()->json([
            'data' => $mataPelajaran
        ]);
    }
}
