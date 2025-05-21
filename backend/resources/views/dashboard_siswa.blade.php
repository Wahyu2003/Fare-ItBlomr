@extends('layouts.siswa')

@section('contents')
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
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .dashboard-title {
        font-size: 26px;
        font-weight: 600;
        color: var(--dark-color);
        margin: 0;
    }

    .welcome-message {
        font-size: 14px;
        color: #6c757d;
        margin-top: 6px;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 16px;
        box-shadow: var(--box-shadow);
        margin-bottom: 24px;
    }

    .filter-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 16px;
        color: var(--dark-color);
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: #495057;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ced4da;
        border-radius: var(--border-radius);
        transition: var(--transition);
        font-size: 13px;
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
        padding: 8px 16px;
        border-radius: var(--border-radius);
        cursor: pointer;
        font-weight: 500;
        transition: var(--transition);
        align-self: flex-end;
        font-size: 14px;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    /* Stats Section */
    .stats-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    .chart-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 16px;
        box-shadow: var(--box-shadow);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .pie-chart-card .chart-container {
        max-width: 300px;
        height: 250px;
        margin: 0 auto;
    }

    .bar-chart-card .chart-container {
        min-height: 250px;
    }

    .chart-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 16px;
        color: var(--dark-color);
    }

    .chart-container {
        flex: 1;
        min-height: 200px;
        position: relative;
    }

    .chart-footer {
        margin-top: 16px;
    }

    .legend-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
    }

    .legend-item {
        display: flex;
        align-items: center;
        font-size: 13px;
        padding: 4px 10px;
        border-radius: 20px;
        background-color: rgba(248, 249, 250, 0.8);
    }

    .legend-color {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 6px;
    }

    /* Table Section */
    .table-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 16px;
        box-shadow: var(--box-shadow);
        overflow-x: auto;
    }

    .table-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 16px;
        color: var(--dark-color);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .data-table th {
        background-color: #f8f9fa;
        padding: 10px 12px;
        text-align: left;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
    }

    .data-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .data-table tr:hover {
        background-color: #f8f9fa;
    }

    .status-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }

    .status-present { background-color: rgba(76, 201, 240, 0.1); color: #4cc9f0; }
    .status-late { background-color: rgba(248, 150, 30, 0.1); color: #f8961e; }
    .status-absent { background-color: rgba(249, 65, 68, 0.1); color: #f94144; }
    .status-permit { background-color: rgba(111, 66, 193, 0.1); color: #6f42c1; }
    .status-sick { background-color: rgba(32, 201, 151, 0.1); color: #20c997; }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .stats-section {
            grid-template-columns: 1fr;
        }
        .pie-chart-card .chart-container {
            max-width: 250px;
            height: 200px;
        }
        .bar-chart-card .chart-container {
            min-height: 200px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .dashboard-title {
            font-size: 22px;
        }
        .welcome-message {
            font-size: 13px;
        }
        .filter-form {
            grid-template-columns: 1fr;
        }
        .filter-section {
            padding: 12px;
        }
        .filter-title {
            font-size: 15px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
        }
        .chart-card {
            padding: 12px;
        }
        .chart-title {
            font-size: 15px;
        }
        .legend-container {
            justify-content: flex-start;
            gap: 10px;
        }
        .legend-item {
            font-size: 12px;
        }
        .table-section {
            padding: 12px;
        }
        .table-title {
            font-size: 15px;
        }
        .data-table {
            font-size: 12px;
        }
        .data-table th, .data-table td {
            padding: 8px 10px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-container {
            padding: 10px;
        }
        .dashboard-title {
            font-size: 20px;
        }
        .welcome-message {
            font-size: 12px;
        }
        .filter-section {
            padding: 10px;
        }
        .form-control {
            padding: 6px 8px;
            font-size: 12px;
        }
        .form-label {
            font-size: 13px;
        }
        .btn-primary {
            font-size: 13px;
        }
        .pie-chart-card .chart-container {
            max-width: 200px;
            height: 180px;
        }
        .bar-chart-card .chart-container {
            min-height: 180px;
        }
        .chart-title {
            font-size: 14px;
        }
        .legend-item {
            font-size: 11px;
            padding: 3px 8px;
        }
        .legend-color {
            width: 8px;
            height: 8px;
        }
        .table-section {
            padding: 10px;
        }
        .data-table {
            font-size: 11px;
        }
        .data-table th, .data-table td {
            padding: 6px 8px;
        }
        .status-badge {
            font-size: 10px;
            padding: 2px 6px;
        }
    }

    .custom-date-range {
        display: none;
        grid-column: 1 / -1;
    }

    .custom-date-range.active {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Rekapan Absensi</h1>
            <p class="welcome-message">Selamat datang, {{ auth()->user()->nama }}! Berikut adalah rekapan absensi Anda.</p>
        </div>
    </div>

    <!-- Filter Section -->
    <section class="filter-section">
        <h3 class="filter-title">Filter Data</h3>
        <form action="{{ route('rekapanAbsenSiswa.index') }}" method="GET" class="filter-form">
            <div class="form-group">
                <label for="status" class="form-label">Status Kehadiran</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="tepat waktu" {{ $statusFilter == 'tepat waktu' ? 'selected' : '' }}>Hadir</option>
                    <option value="telat" {{ $statusFilter == 'telat' ? 'selected' : '' }}>Telat</option>
                    <option value="alpha" {{ $statusFilter == 'alpha' ? 'selected' : '' }}>Alpa</option>
                    <option value="izin" {{ $statusFilter == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ $statusFilter == 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>

            <div class="form-group">
                <label for="time_filter" class="form-label">Periode Waktu</label>
                <select name="time_filter" id="time_filter" class="form-control">
                    <option value="week" {{ $timeFilter == 'week' ? 'selected' : '' }}>1 Minggu Terakhir</option>
                    <option value="month" {{ $timeFilter == 'month' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                    <option value="custom" {{ $timeFilter == 'custom' ? 'selected' : '' }}>Rentang Tanggal</option>
                </select>
            </div>

            <div class="custom-date-range {{ $timeFilter == 'custom' ? 'active' : '' }}" id="custom-date-range">
                <div class="form-group">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate ? $startDate->toDateString() : '' }}" />
                </div>
                <div class="form-group">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate ? $endDate->toDateString() : '' }}" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
        </form>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <!-- Pie Chart -->
        <div class="chart-card pie-chart-card">
            <h3 class="chart-title">Distribusi Kehadiran</h3>
            <div class="chart-container">
                <canvas id="attendancePieChart"></canvas>
            </div>
            <div class="chart-footer">
                <div class="legend-container">
                    <div class="legend-item"><span class="legend-color" style="background-color: #4BC0C0;"></span>Hadir: {{ round($hadirPercentage, 2) }}%</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #FFCE56;"></span>Telat: {{ round($telatPercentage, 2) }}%</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #FF6384;"></span>Alpa: {{ round($alphaPercentage, 2) }}%</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #FF9F40;"></span>Izin: {{ round($izinPercentage, 2) }}%</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #36A2EB;"></span>Sakit: {{ round($sakitPercentage, 2) }}%</div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="chart-card bar-chart-card">
            <h3 class="chart-title">Statistik {{ $timeFilter == 'week' ? 'Harian' : ($timeFilter == 'month' ? 'Mingguan' : 'Harian') }}</h3>
            <div class="chart-container">
                <canvas id="monthlyBarChart"></canvas>
            </div>
            <div class="chart-footer">
                <div class="legend-container">
                    <div class="legend-item"><span class="legend-color" style="background-color: #4BC0C0;"></span>Hadir</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #FFCE56;"></span>Telat</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #FF6384;"></span>Alpa</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #FF9F40;"></span>Izin</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #36A2EB;"></span>Sakit</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="table-section">
        <h3 class="table-title">Detail Presensi</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensi as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->jadwalPelajaran->hari }}</td>
                        <td>{{ $item->jadwalPelajaran->jam_mulai }} - {{ $item->jadwalPelajaran->jam_selesai }}</td>
                        <td>{{ $item->jadwalPelajaran->ruangan }}</td>
                        <td>
                            @php
                            $statusClass = '';
                            switch($item->kehadiran) {
                                case 'tepat waktu': $statusClass = 'status-present'; break;
                                case 'telat': $statusClass = 'status-late'; break;
                                case 'alpha': $statusClass = 'status-absent'; break;
                                case 'izin': $statusClass = 'status-permit'; break;
                                case 'sakit': $statusClass = 'status-sick'; break;
                            }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($item->kehadiran) }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->waktu_presensi)->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Tidak ada data presensi untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart
    const pieCtx = document.getElementById('attendancePieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Hadir', 'Telat', 'Alpa', 'Izin', 'Sakit'],
            datasets: [{
                data: [
                    {{ $hadirPercentage }},
                    {{ $telatPercentage }},
                    {{ $alphaPercentage }},
                    {{ $izinPercentage }},
                    {{ $sakitPercentage }}
                ],
                backgroundColor: ['#4BC0C0', '#FFCE56', '#FF6384', '#FF9F40', '#36A2EB'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.label + ': ' + ctx.raw.toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    });

    // Bar Chart
    const barCtx = document.getElementById('monthlyBarChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Hadir',
                    data: {!! json_encode($dataHadir) !!},
                    backgroundColor: '#4BC0C0',
                },
                {
                    label: 'Telat',
                    data: {!! json_encode($dataTelat) !!},
                    backgroundColor: '#FFCE56',
                },
                {
                    label: 'Alpa',
                    data: {!! json_encode($dataAlpha) !!},
                    backgroundColor: '#FF6384',
                },
                {
                    label: 'Izin',
                    data: {!! json_encode($dataIzin) !!},
                    backgroundColor: '#FF9F40',
                },
                {
                    label: 'Sakit',
                    data: {!! json_encode($dataSakit) !!},
                    backgroundColor: '#36A2EB',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                    grid: { display: false },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10,
                        font: { size: 12 }
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 12 }
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.dataset.label + ': ' + ctx.raw;
                        }
                    }
                }
            }
        }
    });

    // Toggle custom date range
    const timeFilterSelect = document.getElementById('time_filter');
    const customDateRange = document.getElementById('custom-date-range');
    timeFilterSelect.addEventListener('change', function() {
        customDateRange.classList.toggle('active', this.value === 'custom');
    });
});
</script>
@endsection
