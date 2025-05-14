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
        $roleFilter = $request->input('role', 'siswa');
        $kelasFilter = $request->input('kelas');
        $guruFilter = $request->input('guru');

        // Eager load relasi yang dibutuhkan
        $query = JadwalPelajaran::with(['mataPelajaran.kelas', 'guru']);

        // Jika role siswa dan ada filter kelas
        if ($roleFilter === 'siswa' && !empty($kelasFilter)) {
            $query->whereHas('mataPelajaran', function ($q) use ($kelasFilter) {
                $q->where('kelas_id', $kelasFilter);
            });
        }

        // Jika role guru dan ada filter guru
        if ($roleFilter === 'guru' && !empty($guruFilter)) {
            $query->where('guru_id', $guruFilter);
        }

        $jadwalPelajaran = $query->get();

        // Ambil data dropdown
        $kelasOptions = Kelas::pluck('nama_kelas', 'id_kelas'); // Format: [id => nama]
        $guruOptions = User::where('role', 'guru')->get(); // Tetap gunakan ->get() karena kita pakai objek di Blade

        return view('jadwalPelajaran.index', compact(
            'jadwalPelajaran',
            'roleFilter',
            'kelasFilter',
            'guruFilter',
            'kelasOptions',
            'guruOptions'
        ));
    }

    public function indexsiswa()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil kelas yang terkait dengan user yang sedang login
        $kelasUser = $user->kelas;

        // Ambil jadwal pelajaran yang sesuai dengan kelas siswa dan juga data guru
        $jadwalPelajaran = JadwalPelajaran::with('mataPelajaran', 'guru') // Pastikan guru dimasukkan dalam with()
            ->whereHas('mataPelajaran.kelas', function ($query) use ($kelasUser) {
                $query->where('id_kelas', $kelasUser->id_kelas);
            })->get();

        return view('jadwalpelajaran.indexsiswa', compact('jadwalPelajaran'));
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
