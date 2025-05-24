@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Kelas & Tambah Kelas</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah Kelas --}}
            <form action="{{ route('kelas.store') }}" method="POST" style="max-width : 600px;">
                <label for="nama_kelas" class="form-label" >Nama Kelas</label>
                @csrf
                <div class="mb-3 w-100" style="max-width : 600px;">
                    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" value="{{ old('nama_kelas') }}" required>
                    @error('nama_kelas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex w-100 gap-2 mb-3" style="max-width: 600px;">
                    <button type="submit" class="btn btn-primary flex-grow-1">Tambah</button>
                    <a href="{{ session('kelas_previous_url', route('mataPelajaran.index')) }}" class="btn btn-secondary flex-grow-1">Mapel</a>
                </div>
            </form>

    {{-- Tabel Daftar Kelas --}}
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas as $kelasItem)
                <tr>
                    <td>{{ $kelasItem->nama_kelas }}</td>
                    <td>
                        <a href="{{ route('kelas.edit', $kelasItem->id_kelas) }}" class="btn btn-sm btn-warning" style="padding: 6px 20px; margin-right: 10px; color:white;">Edit</a>
                        <form action="{{ route('kelas.destroy', $kelasItem->id_kelas) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
