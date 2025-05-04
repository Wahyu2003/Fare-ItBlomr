@extends('layouts.admin')

@section('content')
    <h2>Dashboard</h2>

    <!-- Filter Kelas -->
    <div class="mb-4">
        <label for="kelas">Pilih Kelas:</label>
        <select id="kelas" class="form-control" onchange="updateDashboard()">
            <option value="10">Kelas 10</option>
            <option value="11">Kelas 11</option>
            <option value="12">Kelas 12</option>
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
        <!-- Kotak 2 (Jumlah Siswa Hadir, Alpa, Izin untuk Kelas yang Dipilih) -->
        <div class="col-md-4">
        <div class="admin-card">
                <h3 id="jumlah_hadir">Hadir: 30</h3>
                <h3 id="jumlah_izin">Izin: 3</h3>
                <h3 id="jumlah_alpa">Alpa: 3</h3>
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
            <tr>
                <td>Kolom 1</td>
                <td>Kolom 2</td>
                <td>Kolom 3</td>
                <td>Kolom 4</td>
                <td>Kolom 5</td>
                <td>Kolom 6</td>
            </tr>
        </tbody>
    </table>

    <script>
        // Fungsi untuk mengupdate tampilan dashboard berdasarkan kelas yang dipilih
        function updateDashboard() {
            const kelas = document.getElementById("kelas").value;

            // Logika untuk mengambil data berdasarkan kelas yang dipilih (kelas 10, 11, 12)
            // Berikut contoh data statis, Anda bisa menggantinya dengan data dinamis dari backend.
            if (kelas === "10") {
                document.getElementById("jumlah_hadir").innerText = "Hadir: 30";  // Jumlah siswa hadir kelas 10
                document.getElementById("jumlah_izin").innerText = "Izin: 3";  // Jumlah siswa izin kelas 10
                document.getElementById("jumlah_alpa").innerText = "Alpa: 3";  // Jumlah siswa alpa kelas 10
                document.getElementById("total_siswa").innerText = "36";  // Total siswa kelas 10
                document.getElementById("guru_hadir").innerText = "Hadir";  // Status guru kelas 10

                // Update tabel presensi siswa
                document.getElementById("data_presensi").innerHTML = `
                    <tr>
                        <td>12345</td>
                        <td>Ahmad</td>
                        <td>Kelas 10</td>
                        <td>Hadir</td>
                        <td>08:00</td>
                        <td><a href="#">Bukti</a></td>
                    </tr>
                    <tr>
                        <td>12346</td>
                        <td>Siti</td>
                        <td>Kelas 10</td>
                        <td>Izin</td>
                        <td>08:05</td>
                        <td><a href="#">Bukti</a></td>
                    </tr>
                `;
            } else if (kelas === "11") {
                document.getElementById("jumlah_hadir").innerText = "Hadir: 32";  // Jumlah siswa hadir kelas 11
                document.getElementById("jumlah_izin").innerText = "Izin: 2";  // Jumlah siswa izin kelas 11
                document.getElementById("jumlah_alpa").innerText = "Alpa: 2";  // Jumlah siswa alpa kelas 11
                document.getElementById("total_siswa").innerText = "36";  // Total siswa kelas 11
                document.getElementById("guru_hadir").innerText = "Tidak Hadir";  // Status guru kelas 11

                // Update tabel presensi siswa
                document.getElementById("data_presensi").innerHTML = `
                    <tr>
                        <td>22345</td>
                        <td>Budi</td>
                        <td>Kelas 11</td>
                        <td>Alpa</td>
                        <td>08:00</td>
                        <td><a href="#">Bukti</a></td>
                    </tr>
                    <tr>
                        <td>22346</td>
                        <td>Rina</td>
                        <td>Kelas 11</td>
                        <td>Hadir</td>
                        <td>08:10</td>
                        <td><a href="#">Bukti</a></td>
                    </tr>
                `;
            } else if (kelas === "12") {
                document.getElementById("jumlah_hadir").innerText = "Hadir: 33";  // Jumlah siswa hadir kelas 12
                document.getElementById("jumlah_izin").innerText = "Izin: 2";  // Jumlah siswa izin kelas 12
                document.getElementById("jumlah_alpa").innerText = "Alpa: 1";  // Jumlah siswa alpa kelas 12
                document.getElementById("total_siswa").innerText = "36";  // Total siswa kelas 12
                document.getElementById("guru_hadir").innerText = "Hadir";  // Status guru kelas 12

                // Update tabel presensi siswa
                document.getElementById("data_presensi").innerHTML = `
                    <tr>
                        <td>32345</td>
                        <td>Wati</td>
                        <td>Kelas 12</td>
                        <td>Hadir</td>
                        <td>08:00</td>
                        <td><a href="#">Bukti</a></td>
                    </tr>
                    <tr>
                        <td>32346</td>
                        <td>Fajar</td>
                        <td>Kelas 12</td>
                        <td>Izin</td>
                        <td>08:05</td>
                        <td><a href="#">Bukti</a></td>
                    </tr>
                `;
            }
        }
    </script>
@endsection
