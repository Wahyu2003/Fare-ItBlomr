<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\DetailPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Kelas;

class DetailPresensiController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $sudahPresensi = DetailPresensi::whereDate('waktu_presensi', $today)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->with('user.kelas')
            ->get();

        $sudahIds = $sudahPresensi->pluck('id_user');
        
        $belumPresensi = User::where('role', '!=', 'admin')
            ->whereNotIn('id_user', $sudahIds)
            ->with('kelas')
            ->get();

        $kelasList = Kelas::all();

        return view('detailPresensi.index', compact('sudahPresensi', 'belumPresensi', 'kelasList'));
    }

    public function rekapanAbsenSiswa(Request $request)
    {
        // Ambil filter status dan rentang waktu dari request
        $statusFilter = $request->input('status', ''); // Default ke kosong
        $timeFilter = $request->input('time_filter', 'week'); // Default ke 'week'
        $startDate = null;
        $endDate = null;

        // Tentukan rentang waktu berdasarkan filter
        if ($timeFilter === 'week') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif ($timeFilter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($timeFilter === 'custom' && $request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
        }

        // Query untuk mendapatkan data presensi siswa yang login
        $presensiQuery = DetailPresensi::with('user', 'jadwalPelajaran')
            ->whereBetween('waktu_presensi', [$startDate, $endDate])
            ->where('id_user', auth()->user()->id_user); // Filter hanya untuk siswa yang login

        // Filter berdasarkan status kehadiran jika ada
        if ($statusFilter) {
            $presensiQuery->where('kehadiran', $statusFilter);
        }

        // Ambil data presensi yang sudah terfilter
        $presensi = $presensiQuery->get();

        // Hitung total presensi
        $totalPresensi = $presensi->count();

        // Menghindari pembagian dengan nol
        if ($totalPresensi > 0) {
            // Hitung persentase kehadiran berdasarkan status
            $statusCounts = $presensi->groupBy('kehadiran')->map->count();

            $totalPercentage = ($statusCounts->get('tepat waktu', 0) / $totalPresensi) * 100;
            $hadirPercentage = ($statusCounts->get('tepat waktu', 0) / $totalPresensi) * 100;
            $telatPercentage = ($statusCounts->get('telat', 0) / $totalPresensi) * 100;
            $alphaPercentage = ($statusCounts->get('alpha', 0) / $totalPresensi) * 100;
            $izinPercentage = ($statusCounts->get('izin', 0) / $totalPresensi) * 100;
            $sakitPercentage = ($statusCounts->get('sakit', 0) / $totalPresensi) * 100;
        } else {
            $totalPercentage = 0;
            $hadirPercentage = 0;
            $telatPercentage = 0;
            $alphaPercentage = 0;
            $izinPercentage = 0;
            $sakitPercentage = 0;
        }

        return view('dashboard_siswa', compact(
            'presensi',
            'statusFilter',
            'timeFilter',
            'startDate',
            'endDate',
            'totalPercentage',
            'hadirPercentage',
            'telatPercentage',
            'alphaPercentage',
            'izinPercentage',
            'sakitPercentage'
        ));
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
            if (!isset($data['name']) || !isset($data['id_user'])) {
                return response()->json(['error' => 'Wajah tidak dikenali'], 400);
            }
            $now = Carbon::now();
            $jamMulai = Carbon::createFromTimeString('06:30');
            $jamTelat = Carbon::createFromTimeString('07:15');
            $jamBatasPulang = Carbon::createFromTimeString('13:00');
            $jamPulang = Carbon::createFromTimeString('15:00');

            if ($now->lt($jamMulai)) {
                return response()->json(['error' => 'Presensi belum dimulai. Presensi masuk mulai pukul 06:30'], 403);
            }

            $jenis_absen = null;
            $kehadiran = 'hadir';

            if ($now->between($jamMulai, $jamTelat)) {
                $jenis_absen = 'masuk';
            } elseif ($now->gt($jamTelat) && $now->lt($jamPulang)) {
                $jenis_absen = 'masuk';
                $kehadiran = 'telat';
            } elseif ($now->lt($jamPulang)) {
                return response()->json(['error' => 'Presensi hanya tersedia untuk masuk atau pulang di jam yang ditentukan'], 403);
            } else {
                $kehadiran = 'tepat waktu';
                $jenis_absen = 'pulang';
            }

            $existing = DetailPresensi::where('id_user', $data['id_user'])
                ->whereDate('waktu_presensi', $now)
                ->first();

            if ($existing) {
                return response()->json([
                    'error' => 'User sudah melakukan presensi hari ini'
                ], 409);
            }

            DetailPresensi::create([
                'waktu_presensi' => $now,
                'kehadiran' => $kehadiran,
                'jenis_absen' => $jenis_absen,
                'id_user' => $data['id_user'],
                'id_jadwal_pelajaran' => '2',
            ]);

            // Firebase
            $firebaseUrl = env('FIREBASE_DB_URL') . '/presensi.json?auth=' . env('FIREBASE_SECRET');
            $payload = [
                'nama' => $data['name'],
                'waktu_presensi' => $now->toDayDateTimeString(),
                'role' => $data['role'],
                'jenis_absen' => $jenis_absen,
            ];
            Http::put($firebaseUrl, $payload);

            // Kirim WhatsApp
            $user = User::find($data['id_user']);
            $nomor = $user?->no_hp_siswa ?? null;

            if ($nomor) {
                $this->kirimPesanFonnte(
                    $nomor,
                    "Halo {$data['name']}, Anda berhasil presensi *{$jenis_absen}* pada " . $now->toDayDateTimeString()
                );
            }

            return response()->json([
                'message' => "Presensi {$jenis_absen} berhasil dan WhatsApp dikirim",
                'name' => $data['name'],
                'waktu_presensi' => $now->toDayDateTimeString(),
                'jenis_absen' => $jenis_absen,
                'kehadiran' => $kehadiran,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateMultipleStatus(Request $request)
    {
        $statuses = $request->input('statuses', []);

        $today = Carbon::today();
        $jenis_absen = 'tidak hadir';

        foreach ($statuses as $userId => $status) {
            // Lewati jika status kosong
            if (empty($status)) continue;

            // Validasi sederhana status
            if (!in_array($status, ['izin', 'alpha'])) {
                continue;
            }

            $presensi = DetailPresensi::where('id_user', $userId)
                ->whereDate('waktu_presensi', $today)
                ->first();

            if ($presensi) {
                $presensi->kehadiran = $status;
                $presensi->jenis_absen = $jenis_absen;
                $presensi->save();
            } else {
                DetailPresensi::create([
                    'id_user' => $userId,
                    'waktu_presensi' => $today,
                    'kehadiran' => $status,
                    'jenis_absen' => $jenis_absen,
                    'id_jadwal_pelajaran' => 2, // sesuaikan jika perlu
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status presensi berhasil diperbarui untuk semua user.');
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

        $belumPresensi = User::where('role', '!=', 'admin')  // Filter admin
            ->whereDoesntHave('detailPresensi', function ($query) use ($today) {
                $query->whereDate('waktu_presensi', $today);
            })->with('kelas')->get();

        $sudahPresensi = DetailPresensi::whereDate('waktu_presensi', $today)
            ->whereHas('user', function ($query) {
                $query->where('role', '!=', 'admin');
            })
            ->with(['user.kelas'])
            ->get();

        $kelasList = Kelas::all();

        return view('detailPresensi.index', compact('belumPresensi', 'sudahPresensi', 'kelasList'));
    }
}
