<?php

namespace App\Http\Controllers;

use App\Models\JadwalBel;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class JadwalBelController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

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
        $validated = $request->validate([
            'hari' => 'required|string|max:20',
            'jam' => 'required|date_format:H:i',
            'keterangan' => 'required|string|max:255',
            'file_suara' => 'nullable|file|mimes:mp3,wav',
            'aktif' => 'nullable|boolean',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('file_suara')) {
            $data['file_suara'] = $request->file('file_suara')->store('suara_bel', 'public');
        }
        
        $data['aktif'] = $request->has('aktif'); // true jika dicentang
        
        $jadwal = JadwalBel::create($data);
        $this->firebase->storeJadwal($jadwal->id, $jadwal->toArray());

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
        // Validasi input
        $validated = $request->validate([
            'hari' => 'required|string|max:20',
            'jam' => 'required|date_format:H:i',
            'keterangan' => 'required|string|max:255',
            'file_suara' => 'nullable|file|mimes:mp3,wav',
            'aktif' => 'nullable|boolean',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('file_suara')) {
            $data['file_suara'] = $request->file('file_suara')->store('suara_bel', 'public');
        }
        
        $data['aktif'] = $request->has('aktif');
        
        $jadwalBel->update($data);
        $this->firebase->storeJadwal($jadwalBel->id, $jadwalBel->toArray());

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    // Menghapus jadwal
    public function destroy(JadwalBel $jadwalBel)
    {
        // Menghapus jadwal dari Firebase
        $this->firebase->storeJadwal($jadwalBel->id, null);

        // Menghapus jadwal dari database
        $jadwalBel->delete();

        return redirect()->route('jadwal_bel.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function toggle(JadwalBel $jadwalBel)
    {
        $jadwalBel->update(['aktif' => !$jadwalBel->aktif]);
        $this->firebase->storeJadwal($jadwalBel->id, $jadwalBel->toArray());

        return back();
    }
}
