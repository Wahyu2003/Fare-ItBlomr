@extends('layouts.admin')

@section('content')
    <h2>Presensi Wajah Otomatis</h2>

    <div style="display: flex; gap: 20px;">
        {{-- Kolom kiri: Video dan tabel belum presensi --}}
        <div>
            <video id="video" width="320" height="240" autoplay muted></video>
            <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
            <div id="result" class="loading">Menunggu kamera aktif...</div>

            <h3>Belum Presensi</h3>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($belumPresensi as $siswa)
                        <tr>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->nik }}</td>
                            <td>{{ $siswa->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Kolom kanan: Tabel sudah presensi --}}
        <div>
            <h3>Sudah Presensi</h3>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Role</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sudahPresensi as $presensi)
                        <tr>
                            <td>{{ $presensi->user->nama }}</td>
                            <td>{{ $presensi->user->nik }}</td>
                            <td>{{ $siswa->role }}</td>
                            <td>{{ $presensi->created_at->format('H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const resultDiv = document.getElementById('result');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let detecting = false;
        let intervalId = null;

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                resultDiv.textContent = "Kamera aktif. Mendeteksi wajah...";
                resultDiv.className = "loading";

                intervalId = setInterval(() => {
                    if (!detecting) {
                        detectFace();
                    }
                }, 3000);
            })
            .catch(err => {
                resultDiv.textContent = "❌ Gagal mengakses kamera: " + err.message;
                resultDiv.className = "fail";
            });

        async function detectFace() {
            detecting = true;
            resultDiv.textContent = "Mendeteksi wajah...";
            resultDiv.className = "loading";

            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(async blob => {
                const file = new File([blob], "photo.jpg", { type: "image/jpeg" });
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
                    try {
                        data = JSON.parse(text);
                        console.log(data);
                    } catch (e) {
                        resultDiv.textContent = "❌ Respon tidak valid dari server.";
                        resultDiv.className = "fail";
                        console.error("Respon bukan JSON:\n", text);
                        detecting = false;
                        return;
                    }

                    if (data.name) {
                        resultDiv.textContent = `✅ Selamat datang, ${data.name}`;
                        resultDiv.className = "success";
                        clearInterval(intervalId);
                        location.reload(); // reload untuk perbarui tabel
                    } else {
                        resultDiv.textContent = data.error || "❌ Wajah tidak cocok atau belum terdaftar.";
                        resultDiv.className = "fail";
                    }

                } catch (error) {
                    resultDiv.textContent = "❌ Gagal mengirim ke server.";
                    resultDiv.className = "fail";
                    console.error("Error:", error);
                } finally {
                    detecting = false;
                }
            }, 'image/jpeg');
        }
    </script>
@endsection
