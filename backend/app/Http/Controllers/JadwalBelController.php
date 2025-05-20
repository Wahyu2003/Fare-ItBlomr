<?php

namespace App\Http\Controllers;

use App\Models\JadwalBel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JadwalBelController extends Controller
{
    public function index(Request $request)
    {
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
            'file_suara' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['file_suara'] = $request->input('file_suara');
        $data['aktif'] = $request->has('aktif');

        $jadwal = JadwalBel::create($data);

        // Sinkronisasi ke Firebase sesuai tipe jadwal
        $this->syncToFirebase($jadwal);

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
            'file_suara' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['file_suara'] = $request->input('file_suara');
        $data['aktif'] = $request->has('aktif');

        $jadwalBel->update($data);

        // Sinkronisasi ke Firebase sesuai tipe jadwal
        $this->syncToFirebase($jadwalBel);

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JadwalBel $jadwalBel)
    {
        // Hapus dari kedua node Firebase (manual & otomatis)
        $nodeManual = env('FIREBASE_DB_URL') . '/jadwal_bel_manual/' . $jadwalBel->id . '.json?auth=' . env('FIREBASE_SECRET');
        $nodeOtomatis = env('FIREBASE_DB_URL') . '/jadwal_bel_otomatis/' . $jadwalBel->id . '.json?auth=' . env('FIREBASE_SECRET');

        Http::delete($nodeManual);
        Http::delete($nodeOtomatis);

        $jadwalBel->delete();

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function toggle(JadwalBel $jadwalBel)
    {
        $jadwalBel->update(['aktif' => !$jadwalBel->aktif]);

        // Sinkronisasi ke Firebase sesuai tipe jadwal
        $this->syncToFirebase($jadwalBel);

        return back();
    }

    /**
     * Sinkronisasi data ke Firebase sesuai tipe jadwal (manual / otomatis).
     */
    private function syncToFirebase(JadwalBel $jadwal)
    {
        if ($jadwal->is_manual) {
            // Manual
            $node = 'jadwal_bel_manual';
            $firebaseData = [
                'id' => $jadwal->id,
                'aktif' => $jadwal->aktif,
                'tanggal' => $jadwal->tanggal,
                'jam' => $jadwal->jam,
                'keterangan' => $jadwal->keterangan,
                'file_suara' => $jadwal->file_suara,
            ];
        } else {
            // Otomatis
            $node = 'jadwal_bel_otomatis';
            $firebaseData = [
                'id' => $jadwal->id,
                'aktif' => $jadwal->aktif,
                'hari' => $jadwal->hari,
                'jam' => $jadwal->jam,
                'keterangan' => $jadwal->keterangan,
                'file_suara' => $jadwal->file_suara,
            ];
        }

        $firebaseUrl = env('FIREBASE_DB_URL') . '/' . $node . '/' . $jadwal->id . '.json?auth=' . env('FIREBASE_SECRET');
        Http::put($firebaseUrl, $firebaseData);
    }
}