<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MataPelajaranController extends Controller
{
    public function getMataPelajaran()
    {
        $mataPelajaran = MataPelajaran::all();
        return response()->json($mataPelajaran);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|in:10,11,12',
            'multimedia' => 'required|in:Multimedia 1,Multimedia 2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $mataPelajaran = MataPelajaran::create([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
            'kelas' => $request->kelas,
            'multimedia' => $request->multimedia,
        ]);

        return response()->json([
            'success' => true,
            'mataPelajaran' => $mataPelajaran,
        ], 200);
    }

    public function destroy($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return response()->json(['success' => true]);
    }

    // Metode baru untuk menampilkan form
    public function create()
    {
        return view('mataPelajaran.add'); // Buat view baru nanti
    }

    // Metode baru untuk menyimpan dari form biasa
    public function storeForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|in:10,11,12',
            'multimedia' => 'required|in:Multimedia 1,Multimedia 2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        MataPelajaran::create([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
            'kelas' => $request->kelas,
            'multimedia' => $request->multimedia,
        ]);

        return redirect()->route('jadwalPelajaran.create')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }
}