@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f94144;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .welcome-message {
            font-size: 16px;
            color: #6c757d;
            margin-top: 8px;
        }

        /* Filter Section */
        /* .filter-section {
                                    background: white;
                                    border-radius: var(--border-radius);
                                    padding: 20px;
                                    box-shadow: var(--box-shadow);
                                    margin-bottom: 30px;
                                } */

        .filter-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: var(--dark-color);
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
            outline: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            align-self: flex-end;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-present {
            color: #4cc9f0;
        }

        .stat-permit {
            color: #6f42c1;
        }

        .stat-absent {
            color: #f94144;
        }

        .stat-relay-on {
            color: #4cc9f0;
        }

        .stat-relay-off {
            color: #f94144;
        }

        .stat-temp {
            color: #f8961e;
        }

        .stat-teacher-present {
            color: #20c997;
        }

        .stat-teacher-absent {
            color: #f94144;
        }

        /* Table Section */
        .table-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            overflow-x: auto;
        }

        .table-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: var(--dark-color);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .data-table th {
            background-color: var(--primary-color);
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #fff;
            border-bottom: 2px solid #e9ecef;
        }

        .data-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .data-table tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-present {
            background-color: rgba(76, 201, 240, 0.1);
            color: #4cc9f0;
        }

        .status-late {
            background-color: rgba(248, 150, 30, 0.1);
            color: #f8961e;
        }

        .status-absent {
            background-color: rgba(249, 65, 68, 0.1);
            color: #f94144;
        }

        .status-permit {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .status-sick {
            background-color: rgba(32, 201, 151, 0.1);
            color: #20c997;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Admin Dashboard</h1>
                <p class="welcome-message">
                    Selamat datang, <span class="username" style="color:#f94144"><b>{{ Auth::user()->nama }}</b></span>! Berikut adalah ringkasan sistem hari ini.
                </p>
            </div>
        </div>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stat-card">
                <h3 class="stat-title">Kehadiran Siswa</h3>
                <div class="stat-value stat-present" id="jumlah_hadir">{{ $jumlahHadir }}</div>
                <p>Hadir</p>
            </div>

            <div class="stat-card">
                <h3 class="stat-title">Izin Siswa</h3>
                <div class="stat-value stat-permit" id="jumlah_izin">{{ $jumlahIzin }}</div>
                <p>Izin</p>
            </div>

            <div class="stat-card">
                <h3 class="stat-title">Alpa Siswa</h3>
                <div class="stat-value stat-absent" id="jumlah_alpa">{{ $jumlahAlpa }}</div>
                <p>Alpa</p>
            </div>

            <div class="stat-card">
                <h3 class="stat-title">Status Relay</h3>
                <div class="stat-value stat-relay-off" id="relay_status">OFF</div>
                <p>Status Perangkat</p>
            </div>

            <div class="stat-card">
                <h3 class="stat-title">Suhu Ruangan</h3>
                <div class="stat-value stat-temp" id="temperature">N/A</div>
                <p>Suhu Terkini</p>
            </div>

            <div class="stat-card">
                <h3 class="stat-title">Kehadiran Guru</h3>
                <div class="stat-value stat-teacher-absent" id="guru_hadir">Tidak Hadir</div>
                <p>Status Guru</p>
            </div>
        </section>

        <!-- Table Section -->
        <section class="table-section">
            <h3 class="table-title">Data Presensi Hari Ini</h3>
            <div class="filter-form">
                <div class="form-group mb-3">
                    <select id="kelas" class="form-control">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Presensi</th>
                        </tr>
                    </thead>
                    <tbody id="data_presensi">
                        @foreach ($presensiData as $presensi)
                            <tr>
                                <td>{{ $presensi->user->nama }}</td>
                                <td>{{ $presensi->user->kelas->nama_kelas ?? 'N/A' }}</td>
                                @php
                                    $statusClass = '';
                                    switch ($presensi->kehadiran) {
                                        case 'tepat waktu':
                                            $statusClass = 'status-present';
                                            break;
                                        case 'telat':
                                            $statusClass = 'status-late';
                                            break;
                                        case 'alpha':
                                            $statusClass = 'status-absent';
                                            break;
                                        case 'izin':
                                            $statusClass = 'status-permit';
                                            break;
                                        case 'sakit':
                                            $statusClass = 'status-sick';
                                            break;
                                    }
                                @endphp
                                <td><span class="status-badge {{ $statusClass }}">{{ ucfirst($presensi->kehadiran) }}</span></td>
                                <td>{{ $presensi->waktu_presensi }}</td>
                                <td>{{ $presensi->jenis_absen ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-database-compat.js"></script>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyCMOv8YNAVKo2qjkJjpa9ACZxtCP8Y85Dw",
            authDomain: "smartsmkn4.firebaseapp.com",
            databaseURL: "https://smartsmkn4-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "smartsmkn4",
            storageBucket: "smartsmkn4.firebasestorage.app",
            messagingSenderId: "528593838541",
            appId: "1:528593838541:web:e8d8d64d6fe2d87f9ae484",
            measurementId: "G-42R0DH356W"
        };

        firebase.initializeApp(firebaseConfig);
        const db = firebase.database();

        const relayStatusElem = document.getElementById("relay_status");
        const temperatureElem = document.getElementById("temperature");

        const ds18b20Ref = db.ref('ds18b20');

        ds18b20Ref.on('value', (snapshot) => {
            const data = snapshot.val();
            console.log('Firebase data:', data);
            if (data) {
                relayStatusElem.innerText = data.relay_status || 'OFF';
                relayStatusElem.className = data.relay_status === 'ON' ? 'stat-value stat-relay-on' :
                    'stat-value stat-relay-off';

                temperatureElem.innerText = data.temperature !== undefined ? data.temperature : 'N/A';
            }
        });

        function updateDashboardAdmin() {
            const kelas = document.getElementById("kelas").value;

            fetch(`/update-dashboard-admin?kelas=${kelas}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("jumlah_hadir").innerText = data.jumlahHadir;
                    document.getElementById("jumlah_izin").innerText = data.jumlahIzin;
                    document.getElementById("jumlah_alpa").innerText = data.jumlahAlpa;

                    const guruElement = document.getElementById("guru_hadir");
                    guruElement.innerText = data.guruHadir ? 'Hadir' : 'Tidak Hadir';
                    guruElement.className = data.guruHadir ? 'stat-value stat-teacher-present' :
                        'stat-value stat-teacher-absent';

                    let tableRows = '';
                    data.dataSiswaHariIni.forEach(presensi => {
                        let statusClass = '';
                        switch (presensi.kehadiran) {
                            case 'tepat waktu':
                                statusClass = 'status-present';
                                break;
                            case 'telat':
                                statusClass = 'status-late';
                                break;
                            case 'alpha':
                                statusClass = 'status-absent';
                                break;
                            case 'izin':
                                statusClass = 'status-permit';
                                break;
                            case 'sakit':
                                statusClass = 'status-sick';
                                break;
                        }
                        tableRows += `
                            <tr>
                                <td>${presensi.user.nama}</td>
                                <td>${presensi.user.kelas?.nama_kelas || 'N/A'}</td>
                                <td><span class="status-badge ${statusClass}">${presensi.kehadiran}</span></td>
                                <td>${new Date(presensi.waktu_presensi).toLocaleString()}</td>
                                <td>${presensi.jenis_absen || '-'}</td>
                            </tr>
                        `;
                    });
                    document.getElementById("data_presensi").innerHTML = tableRows;
                })
                .catch(error => console.error("Error updating dashboard:", error));
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('kelas').addEventListener('change', updateDashboardAdmin);
            updateDashboardAdmin();
        });
    </script>
@endsection
