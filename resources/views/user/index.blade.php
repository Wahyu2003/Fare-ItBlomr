@extends('layouts.admin')

@section('content')
    <h2>Daftar Wajah</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Siswa</a>
    </div>

    <h3>Daftar Siswa</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Kelas</th>
                <th>No HP Siswa</th>
                <th>Nama Orang Tua</th>
                <th>No HP Orang Tua</th>
                <th>Foto Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($user->role == 'siswa')
                    <tr>
                        <td>{{ $user->nik ?? 'Tidak Ada' }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->kelas ?? 'Tidak Ada' }}</td>
                        <td>{{ $user->no_hp_siswa ?? 'Tidak Ada' }}</td>
                        <td>{{ $user->nama_ortu }}</td>
                        <td>{{ $user->no_hp_ortu }}</td>
                        <td>
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" class="student-photo" alt="Foto Siswa" width="50" height="50">
                            @else
                                Tidak Ada
                            @endif
                            <br>
                            <span>{{ $user->face_encoding ? 'Terdeteksi' : 'Belum Terdeteksi' }}</span> <!-- Menampilkan status face encoding -->
                        </td>
                        <td>
                            <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning" style="display:inline;"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection
