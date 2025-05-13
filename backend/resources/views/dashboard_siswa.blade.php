@extends('layouts.siswa')

@section('contents')
<style>
    /* General Container Styling */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Style untuk Lingkaran Persentase */
    .status-circle {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
        color: white;
        position: relative;
        transition: background-color 0.5s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .status-circle p {
        font-size: 14px;
        text-align: center;
        margin: 0;
    }

    /* Style untuk Legend */
    .status-legend {
        font-size: 14px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .status-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .status-item i {
        font-size: 18px;
        margin-right: 10px;
    }

    /* Flexbox Layout untuk Filter dan Status */
    .filter-status-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 30px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .form-filter {
        display: flex;
        flex-direction: column;
        gap: 15px;
        flex: 2;
    }

    .form-filter .row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .form-filter .col-md-3 {
        flex: 1;
        min-width: 200px;
    }

    .form-filter .form-control {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
    }

    .form-filter .btn-primary {
        padding: 8px 20px;
        border-radius: 5px;
        align-self: flex-start;
    }

    .status-legend-container {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
        min-width: 200px;
    }

    /* Table Styling */
    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .table th,
    .table td {
        text-align: center;
        padding: 12px;
        vertical-align: middle;
        border: 1px solid #dee2e6;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Hidden class for custom date range */
    .custom-date-range {
        display: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .filter-status-container {
            flex-direction: column;
            align-items: stretch;
        }

        .form-filter .row {
            flex-direction: column;
            gap: 10px;
        }

        .form-filter .col-md-3 {
            min-width: 100%;
        }

        .status-legend-container {
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
    }
</style>

<div class="container">
    <h2>Rekapan Absen {{ auth()->user()->nama }}</h2>

    <div class="filter-status-container">
        <!-- Filter Form -->
        <form action="{{ route('rekapanAbsenSiswa.index') }}" method="GET" class="form-filter">
            <!-- Status Kehadiran dan Filter Waktu -->
            <div class="row">
                <div class="col-md-3">
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

                <div class="col-md-3">
                    <label for="time_filter" class="form-label">Filter Waktu</label>
                    <select name="time_filter" id="time_filter" class="form-control">
                        <option value="week" {{ $timeFilter == 'week' ? 'selected' : '' }}>1 Minggu Terakhir</option>
                        <option value="month" {{ $timeFilter == 'month' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                        <option value="custom" {{ $timeFilter == 'custom' ? 'selected' : '' }}>Rentang Tanggal</option>
                    </select>
                </div>
            </div>

            <!-- Custom Date Range -->
            <div class="custom-date-range row" id="custom-date-range">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate ? $startDate->toDateString() : '' }}" />
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate ? $endDate->toDateString() : '' }}" />
                </div>
            </div>

            <!-- Filter Button -->
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <!-- Lingkaran Persentase dan Legend -->
        <div class="status-legend-container">
            <div class="status-circle">
                <div class="circle" style="background: conic-gradient(
                        green {{ $hadirPercentage }}%, 
                        yellow {{ $telatPercentage }}%, 
                        red {{ $alphaPercentage }}%, 
                        orange {{ $izinPercentage }}%, 
                        gray {{ $sakitPercentage }}%
                    );">
                    <span>{{ round($totalPercentage, 2) }}%</span>
                </div>
                <p>Kehadiran</p>
            </div>

            <div class="status-legend">
                <div class="status-item" style="color: green;">
                    <i class="fas fa-check-circle"></i> Hadir: {{ $hadirPercentage }}%
                </div>
                <div class="status-item" style="color: yellow;">
                    <i class="fas fa-clock"></i> Telat: {{ $telatPercentage }}%
                </div>
                <div class="status-item" style="color: red;">
                    <i class="fas fa-times-circle"></i> Alpa: {{ $alphaPercentage }}%
                </div>
                <div class="status-item" style="color: orange;">
                    <i class="fas fa-exclamation-circle"></i> Izin: {{ $izinPercentage }}%
                </div>
                <div class="status-item" style="color: blue;">
                    <i class="fas fa-bed"></i> Sakit: {{ $sakitPercentage }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rekapan Absen -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Ruangan</th>
                <th>Status Kehadiran</th>
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
                <td>{{ ucfirst($item->kehadiran) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->waktu_presensi)->format('d-m-Y H:i:s') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Tidak ada data presensi untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timeFilterSelect = document.getElementById('time_filter');
        const customDateRange = document.getElementById('custom-date-range');

        // Function to toggle custom date range visibility
        function toggleCustomDateRange() {
            if (timeFilterSelect.value === 'custom') {
                customDateRange.style.display = 'flex';
            } else {
                customDateRange.style.display = 'none';
            }
        }

        // Initial check on page load
        toggleCustomDateRange();

        // Listen for changes in the time_filter dropdown
        timeFilterSelect.addEventListener('change', toggleCustomDateRange);
    });
</script>
@endsection