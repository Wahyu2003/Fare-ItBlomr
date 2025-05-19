@extends('layouts.admin')

@section('content')
<h1>Edit Mata Pelajaran</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('mataPelajaran.update', $mataPelajaran->id_mata_pelajaran) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nama_mata_pelajaran">Nama Mata Pelajaran</label>
        <input type="text" name="nama_mata_pelajaran" class="form-control" value="{{ old('nama_mata_pelajaran', $mataPelajaran->nama_mata_pelajaran) }}" required>
    </div>

    <div class="form-group">
        <label for="kelas_id">Kelas</label>
        <select name="kelas_id" class="form-control" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id_kelas }}" {{ (old('kelas_id', $mataPelajaran->kelas_id) == $k->id_kelas) ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Update</button>
</form>
@endsection
