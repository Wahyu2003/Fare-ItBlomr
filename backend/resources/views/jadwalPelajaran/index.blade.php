@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Jadwal Pelajaran</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Filter -->
    <form method="GET" action="{{ route('jadwalPelajaran.index') }}" class="mb-4">
    <div class="row">
    <div class="col-md-3">
        <label for="role">Tampilkan Jadwal Untuk:</label>
        <select name="role" id="role" class="form-control" onchange="toggleFilters()">
            <option value="siswa" {{ $roleFilter == 'siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="guru" {{ $roleFilter == 'guru' ? 'selected' : '' }}>Guru</option>
        </select>
    </div>

    <div class="col-md-3" id="kelasFilter" style="{{ $roleFilter == 'guru' ? 'display:none' : '' }}">
        <label for="kelas">Kelas:</label>
        <select name="kelas" id="kelas" class="form-control">
            <option value="">Semua Kelas</option>
            @foreach($kelasOptions as $id => $nama)
                <option value="{{ $id }}" {{ $kelasFilter == $id ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3" id="guruFilter" style="{{ $roleFilter == 'siswa' ? 'display:none' : '' }}">
        <label for="guru">Guru:</label>
        <select name="guru" id="guru" class="form-control">
            <option value="">Semua Guru</option>
            @foreach($guruOptions as $guru)
                <option value="{{ $guru->id_user }}" {{ $guruFilter == $guru->id_user ? 'selected' : '' }}>{{ $guru->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-primary form-control">Filter</button>
    </div>
</div>
    </form>

    <a href="{{ route('jadwalPelajaran.create') }}" class="btn btn-primary mb-3">Tambah Jadwal Pelajaran</a>

    @if($jadwalPelajaran->isEmpty())
        <p>Tidak ada jadwal pelajaran yang ditemukan.</p>
    @else
        @if($roleFilter == 'siswa')
            <!-- Tabel untuk Siswa -->
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwalPelajaran as $jp)
                        <tr>
                            <td>{{ $jp->hari }}</td>
                            <td>{{ $jp->jam_mulai }}</td>
                            <td>{{ $jp->jam_selesai }}</td>
                            <td>{{ $jp->mataPelajaran->kelas->nama_kelas ?? 'Tidak Ada' }}</td> <!-- Menampilkan nama kelas -->
                            <td>{{ $jp->mataPelajaran->nama_mata_pelajaran ?? 'Tidak Ada' }}</td>
                            <td>{{ $jp->ruangan ?? 'Tidak Ada' }}</td>
                            <td>
                                <a href="{{ route('jadwalPelajaran.edit', $jp->id_jadwal_pelajaran) }}" class="btn btn-sm btn-warning edit" style="padding: 6px 20px; margin-right : 10px; color:white;">Edit</a>
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
        @else
            <!-- Tabel untuk Guru -->
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwalPelajaran as $jp)
                        <tr>
                            <td>{{ $jp->hari }}</td>
                            <td>{{ $jp->jam_mulai }}</td>
                            <td>{{ $jp->jam_selesai }}</td>
                            <td>{{ $jp->mataPelajaran->nama_mata_pelajaran ?? 'Tidak Ada' }}</td>
                            <td>{{ $jp->guru->nama ?? 'Tidak Ada' }}</td>
                            <td>{{ $jp->ruangan ?? 'Tidak Ada' }}</td>
                            <td>
                                <a href="{{ route('jadwalPelajaran.edit', $jp->id_jadwal_pelajaran) }}" class="btn btn-sm btn-warning" style="padding: 5px 16px; margin:10px 0">Edit</a>
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
        @endif
    @endif
</div>

<script>
function toggleFilters() {
    const role = document.getElementById('role').value;
    const kelasFilter = document.getElementById('kelasFilter');
    const guruFilter = document.getElementById('guruFilter');

    if (role === 'guru') {
        kelasFilter.style.display = 'none';
        guruFilter.style.display = 'block';
        document.getElementById('kelas').value = '';
    } else {
        kelasFilter.style.display = 'block';
        guruFilter.style.display = 'none';
        document.getElementById('guru').value = '';
    }
}
</script>
@endsection
