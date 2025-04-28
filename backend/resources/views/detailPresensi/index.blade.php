@extends('layouts.admin')

@section('content')
    <h2>Presensi Wajah Otomatis</h2>

    <video id="video" width="320" height="240" autoplay muted></video>
    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>

    <div id="result" class="loading">Menunggu kamera aktif...</div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const resultDiv = document.getElementById('result');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
        'content');

        let detecting = false;
        let intervalId = null;

        navigator.mediaDevices.getUserMedia({
                video: true
            })
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
