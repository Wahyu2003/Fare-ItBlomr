@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Jadwal Pelajaran</h1>
    <form action="{{ route('jadwalPelajaran.update', $jadwalPelajaran->id_jadwal_pelajaran) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        
        <!-- Form untuk Hari -->
        <div class="mb-3">
            <label for="hari">Hari</label>
            <select name="hari" id="hari" class="form-control">
                <option value="">Pilih Hari</option>
                <option value="Senin" {{ old('hari', $jadwalPelajaran->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ old('hari', $jadwalPelajaran->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ old('hari', $jadwalPelajaran->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ old('hari', $jadwalPelajaran->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ old('hari', $jadwalPelajaran->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ old('hari', $jadwalPelajaran->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                <option value="Minggu" {{ old('hari', $jadwalPelajaran->hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
            </select>
            @error('hari')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Form untuk Jam Mulai -->
        <div class="mb-3">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai', $jadwalPelajaran->jam_mulai) }}">
            @error('jam_mulai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Form untuk Jam Selesai -->
        <div class="mb-3">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai', $jadwalPelajaran->jam_selesai) }}">
            @error('jam_selesai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Form untuk Ruangan -->
        <div class="mb-3">
            <label for="ruangan">Ruangan</label>
            <input type="text" name="ruangan" id="ruangan" class="form-control" value="{{ old('ruangan', $jadwalPelajaran->ruangan) }}">
            @error('ruangan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Form untuk Guru -->
        <div class="mb-3">
            <label for="guru_id">Guru</label>
            <select name="guru_id" id="guru_id" class="form-control">
                <option value="">Pilih Guru</option>
                @foreach($gurus as $guru)
                    <option value="{{ $guru->id_user }}" {{ old('guru_id', $jadwalPelajaran->guru_id) == $guru->id_user ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
            @error('guru_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Form untuk Mata Pelajaran (Memperbarui untuk menggunakan kelas_id) -->
        <div class="mb-3">
            <label for="id_mata_pelajaran">Mata Pelajaran</label>
            <div class="mata-pelajaran-container">
                <select name="id_mata_pelajaran" id="id_mata_pelajaran" class="form-control">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mataPelajaran as $mp)
                        <option value="{{ $mp->id_mata_pelajaran }}" {{ old('id_mata_pelajaran', $jadwalPelajaran->id_mata_pelajaran) == $mp->id_mata_pelajaran ? 'selected' : '' }}>
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
</div>
@endsection
