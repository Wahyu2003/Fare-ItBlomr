@extends('layouts.admin')

@section('content')
    <h2>Jadwal Bunyi Bel Otomatis</h2>
    <a href="{{ route('jadwal_bel.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Jadwal Bel</a>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
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
                        <a href="{{ route('jadwal_bel.edit', $jadwal->id) }}" class="btn btn-warning btn-sm" style="display:inline;"><i class="fas fa-pencil-alt"></i></a>
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
