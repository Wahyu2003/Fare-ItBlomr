@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Kelas</h1>

        <form action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                @error('nama_kelas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
