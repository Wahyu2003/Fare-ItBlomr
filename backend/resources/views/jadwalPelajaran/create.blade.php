@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Jadwal Pelajaran</h1>
    <form action="{{ route('jadwalPelajaran.store') }}" method="POST" class="admin-form">
        @csrf
        <div class="mb-3">
            <label for="hari">Hari</label>
            <select name="hari" id="hari" class="form-control">
                <option value="">Pilih Hari</option>
                <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
            </select>
            @error('hari')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}">
            @error('jam_mulai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}">
            @error('jam_selesai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="ruangan">Ruangan</label>
            <input type="text" name="ruangan" id="ruangan" class="form-control" value="{{ old('ruangan') }}">
            @error('ruangan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="guru_id">Guru</label>
            <select name="guru_id" id="guru_id" class="form-control">
                <option value="">Pilih Guru</option>
                @foreach($gurus as $guru)
                    <option value="{{ $guru->id_user }}" {{ old('guru_id') == $guru->id_user ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
            @error('guru_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="id_mata_pelajaran">Mata Pelajaran</label>
            <div class="mata-pelajaran-container">
                <select name="id_mata_pelajaran" id="id_mata_pelajaran" class="form-control">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mataPelajaran as $mp)
                        <option value="{{ $mp->id_mata_pelajaran }}">
                            {{ $mp->nama_mata_pelajaran }} (Kelas {{ $mp->kelas->nama_kelas ?? 'Tidak Ada' }})
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('mataPelajaran.index') }}" class="btn btn-sm btn-primary mt-2">Tambah Mata Pelajaran</a>
            </div>
            @error('id_mata_pelajaran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
