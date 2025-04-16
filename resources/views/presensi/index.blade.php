@extends('layouts.admin')

@section('content')
    <h2>Jadwal Pelajaran</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('presensi.create') }}" class="btn btn-primary">Tambah Jadwal</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presensi as $index => $jadwal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>Mata Pelajaran {{ $index + 1 }}</td> <!-- Placeholder untuk mata pelajaran -->
                    <td>{{ $jadwal->kelas->nama_kelas ?? 'Tidak Ada' }}</td>
                    <td>{{ $jadwal->jam_mulai }}</td>
                    <td>{{ $jadwal->jam_selesai }}</td>
                    <td>
                        <a href="{{ route('presensi.edit', $jadwal->id_presensi) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('presensi.destroy', $jadwal->id_presensi) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection