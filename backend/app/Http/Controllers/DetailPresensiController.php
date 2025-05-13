<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\DetailPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Kelas;
use Wablas;

class DetailPresensiController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $sudahPresensi = DetailPresensi::with('user')
            ->whereDate('waktu_presensi', $today)
            ->get();

        $sudahIds = $sudahPresensi->pluck('id_user');
        $belumPresensi = User::whereNotIn('id_user', $sudahIds)->get();

        // Ambil data kelas untuk dropdown filter
        $kelasList = Kelas::all();

        return view('detailPresensi.index', compact('sudahPresensi', 'belumPresensi', 'kelasList'));
    }

    public function create()
    {
        return view('detailPresensi.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'waktu_presensi' => ['required'],
            'kehadiran' => ['required', 'string', 'in:tepat waktu,telat,alpha,izin,sakit'],
            'jenis_absen' => ['required', 'string', 'in:belum keluar,pulang,tidak hadir'],
            'id_user' => ['sometimes', 'exists:users,id_user'],
            'id_jadwal_pelajaran' => ['required', 'exists:jadwal_pelajaran,id_jadwal_pelajaran'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['waktu_presensi'] = $request->input('waktu_presensi');
        $data['kehadiran'] = $request->input('kehadiran');

        DetailPresensi::create($data);
        return redirect()->route('detailPresensi.index')->with('success', 'Presensi berhasil ditambahkan');
    }

    public function show(DetailPresensi $detailPresensi)
    {
        return view('detailPresensi.show', compact('detailPresensi'));
    }

    public function edit(DetailPresensi $detailPresensi)
    {
        return view('detailPresensi.edit', compact('detailPresensi'));
    }

    public function update(Request $request, DetailPresensi $detailPresensi)
    {
        $validator = Validator::make($request->all(), [
            'waktu_presensi' => ['required'],
            'kehadiran' => ['required', 'string', 'in:tepat waktu,telat,alpha,izin,sakit'],
            'jenis_absen' => ['required', 'string', 'in:belum keluar,pulang,tidak hadir'],
            'id_user' => ['sometimes', 'exists:users,id_user'],
            'id_jadwal_pelajaran' => ['required', 'exists:jadwal_pelajaran,id_jadwal_pelajaran'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['waktu_presensi'] = $request->input('waktu_presensi');
        $data['kehadiran'] = $request->input('kehadiran');

        $detailPresensi->update($data);
        return redirect()->route('detailPresensi.index')->with('success', 'Presensi berhasil diubah');
    }

    public function destroy(DetailPresensi $detailPresensi)
    {
        $detailPresensi->delete();
        return redirect()->route('detailPresensi.index')->with('success', 'Presensi berhasil dihapus');
    }

    public function sendToPython(Request $request)
    {
        try {
            if (!$request->hasFile('photo')) {
                return response()->json(['error' => 'Photo is required'], 400);
            }

            $photo = $request->file('photo');

            $response = Http::attach(
                'photo',
                file_get_contents($photo),
                $photo->getClientOriginalName()
            )->post('http://faceapi:5000/recognize');

            if ($response->failed()) {
                return response()->json(['error' => 'API Python gagal merespon'], 500);
            }

            $data = $response->json();

            if (isset($data['name']) && isset($data['id_user'])) {
                DetailPresensi::create([
                    'waktu_presensi' => now(),
                    'kehadiran' => 'tepat waktu',
                    'jenis_absen' => 'belum keluar',
                    'id_user' => $data['id_user'],
                    'id_jadwal_pelajaran' => '1',
                ]);

                $firebaseUrl = env('FIREBASE_DB_URL') . '/presensi.json?auth=' . env('FIREBASE_SECRET');
                $payload = [
                    'nama' => $data['name'],
                    'waktu_presensi' => now()->toDayDateTimeString(),
                    'role' => $data['role'],
                ];
                Http::put($firebaseUrl, $payload);

                $user = User::find($data['id_user']);
                $nomor = $user?->no_hp_siswa ?? null;

                if ($nomor) {
                    logger()->info('Mulai kirim WhatsApp ke user', [
                        'nomor' => $nomor,
                        'nama' => $data['name'],
                    ]);

                    $this->kirimPesanFonnte(
                        $nomor,
                        "Halo {$data['name']}, Anda berhasil presensi pada " . now()->toDayDateTimeString()
                    );

                    logger()->info('Selesai proses kirim WhatsApp ke user');
                } else {
                    logger()->warning('Nomor WhatsApp tidak ditemukan untuk user', [
                        'id_user' => $data['id_user'],
                        'nama' => $data['name'],
                    ]);
                }

                return response()->json([
                    'message' => 'Presensi berhasil dan WhatsApp dikirim',
                    'name' => $data['name'],
                    'waktu_presensi' => now()->toDayDateTimeString(),
                ], 200);
            }

            return response()->json(['error' => 'Wajah tidak dikenali'], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function kirimPesanFonnte($nomor, $pesan)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $nomor,
                'message' => $pesan,
            ]);

            logger()->info('Fonnte WA response', ['response' => $response->json()]);
        } catch (\Throwable $e) {
            logger()->error('Gagal kirim WhatsApp via Fonnte', [
                'nomor' => $nomor,
                'pesan' => $pesan,
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    public function presensiWajah()
    {
        $today = Carbon::today();

        $belumPresensi = User::whereDoesntHave('detailPresensi', function ($query) use ($today) {
            $query->whereDate('waktu_presensi', $today);
        })->with('kelas')->get();

        // Ambil data presensi hari ini beserta relasi user dan kelas
        $sudahPresensi = DetailPresensi::whereDate('waktu_presensi', $today)
            ->with(['user.kelas'])
            ->get();

        // Ambil semua data kelas untuk dropdown filter
        $kelasList = Kelas::all();

        // Gunakan view detailPresensi.index
        return view('detailPresensi.index', compact('belumPresensi', 'sudahPresensi', 'kelasList'));
    }
}
