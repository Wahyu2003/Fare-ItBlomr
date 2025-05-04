@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Mata Pelajaran</h1>
    <form action="{{ route('mataPelajaran.storeForm') }}" method="POST" class="admin-form">
        @csrf
        <div class="mb-3">
            <label for="nama_mata_pelajaran">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mata_pelajaran" id="nama_mata_pelajaran" class="form-control" value="{{ old('nama_mata_pelajaran') }}">
            @error('nama_mata_pelajaran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pilihan Kelas (Sekarang menggunakan kelas_id) -->
        <label for="kelas_id">Kelas</label>
        <div class="mb-3 d-flex">
            
            <select name="kelas_id" id="kelas_id" class="form-control">
                
                @foreach($kelas as $kelasItem)
                    <option value="{{ $kelasItem->id_kelas }}" {{ old('kelas_id') == $kelasItem->id_kelas ? 'selected' : '' }}>{{ $kelasItem->nama_kelas }}</option>
                @endforeach
            </select>
            <a href="{{ route('kelas.create') }}" class="btn btn-success">tambah</a>
            @error('kelas_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jadwalPelajaran.create') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
