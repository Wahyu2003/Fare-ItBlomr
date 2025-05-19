@extends('layouts.admin')

@section('content')
<h1>Daftar Mata Pelajaran</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('mataPelajaran.add') }}" class="btn btn-primary mb-3">Tambah Mata Pelajaran</a>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($mataPelajaran as $mp)
        <tr>
            <td>{{ $mp->id_mata_pelajaran }}</td>
            <td>{{ $mp->nama_mata_pelajaran }}</td>
            <td>{{ $mp->kelas->nama_kelas ?? '-' }}</td>
            <td>
                <a href="{{ route('mataPelajaran.edit', $mp->id_mata_pelajaran) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('mataPelajaran.destroy', $mp->id_mata_pelajaran) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $mataPelajaran->links() }} <!-- jika paginate -->

@endsection