@extends('layouts.admin')

@section('content')
    <h2>Dashboard Admin</h2>

    <!-- Filter Kelas -->
    <div class="mb-4">
        <label for="kelas">Pilih Kelas:</label>
        <select id="kelas" class="form-control" onchange="updateDashboardAdmin()">
            <option value="">Pilih Kelas</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
            @endforeach
        </select>
    </div>

    <div class="row mb-4">
        <!-- Kotak 1 (Jumlah Siswa Hadir, Alpa, Izin untuk Kelas yang Dipilih) -->
        <div class="col-md-4">
            <div class="admin-card">
                <h3 id="jumlah_hadir">Hadir: 30</h3>
                <h3 id="jumlah_izin">Izin: 3</h3>
                <h3 id="jumlah_alpa">Alpa: 3</h3>
            </div>
        </div>

        <!-- Kotak 2 (Data Firebase: Suhu dan Status Relay) -->
        <div class="col-md-4">
            <div class="admin-card">
                <h3 id="relay_status">Relay Status: OFF</h3>
                <h3 id="temperature">Temperature: N/A</h3>
            </div>
        </div>

        <!-- Kotak 3 (Status Kehadiran Guru) -->
        <div class="col-md-4">
            <div class="admin-card">
                <h3 id="guru_hadir">Hadir</h3>
                <p>Kehadiran Guru</p>
            </div>
        </div>
    </div>

    <h3>Data Siswa Hari Ini</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Waktu</th>
                <th>Bukti Hadir</th>
            </tr>
        </thead>
        <tbody id="data_presensi">
            <!-- Data dinamis akan dimasukkan di sini berdasarkan kelas yang dipilih -->
        </tbody>
    </table>

    <script>
        function updateDashboardAdmin() {
            const kelas = document.getElementById("kelas").value;

            fetch(`/update-dashboard-admin?kelas=${kelas}`)
                .then(response => response.json())
                .then(data => {
                    // Update jumlah hadir, izin, alpa untuk siswa
                    document.getElementById("jumlah_hadir").innerText = `Hadir: ${data.jumlahHadir}`;
                    document.getElementById("jumlah_izin").innerText = `Izin: ${data.jumlahIzin}`;
                    document.getElementById("jumlah_alpa").innerText = `Alpa: ${data.jumlahAlpa}`;

                    // Update relay status dan temperature dari Firebase
                    document.getElementById("relay_status").innerText = `Relay Status: ${data.relayStatus}`;
                    document.getElementById("temperature").innerText = `Temperature: ${data.temperature}`;

                    // Update status kehadiran guru
                    document.getElementById("guru_hadir").innerText = data.guruHadir;

                    // Update tabel data presensi siswa
                    let tableRows = '';
                    data.presensiData.forEach(presensi => {
                        tableRows += `
                            <tr>
                                <td>${presensi.user.nik}</td>
                                <td>${presensi.user.name}</td>
                                <td>${presensi.user.kelas.name}</td>
                                <td>${presensi.kehadiran}</td>
                                <td>${presensi.waktu_presensi}</td>
                                <td><a href="#">Bukti</a></td>
                            </tr>
                        `;
                    });

                    document.getElementById("data_presensi").innerHTML = tableRows;
                })
                .catch(error => console.error("Error updating dashboard:", error));
        }

        // Initial load
        updateDashboardAdmin();
    </script>
@endsection
