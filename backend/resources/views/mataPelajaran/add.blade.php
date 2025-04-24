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
        <div class="mb-3">
            <label for="kelas">Kelas</label>
            <select name="kelas" id="kelas" class="form-control">
                <option value="">Pilih Kelas</option>
                <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
            </select>
            @error('kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="multimedia">Multimedia</label>
            <select name="multimedia" id="multimedia" class="form-control">
                <option value="">Pilih Multimedia</option>
                <option value="Multimedia 1" {{ old('multimedia') == 'Multimedia 1' ? 'selected' : '' }}>Multimedia 1</option>
                <option value="Multimedia 2" {{ old('multimedia') == 'Multimedia 2' ? 'selected' : '' }}>Multimedia 2</option>
            </select>
            @error('multimedia')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jadwalPelajaran.create') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection