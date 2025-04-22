@extends('layouts.admin')

@section('content')
    <h2>Daftar Jadwal Belajar</h2>
    <a href="{{ route('jadwal_bel.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwals as $jadwal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ $jadwal->jam }}</td>
                    <td>{{ $jadwal->keterangan }}</td>
                    <td>
                        <a href="{{ route('jadwal_bel.edit', $jadwal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jadwal_bel.destroy', $jadwal->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
