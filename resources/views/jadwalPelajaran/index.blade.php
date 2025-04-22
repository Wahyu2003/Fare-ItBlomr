@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Jadwal Pelajaran</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('jadwalPelajaran.create') }}" class="btn btn-primary mb-3">Tambah Jadwal Pelajaran</a>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Kelas</th>
                <th>Multimedia</th>
                <th>Mata Pelajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalPelajaran as $jp)
                <tr>
                    <td>{{ $jp->hari }}</td>
                    <td>{{ $jp->jam_mulai }}</td>
                    <td>{{ $jp->jam_selesai }}</td>
                    <td>{{ $jp->kelas }}</td>
                    <td>{{ $jp->multimedia }}</td>
                    <td>{{ $jp->mataPelajaran->nama_mata_pelajaran }}</td>
                    <td>
                        <a href="{{ route('jadwalPelajaran.edit', $jp->id_jadwal_pelajaran) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('jadwalPelajaran.destroy', $jp->id_jadwal_pelajaran) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus jadwal pelajaran ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection