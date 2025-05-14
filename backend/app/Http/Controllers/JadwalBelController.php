<?php

namespace App\Http\Controllers;

use App\Models\JadwalBel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JadwalBelController extends Controller
{
    public function index(Request $request)
    {
        // Jika filter kosong, set default ke 'otomatis'
        $filter = $request->query('filter', 'otomatis');
    
        $jadwals = JadwalBel::when($filter == 'manual', function ($query) {
                return $query->where('is_manual', true);
            })
            ->when($filter == 'otomatis', function ($query) {
                return $query->where('is_manual', false);
            })
            ->orderBy('jam')
            ->get();
    
        return view('jadwal_bel.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal_bel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'is_manual' => 'required|boolean',
            'hari' => 'nullable|string|max:20',
            'tanggal' => 'nullable|date',
            'jam' => 'required|date_format:H:i',
            'keterangan' => 'required|string|max:255',
            'file_suara' => 'nullable|string',  // Simpan hanya nama file sebagai string
            'aktif' => 'nullable|boolean',
        ]);

        $data = $validated;

        // Ambil nama file dari inputan string
        $data['file_suara'] = $request->input('file_suara');  // Ambil nama file suara sebagai string

        $data['aktif'] = $request->has('aktif');

        // Simpan data ke database
        $jadwal = JadwalBel::create($data);

        // Kirim ke Firebase
        $firebaseUrl = env('FIREBASE_DB_URL') . '/jadwal_bel/' . $jadwal->id . '.json?auth=' . env('FIREBASE_SECRET');
        Http::put($firebaseUrl, $jadwal->toArray());

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(JadwalBel $jadwalBel)
    {
        return view('jadwal_bel.edit', compact('jadwalBel'));
    }

    public function update(Request $request, JadwalBel $jadwalBel)
    {
        $validated = $request->validate([
            'is_manual' => 'required|boolean',
            'hari' => 'nullable|string|max:20',
            'tanggal' => 'nullable|date',
            'jam' => 'required|date_format:H:i',
            'keterangan' => 'required|string|max:255',
            'file_suara' => 'nullable|string',  // Simpan hanya nama file sebagai string
            'aktif' => 'nullable|boolean',
        ]);

        $data = $validated;

        // Ambil nama file dari inputan string
        $data['file_suara'] = $request->input('file_suara');  // Ambil nama file suara sebagai string

        $data['aktif'] = $request->has('aktif');

        // Update data pada database
        $jadwalBel->update($data);

        // Update Firebase
        $firebaseUrl = env('FIREBASE_DB_URL') . '/jadwal_bel/' . $jadwalBel->id . '.json?auth=' . env('FIREBASE_SECRET');
        Http::put($firebaseUrl, $jadwalBel->toArray());

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JadwalBel $jadwalBel)
    {
        // Hapus dari Firebase
        $firebaseUrl = env('FIREBASE_DB_URL') . '/jadwal_bel/' . $jadwalBel->id . '.json?auth=' . env('FIREBASE_SECRET');
        Http::delete($firebaseUrl);

        $jadwalBel->delete();

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function toggle(JadwalBel $jadwalBel)
    {
        $jadwalBel->update(['aktif' => !$jadwalBel->aktif]);

        // Update Firebase
        $firebaseUrl = env('FIREBASE_DB_URL') . '/jadwal_bel/' . $jadwalBel->id . '.json?auth=' . env('FIREBASE_SECRET');
        Http::put($firebaseUrl, $jadwalBel->toArray());

        return back();
    }
}