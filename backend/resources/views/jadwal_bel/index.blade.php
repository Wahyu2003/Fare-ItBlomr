@extends('layouts.admin')

@section('content')
    <h2>Jadwal Bunyi Bel</h2>
    <a href="{{ route('jadwal_bel.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Jadwal Bel</a>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Filter Dropdown -->
        <form method="GET" action="{{ route('jadwal_bel.index') }}" class="d-flex">
            <select name="filter" class="form-select me-2" onchange="this.form.submit()">
                <option value="otomatis" {{ request('filter', 'otomatis') == 'otomatis' ? 'selected' : '' }}>Otomatis</option>
                <option value="manual" {{ request('filter') == 'manual' ? 'selected' : '' }}>Manual</option>
            </select>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari / Tanggal</th>
                <th>Jam</th>
                <th>Keterangan</th>
                <th>File Suara</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwals as $jadwal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jadwal->is_manual ? $jadwal->tanggal : $jadwal->hari }}</td>
                    <td>{{ $jadwal->jam }}</td>
                    <td>{{ $jadwal->keterangan }}</td>

                    <td>
                        @if ($jadwal->file_suara)
                            <audio controls style="width: 120px;">
                                <source src="{{ asset('storage/' . $jadwal->file_suara) }}" type="audio/mpeg">
                                Browser tidak mendukung audio
                            </audio>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td>
                        <form method="POST" action="{{ route('jadwal_bel.toggle', $jadwal->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" onchange="this.form.submit()" {{ $jadwal->aktif ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>

                    <td>
                        <a href="{{ route('jadwal_bel.edit', $jadwal->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                        <form action="{{ route('jadwal_bel.destroy', $jadwal->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>                    
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
