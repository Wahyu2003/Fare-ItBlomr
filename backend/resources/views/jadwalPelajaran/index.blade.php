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
                    @if($kelasOptions->isNotEmpty())
                        @foreach($kelasOptions as $kelas)
                            <option value="{{ $kelas }}" {{ $kelasFilter == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-3" id="multimediaFilter" style="{{ $roleFilter == 'guru' ? 'display:none' : '' }}">
                <label for="multimedia">Multimedia:</label>
                <select name="multimedia" id="multimedia" class="form-control">
                    <option value="">Semua Multimedia</option>
                    @if($multimediaOptions->isNotEmpty())
                        @foreach($multimediaOptions as $multimedia)
                            <option value="{{ $multimedia }}" {{ $multimediaFilter == $multimedia ? 'selected' : '' }}>{{ $multimedia }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-3" id="guruFilter" style="{{ $roleFilter == 'siswa' ? 'display:none' : '' }}">
                <label for="guru">Guru:</label>
                <select name="guru" id="guru" class="form-control">
                    <option value="">Semua Guru</option>
                    @if($guruOptions->isNotEmpty())
                        @foreach($guruOptions as $guru)
                            <option value="{{ $guru->id_user }}" {{ $guruFilter == $guru->id_user ? 'selected' : '' }}>{{ $guru->nama }}</option>
                        @endforeach
                    @endif
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
                        <th>Multimedia</th>
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
                            <td>{{ $jp->mataPelajaran->kelas ?? 'Tidak Ada' }}</td>
                            <td>{{ $jp->mataPelajaran->multimedia ?? 'Tidak Ada' }}</td>
                            <td>{{ $jp->mataPelajaran->nama_mata_pelajaran ?? 'Tidak Ada' }}</td>
                            <td>{{ $jp->ruangan ?? 'Tidak Ada' }}</td>
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
    const multimediaFilter = document.getElementById('multimediaFilter');
    const guruFilter = document.getElementById('guruFilter');

    if (role === 'guru') {
        kelasFilter.style.display = 'none';
        multimediaFilter.style.display = 'none';
        guruFilter.style.display = 'block';
        document.getElementById('kelas').value = '';
        document.getElementById('multimedia').value = '';
    } else {
        kelasFilter.style.display = 'block';
        multimediaFilter.style.display = 'block';
        guruFilter.style.display = 'none';
        document.getElementById('guru').value = '';
    }
}
</script>
@endsection