@extends('layouts.admin')

@section('content')
    <!-- <div class="wajahFlipContainer"> -->
        <!-- <h2 class="text-center mb-4">Daftar Wajah</h2> -->

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Kontainer Buku -->
        <div class="wajahFlipBook" id="wajahFlipBook">
            <!-- Halaman Siswa -->
            <div class="wajahFlipPage wajahFlipActive" id="wajahFlipSiswa">
                <div class="wajahFlipSwitch wajahFlipLeft ms-2 mt-2">
                    <a href="{{ route('user.create') }}" class="btn btn-primary wajahFlipAddBtn">Tambah Pengguna</a>
                </div>
                <div class="wajahFlipSwitch wajahFlipRight me-2 mt-2">
                    <button class="btn btn-outline-primary wajahFlipBtn" data-target="guru">
                        Ke Tampilan Guru <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                <h3 class="text-center mb-4">Daftar Siswa</h3>
                <div class="table-responsive">
                    <table class="admin-table table-hover wajahFlipTable">
                        <thead class="table-light">
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Kelas</th> <!-- Menampilkan Kelas -->
                                <th>No HP Siswa</th>
                                <th>Nama Orang Tua</th>
                                <th>No HP Orang Tua</th>
                                <th>Foto Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                @if ($user->role == 'siswa')
                                    <tr>
                                        <td>{{ $user->nik ?? 'Tidak Ada' }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->username }}</td>
                                        <!-- Menampilkan nama kelas yang terkait -->
                                        <td>{{ $user->kelas->nama_kelas ?? 'Tidak Ada' }}</td> <!-- Perbaikan di sini -->
                                        <td>{{ $user->no_hp_siswa ?? 'Tidak Ada' }}</td>
                                        <td>{{ $user->nama_ortu }}</td>
                                        <td>{{ $user->no_hp_ortu }}</td>
                                        <td>
                                            @if ($user->foto)
                                                <img src="{{ asset('storage/' . $user->foto) }}" class="wajahFlipPhoto rounded" alt="Foto Siswa" width="50" height="50">
                                            @else
                                                Tidak Ada
                                            @endif
                                            <br>
                                            <!-- <span class="badge {{ $user->face_encoding ? 'bg-success' : 'bg-warning' }}">{{ $user->face_encoding ? 'Terdeteksi' : 'Belum Terdeteksi' }}</span> -->
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row gap-2">
                                                <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning edit" style="padding: 6px 20px; margin-right : 10px; color:white;">Edit</a>
                                            <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Halaman Guru -->
            <div class="wajahFlipPage" id="wajahFlipGuru">
                <div class="wajahFlipSwitch wajahFlipLeft ms-2 mt-2">
                    <a href="{{ route('user.create') }}" class="btn btn-success wajahFlipAddBtn">Tambah Pengguna</a>
                </div>
                <div class="wajahFlipSwitch wajahFlipRight me-2 mt-2">
                    <button class="btn btn-outline-success wajahFlipBtn" data-target="siswa">
                        <i class="bi bi-arrow-left"></i> Ke Tampilan Siswa
                    </button>
                </div>
                <h3 class="text-center mb-4">Daftar Guru</h3>
                <div class="table-responsive">
                    <table class="admin-tableg table-hover wajahFlipTable">
                        <thead class="table-light  bg-success text-white">
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
                            @forelse ($users as $user)
                                @if ($user->role == 'guru')
                                    <tr>
                                        <td>{{ $user->nik ?? 'Tidak Ada' }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->no_hp_siswa ?? 'Tidak Ada' }}</td>
                                        <td>
                                            @if ($user->foto)
                                                <img src="{{ asset('storage/' . $user->foto) }}" class="wajahFlipPhoto rounded" alt="Foto Guru" width="50" height="50">
                                            @else
                                                Tidak Ada
                                            @endif
                                            <br>
                                            <span class="badge {{ $user->face_encoding ? 'bg-success' : 'bg-warning' }}">{{ $user->face_encoding ? 'Terdeteksi' : 'Belum Terdeteksi' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-sm btn-warning edit" style="padding: 6px 20px; margin-right : 10px; color:white;">Edit</a>
                                            <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data guru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- </div> -->
@endsection
