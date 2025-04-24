@extends('layouts.admin')

@section('content')
    <h2>Tambah Jadwal Belajar</h2>

    <form action="{{ route('jadwal_bel.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="hari">Hari</label>
            <select name="hari" id="hari" class="form-control" required>
                <option value="">-- Pilih Hari --</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
                <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="time" name="jam" id="jam" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="file_suara">File Suara</label>
            <input type="file" name="file_suara" class="form-control">
        </div>

        <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="aktif" value="1" {{ old('aktif', $jadwalBel->aktif ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Aktif</label>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
