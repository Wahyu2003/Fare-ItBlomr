@extends('layouts.admin')

@section('content')
    <h2>Edit Jadwal Belajar</h2>

    <form action="{{ route('jadwal_bel.update', $jadwalBel->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="hari">Hari</label>
            <select name="hari" id="hari" class="form-control" required>
                <option value="Senin" {{ $jadwalBel->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ $jadwalBel->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ $jadwalBel->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ $jadwalBel->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ $jadwalBel->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ $jadwalBel->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                <option value="Minggu" {{ $jadwalBel->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
            </select>
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="time" name="jam" id="jam" class="form-control" value="{{ \Carbon\Carbon::parse($jadwalBel->jam)->format('H:i') }}" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $jadwalBel->keterangan }}" required>
        </div>

        <div class="form-group">
            <label for="file_suara">File Suara</label>
            <input type="file" name="file_suara" class="form-control">
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
    </form>
@endsection
