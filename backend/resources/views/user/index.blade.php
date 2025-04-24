@extends('layouts.admin')

@section('content')
    <h2>Daftar Wajah</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Pengguna</a>
        </div>
    </div>

    <!-- Tabel Siswa -->
    <h3>Daftar Siswa</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>NIK</th>
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
                            <span>{{ $user->face_encoding ? 'Terdeteksi' : 'Belum Terdeteksi' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning" style="padding: 5px 16px; margin:10px 0">Edit</a>
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

    <!-- Tabel Guru -->
    <h3>Daftar Guru</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Username</th>
                <th>No HP</th>
                <th>Foto Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($user->role == 'guru')
                    <tr>
                        <td>{{ $user->nik ?? 'Tidak Ada' }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->no_hp_siswa ?? 'Tidak Ada' }}</td>
                        <td>
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" class="student-photo" alt="Foto Guru" width="50" height="50">
                            @else
                                Tidak Ada
                            @endif
                            <br>
                            <span>{{ $user->face_encoding ? 'Terdeteksi' : 'Belum Terdeteksi' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning" style="padding: 5px 16px; margin:10px 0px">Edit</a>
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