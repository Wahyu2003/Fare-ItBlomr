<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\DetailPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\JadwalPelajaran;

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
        $statusFilter = $request->input('status', '');
        $timeFilter = $request->input('time_filter', 'week');
        $startDate = null;
        $endDate = null;

        // Set periode waktu berdasarkan filter
        if ($timeFilter === 'week') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif ($timeFilter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($timeFilter === 'custom' && $request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        } else {
            // Default ke minggu ini jika filter tidak valid
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        }

        // Query presensi berdasarkan filter
        $presensiQuery = DetailPresensi::with('user', 'jadwalPelajaran')
            ->whereBetween('waktu_presensi', [$startDate, $endDate])
            ->where('id_user', auth()->user()->id_user);

        if ($statusFilter) {
            $presensiQuery->where('kehadiran', $statusFilter);
        }

        $presensi = $presensiQuery->get();
        $totalPresensi = $presensi->count();

        // Hitung persentase kehadiran
        $hadirPercentage = $telatPercentage = $alphaPercentage = $izinPercentage = $sakitPercentage = 0;
        if ($totalPresensi > 0) {
            $statusCounts = $presensi->groupBy('kehadiran')->map->count();
            $hadirPercentage = ($statusCounts->get('tepat waktu', 0) / $totalPresensi) * 100;
            $telatPercentage = ($statusCounts->get('telat', 0) / $totalPresensi) * 100;
            $alphaPercentage = ($statusCounts->get('alpha', 0) / $totalPresensi) * 100;
            $izinPercentage = ($statusCounts->get('izin', 0) / $totalPresensi) * 100;
            $sakitPercentage = ($statusCounts->get('sakit', 0) / $totalPresensi) * 100;
        }

        // Statistik untuk Bar Chart berdasarkan periode waktu
        $labels = [];
        $dataHadir = $dataTelat = $dataAlpha = $dataIzin = $dataSakit = [];

        if ($timeFilter === 'week') {
            // Label: Hari dalam seminggu
            $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $dataHadir = $dataTelat = $dataAlpha = $dataIzin = $dataSakit = array_fill(0, 7, 0);

            $stats = DetailPresensi::where('id_user', auth()->user()->id_user)
                ->whereBetween('waktu_presensi', [$startDate, $endDate])
                ->selectRaw('DAYOFWEEK(waktu_presensi) as hari, kehadiran, COUNT(*) as total')
                ->groupBy('hari', 'kehadiran')
                ->get();

            foreach ($stats as $item) {
                $index = ($item->hari + 5) % 7; // Konversi DAYOFWEEK (1=Min, 2=Sen) ke index (0=Sen, 6=Min)
                switch ($item->kehadiran) {
                    case 'tepat waktu':
                        $dataHadir[$index] = $item->total;
                        break;
                    case 'telat':
                        $dataTelat[$index] = $item->total;
                        break;
                    case 'alpha':
                        $dataAlpha[$index] = $item->total;
                        break;
                    case 'izin':
                        $dataIzin[$index] = $item->total;
                        break;
                    case 'sakit':
                        $dataSakit[$index] = $item->total;
                        break;
                }
            }
        } elseif ($timeFilter === 'month') {
            // Label: Minggu dalam sebulan
            $weeks = [];
            $current = $startDate->copy();
            while ($current <= $endDate) {
                $weekStart = $current->copy()->startOfWeek();
                $weekEnd = $current->copy()->endOfWeek();
                if ($weekEnd > $endDate) {
                    $weekEnd = $endDate;
                }
                $weeks[] = "Minggu " . (count($weeks) + 1) . " (" . $weekStart->format('d M') . " - " . $weekEnd->format('d M') . ")";
                $current->addWeek();
            }
            $labels = $weeks;
            $dataHadir = $dataTelat = $dataAlpha = $dataIzin = $dataSakit = array_fill(0, count($labels), 0);

            $stats = DetailPresensi::where('id_user', auth()->user()->id_user)
                ->whereBetween('waktu_presensi', [$startDate, $endDate])
                ->selectRaw('WEEK(waktu_presensi, 1) as minggu, kehadiran, COUNT(*) as total')
                ->groupBy('minggu', 'kehadiran')
                ->get();

            foreach ($stats as $item) {
                $weekIndex = 0;
                $weekStart = $startDate->copy()->startOfWeek();
                for ($i = 0; $i < count($labels); $i++) {
                    if ($item->minggu == $weekStart->weekOfYear) {
                        $weekIndex = $i;
                        break;
                    }
                    $weekStart->addWeek();
                }
                switch ($item->kehadiran) {
                    case 'tepat waktu':
                        $dataHadir[$weekIndex] = $item->total;
                        break;
                    case 'telat':
                        $dataTelat[$weekIndex] = $item->total;
                        break;
                    case 'alpha':
                        $dataAlpha[$weekIndex] = $item->total;
                        break;
                    case 'izin':
                        $dataIzin[$weekIndex] = $item->total;
                        break;
                    case 'sakit':
                        $dataSakit[$weekIndex] = $item->total;
                        break;
                }
            }
        } else {
            // Custom: Label per hari dalam rentang waktu
            $days = $startDate->diffInDays($endDate) + 1;
            $labels = [];
            $current = $startDate->copy();
            for ($i = 0; $i < $days && $i < 31; $i++) { // Batasi hingga 31 hari untuk chart
                $labels[] = $current->format('d M');
                $current->addDay();
            }
            $dataHadir = $dataTelat = $dataAlpha = $dataIzin = $dataSakit = array_fill(0, count($labels), 0);

            $stats = DetailPresensi::where('id_user', auth()->user()->id_user)
                ->whereBetween('waktu_presensi', [$startDate, $endDate])
                ->selectRaw('DATE(waktu_presensi) as tanggal, kehadiran, COUNT(*) as total')
                ->groupBy('tanggal', 'kehadiran')
                ->get();

            foreach ($stats as $item) {
                $date = Carbon::parse($item->tanggal);
                $index = $startDate->diffInDays($date);
                if ($index < count($labels)) {
                    switch ($item->kehadiran) {
                        case 'tepat waktu':
                            $dataHadir[$index] = $item->total;
                            break;
                        case 'telat':
                            $dataTelat[$index] = $item->total;
                            break;
                        case 'alpha':
                            $dataAlpha[$index] = $item->total;
                            break;
                        case 'izin':
                            $dataIzin[$index] = $item->total;
                            break;
                        case 'sakit':
                            $dataSakit[$index] = $item->total;
                            break;
                    }
                }
            }
        }

        return view('dashboard_siswa', compact(
            'presensi',
            'statusFilter',
            'timeFilter',
            'startDate',
            'endDate',
            'hadirPercentage',
            'telatPercentage',
            'alphaPercentage',
            'izinPercentage',
            'sakitPercentage',
            'labels',
            'dataHadir',
            'dataTelat',
            'dataAlpha',
            'dataIzin',
            'dataSakit'
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
            // Cari jadwal pelajaran hari ini
            $hariIni = Carbon::now()->dayOfWeek;
            $jadwalHariIni = JadwalPelajaran::where('hari', $hariIni)->get();

            if ($jadwalHariIni->isEmpty()) {
                return response()->json(['error' => 'Tidak ada jadwal pelajaran hari ini'], 400);
            }
            $id_jadwal_pelajaran = $jenis_absen === 'masuk'
                ? $jadwalHariIni->sortBy('jam_mulai')->first()->id
                : $jadwalHariIni->sortByDesc('jam_selesai')->first()->id;

            DetailPresensi::create([
                'waktu_presensi' => $now,
                'kehadiran' => $kehadiran,
                'jenis_absen' => $jenis_absen,
                'id_user' => $data['id_user'],
                'id_jadwal_pelajaran' => $id_jadwal_pelajaran ?? "1",
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
                    "Halo {$data['name']}, Anda berhasil presensi {$jenis_absen} pada " . $now->toDayDateTimeString()
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

        // Ambil hari ini (0=minggu, 1=senin, ..., 6=sabtu)
        $hariIni = Carbon::now()->dayOfWeek;

        // Cari jadwal pelajaran hari ini
        $jadwalHariIni = JadwalPelajaran::where('hari', $hariIni)->get();

        if ($jadwalHariIni->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Tidak ada jadwal pelajaran hari ini']);
        }

        foreach ($statuses as $userId => $status) {
            // Lewati jika status kosong
            if (empty($status)) continue;

            // Validasi status hanya 'izin' dan 'alpha'
            if (!in_array($status, ['izin', 'alpha'])) {
                continue;
            }

            $presensi = DetailPresensi::where('id_user', $userId)
                ->whereDate('waktu_presensi', $today)
                ->first();

            // Tentukan id_jadwal_pelajaran berdasarkan jenis_absen 'tidak hadir' (di sini tetap 'tidak hadir')
            // Jika ingin logic berbeda, sesuaikan
            $id_jadwal_pelajaran = $jenis_absen === 'masuk'
                ? $jadwalHariIni->sortBy('jam_mulai')->first()->id
                : $jadwalHariIni->sortByDesc('jam_selesai')->first()->id;

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
                    'id_jadwal_pelajaran' => $id_jadwal_pelajaran ?? 1,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status presensi berhasil diperbarui untuk semua user.');
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
