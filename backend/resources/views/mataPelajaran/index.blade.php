@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Mata Pelajaran</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('mataPelajaran.create') }}" class="btn btn-success mb-3">Tambah Mata Pelajaran</a>
    <!-- Form Filter -->
    <form method="GET" action="{{ route('mataPelajaran.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="kelas">Filter Kelas:</label>
                <select name="kelas" id="kelas" class="form-control">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ $kelasFilter == $kelas->id_kelas ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mataPelajaran as $index => $mp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mp->nama_mata_pelajaran }}</td>
                    <td>{{ $mp->kelas->nama_kelas ?? '-' }}</td>
                    <td>
                        <a href="{{ route('mataPelajaran.edit', $mp->id_mata_pelajaran) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('mataPelajaran.destroy', $mp->id_mata_pelajaran) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data mata pelajaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
