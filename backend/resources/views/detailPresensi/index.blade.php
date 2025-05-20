@extends('layouts.admin')

@section('content')
    <style>
        /* Section Title */
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Layout untuk Video dan Kontrol */
        .video-control-layout {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .video-section {
            flex: 0 0 50%;
        }

        .control-section {
            flex: 0 0 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 15px;
        }

        /* Video Container */
        .video-container {
            text-align: center;
        }

        .control-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .video-container video {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .video-container canvas {
            display: none;
        }

        /* Result Message */
        .result-message {
            font-size: 1rem;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 10px;
        }

        .result-message.loading {
            background-color: #f8f9fa;
            color: #666;
        }

        .result-message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .result-message.fail {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Button Controls */
        .control-buttons {
            display: flex;
            gap: 10px;
        }

        .control-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .control-btn.start {
            background-color: #007bff;
            color: #fff;
        }

        .control-btn.start:hover {
            background-color: #0056b3;
        }

        .control-btn.stop {
            background-color: #dc3545;
            color: #fff;
        }

        .control-btn.stop:hover {
            background-color: #c82333;
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-section label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .filter-section select {
            width: 150px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Layout untuk Tabel */
        .tables-layout {
            display: flex;
            gap: 20px;
        }

        .table-section {
            flex: 0 0 50%;
        }
    </style>

    <div class="container">
        <h2 class="section-title">Presensi Wajah Otomatis</h2>

        <!-- Layout Video dan Kontrol -->
        <div class="video-control-layout">
            <!-- Sisi Kiri: Video -->
            <div class="video-section">
                <div class="video-container">
                    <video id="video" width="320" height="240" muted></video>
                    <canvas id="canvas" width="320" height="240"></canvas>
                </div>
                <div class="control-buttons">
                    <button id="startBtn" class="control-btn start">Mulai</button>
                    <button id="stopBtn" class="control-btn stop" disabled>Berhenti</button>
                </div>
            </div>

            <!-- Sisi Kanan: Tombol dan Status -->
            <div class="control-section">
                <div id="result" class="result-message fail">Kamera belum aktif.</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div>
                <label for="roleFilter">Role:</label>
                <select id="roleFilter" onchange="filterPresensi()">
                    <option value="">Semua Role</option>
                    <option value="SISWA">Siswa</option>
                    <option value="GURU">Guru</option>
                </select>
            </div>
            <div>
                <label for="kelasFilter" id="labelf">Kelas:</label>
                <select id="kelasFilter" onchange="filterPresensi()">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Layout Tabel -->
        <div class="tables-layout">
            <!-- Tabel Belum Presensi -->
            <div class="table-section">
                <h3 class="section-title">Belum Presensi</h3>
                <form method="POST" action="{{ route('detailPresensi.updateMultipleStatus') }}">
                    @csrf
                    <table class="admin-table" id="belumPresensiTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Action (Pilih Status)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($belumPresensi as $user)
                                <tr>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <select name="statuses[{{ $user->id_user }}]" class="form-select form-select-sm"
                                            aria-label="Pilih Status">
                                            <option value="" selected>-- Belum Hadir --</option>
                                            <option value="izin">Izin</option>
                                            <option value="alpha">Alfa</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center;">Semua user sudah presensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($belumPresensi->count() > 0)
                        <button type="submit" class="btn btn-warning mt-3">Update Semua Presensi</button>
                    @endif
                </form>
            </div>

            <!-- Tabel Sudah Presensi -->
            <div class="table-section">
                <h3 class="section-title">Sudah Presensi</h3>
                <table class="admin-table" id="sudahPresensiTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sudahPresensi as $presensi)
                            <tr data-kelas="{{ $presensi->user->kelas_id }}" data-role="{{ $presensi->user->role }}">
                                <td>{{ $presensi->user->nama }}</td>
                                <td>{{ $presensi->user->role }}</td>
                                <td>{{ $presensi->jenis_absen }} | {{ $presensi->kehadiran }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->waktu_presensi)->format('H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Belum ada data siswa yang sudah presensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const resultDiv = document.getElementById('result');
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let detecting = false;
        let intervalId = null;
        let stream = null;

        // Fungsi untuk memulai kamera dan deteksi
        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                video.srcObject = stream;
                video.play();
                resultDiv.textContent = "Kamera aktif. Mendeteksi wajah...";
                resultDiv.className = "result-message loading";

                intervalId = setInterval(() => {
                    if (!detecting) {
                        detectFace();
                    }
                }, 3000);

                startBtn.disabled = true;
                stopBtn.disabled = false;
            } catch (err) {
                resultDiv.textContent = "❌ Gagal mengakses kamera: " + err.message;
                resultDiv.className = "result-message fail";
            }
        }

        // Fungsi untuk menghentikan kamera
        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
                clearInterval(intervalId);
                resultDiv.textContent = "Kamera dimatikan.";
                resultDiv.className = "result-message fail";
                startBtn.disabled = false;
                stopBtn.disabled = true;
            }
        }

        // Event listener untuk tombol Mulai
        startBtn.addEventListener('click', () => {
            if (navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function') {
                startCamera();
            } else {
                resultDiv.textContent = "❌ Browser tidak mendukung akses kamera (getUserMedia).";
                resultDiv.className = "result-message fail";
            }
        });

        // Event listener untuk tombol Berhenti
        stopBtn.addEventListener('click', stopCamera);

        // Fungsi untuk mendeteksi wajah
        async function detectFace() {
            detecting = true;
            resultDiv.textContent = "Mendeteksi wajah...";
            resultDiv.className = "result-message loading";

            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(async blob => {
                const file = new File([blob], "photo.jpg", {
                    type: "image/jpeg"
                });
                const formData = new FormData();
                formData.append("photo", file);

                try {
                    const res = await fetch("{{ route('detailPresensi.send') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const text = await res.text();
                    let data;
                    console.log(data);
                    try {
                        data = JSON.parse(text);
                        console.log(data);
                    } catch (e) {
                        resultDiv.textContent = "❌ Respon tidak valid dari server.";
                        resultDiv.className = "result-message fail";
                        console.error("Respon bukan JSON:\n", text);
                        detecting = false;
                        return;
                    }

                    if (data.name) {
                        resultDiv.textContent = `✅ Selamat datang, ${data.name}`;
                        resultDiv.className = "result-message success";
                        clearInterval(intervalId);
                        setTimeout(() => location.reload(), 2000); // Reload setelah 2 detik
                    } else {
                        resultDiv.textContent = data.error || "❌ Wajah tidak cocok atau belum terdaftar.";
                        resultDiv.className = "result-message fail";
                    }
                } catch (error) {
                    resultDiv.textContent = "❌ Gagal mengirim ke server.";
                    resultDiv.className = "result-message fail";
                    console.error("Error:", error);
                } finally {
                    detecting = false;
                }
            }, 'image/jpeg');
        }

        // Fungsi untuk memfilter tabel
        function filterPresensi() {
            const kelasFilter = document.getElementById('kelasFilter');
            const labelFilter = document.getElementById('labelf'); // Mengambil elemen label kelas
            const roleFilter = document.getElementById('roleFilter').value;

            // Mengatur kelasFilter dan labelFilter berdasarkan pilihan roleFilter
            if (roleFilter === 'GURU') {
                kelasFilter.disabled = true; // Menonaktifkan kelasFilter
                kelasFilter.style.display = 'none'; // Menyembunyikan kelasFilter
                labelFilter.style.display = 'none'; // Menyembunyikan label kelas
            } else {
                kelasFilter.disabled = false; // Mengaktifkan kembali kelasFilter
                kelasFilter.style.display = 'inline-block'; // Menampilkan kembali kelasFilter
                labelFilter.style.display = 'block'; // Memastikan label tampil dengan benar
            }

            // Filter tabel Belum Presensi
            const belumRows = document.querySelectorAll('#belumPresensiTable tbody tr');
            belumRows.forEach(row => {
                const kelas = row.getAttribute('data-kelas') || '';
                const role = row.getAttribute('data-role') || '';
                const kelasMatch = !kelasFilter.value || kelas === kelasFilter.value;
                const roleMatch = !roleFilter || role.toUpperCase() === roleFilter.toUpperCase();
                row.style.display = (kelasMatch && roleMatch) ? '' : 'none';
            });

            // Filter tabel Sudah Presensi
            const sudahRows = document.querySelectorAll('#sudahPresensiTable tbody tr');
            sudahRows.forEach(row => {
                const kelas = row.getAttribute('data-kelas') || '';
                const role = row.getAttribute('data-role') || '';
                const kelasMatch = !kelasFilter.value || kelas === kelasFilter.value;
                const roleMatch = !roleFilter || role.toUpperCase() === roleFilter.toUpperCase();
                row.style.display = (kelasMatch && roleMatch) ? '' : 'none';
            });
        }
    </script>
@endsection
