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
        .filter-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
        }

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
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: var(--dark-color);
        }

        .chart-container {
            flex: 1;
            min-height: 300px;
            position: relative;
        }

        .chart-footer {
            margin-top: 20px;
        }

        .legend-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 20px;
            background-color: rgba(248, 249, 250, 0.8);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
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
            background-color: #f8f9fa;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #495057;
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

            .legend-container {
                justify-content: flex-start;
            }
        }

        /* Custom Date Range */
        .custom-date-range {
            display: none;
            grid-column: 1 / -1;
        }

        .custom-date-range.active {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
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
                        <input type="date" name="start_date" class="form-control"
                            value="{{ $startDate ? $startDate->toDateString() : '' }}" />
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ $endDate ? $endDate->toDateString() : '' }}" />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            </form>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <!-- Pie Chart Card -->
            <div class="chart-card">
                <h3 class="chart-title">Distribusi Kehadiran</h3>
                <div class="chart-container">
                    <canvas id="attendancePieChart"></canvas>
                </div>
                <div class="chart-footer">
                    <div class="legend-container">
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #4BC0C0;"></span>
                            <span>Hadir: {{ round($hadirPercentage, 2) }}%</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FFCE56;"></span>
                            <span>Telat: {{ round($telatPercentage, 2) }}%</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FF6384;"></span>
                            <span>Alpa: {{ round($alphaPercentage, 2) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart Card -->
            <div class="chart-card">
                <h3 class="chart-title">Statistik Mingguan</h3>
                <div class="chart-container">
                    <canvas id="weeklyBarChart"></canvas>
                </div>
                <div class="chart-footer">
                    <div class="legend-container">
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #4BC0C0;"></span>
                            <span>Hadir</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FFCE56;"></span>
                            <span>Telat</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FF6384;"></span>
                            <span>Alpa</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #FF9F40;"></span>
                            <span>Izin</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: #36A2EB;"></span>
                            <span>Sakit</span>
                        </div>
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
                                    <span class="status-badge {{ $statusClass }}">{{ ucfirst($item->kehadiran) }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->waktu_presensi)->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Tidak ada data presensi untuk periode ini.</td>
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
            // Common chart options
            const commonChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== undefined) {
                                    label += context.parsed.y;
                                } else {
                                    label += context.raw;
                                }
                                return label;
                            }
                        }
                    }
                }
            };

            // Pie Chart Data and Config
            const pieCtx = document.getElementById('attendancePieChart').getContext('2d');
            const pieChart = new Chart(pieCtx, {
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
                        backgroundColor: [
                            '#4BC0C0',
                            '#FFCE56',
                            '#FF6384',
                            '#FF9F40',
                            '#36A2EB'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    ...commonChartOptions,
                    plugins: {
                        ...commonChartOptions.plugins,
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value.toFixed(2)}%`;
                                }
                            }
                        }
                    }
                }
            });

            // Bar Chart Data and Config
            const barCtx = document.getElementById('weeklyBarChart').getContext('2d');
            const barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                    datasets: [
                        {
                            label: 'Hadir',
                            data: [5, 4, 6, 5, 4, 0],
                            backgroundColor: '#4BC0C0',
                        },
                        {
                            label: 'Telat',
                            data: [1, 0, 0, 1, 0, 0],
                            backgroundColor: '#FFCE56',
                        },
                        {
                            label: 'Alpa',
                            data: [0, 0, 0, 0, 0, 0],
                            backgroundColor: '#FF6384',
                        },
                        {
                            label: 'Izin',
                            data: [0, 1, 0, 0, 1, 0],
                            backgroundColor: '#FF9F40',
                        },
                        {
                            label: 'Sakit',
                            data: [0, 0, 0, 0, 0, 0],
                            backgroundColor: '#36A2EB',
                        }
                    ]
                },
                options: {
                    ...commonChartOptions,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Toggle custom date range
            const timeFilterSelect = document.getElementById('time_filter');
            const customDateRange = document.getElementById('custom-date-range');

            function toggleCustomDateRange() {
                if (timeFilterSelect.value === 'custom') {
                    customDateRange.classList.add('active');
                } else {
                    customDateRange.classList.remove('active');
                }
            }

            timeFilterSelect.addEventListener('change', toggleCustomDateRange);
        });
    </script>
@endsection
