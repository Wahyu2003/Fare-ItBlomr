@extends('layouts.admin')

@section('content')
    <h2>Daftar Wajah</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Siswa</a>
    </div>

    <h3>Daftar Siswa</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Foto</th>
                <th>Tendefar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($user->role == 'siswa')
                    <tr>
                        <td>{{ $user->nik ?? 'Tidak Ada' }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->kelas ?? 'Tidak Ada' }}</td>
                        <td>
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" class="student-photo" alt="Foto Siswa">
                            @else
                                Tidak Ada
                            @endif
                        </td>
                        <td>{{ $user->face_encoding ? 'Terdeteksi' : 'Belum Terdeteksi' }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection