@extends('layouts.admin')

@section('content')
    <h2>Edit Jadwal Bel</h2>

    <form action="{{ route('jadwal_bel.update', $jadwalBel->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="is_manual">Jenis Jadwal</label>
            <select name="is_manual" id="is_manual" class="form-control" onchange="toggleInputs()">
                <option value="0" {{ !$jadwalBel->is_manual ? 'selected' : '' }}>Otomatis</option>
                <option value="1" {{ $jadwalBel->is_manual ? 'selected' : '' }}>Manual</option>
            </select>
        </div>

        <div class="form-group" id="hari_input">
            <label for="hari">Hari</label>
            <select name="hari" class="form-control">
                <option value="">-- Pilih Hari --</option>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                    <option value="{{ $h }}" {{ $jadwalBel->hari == $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="tanggal_input" style="display:none;">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $jadwalBel->tanggal }}">
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="time" name="jam" class="form-control" value="{{ \Carbon\Carbon::parse($jadwalBel->jam)->format('H:i') }}" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ $jadwalBel->keterangan }}" required>
        </div>

        <div class="form-group">
            <label for="file_suara">File Suara</label>
            <input type="file" name="file_suara" class="form-control">
        </div>

        <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="aktif" value="1" {{ $jadwalBel->aktif ? 'checked' : '' }}>
            <label class="form-check-label">Aktif</label>
        </div>

        <button type="submit" class="btn btn-warning mt-3">Update</button>
    </form>

    <script>
        function toggleInputs() {
            const manual = document.getElementById('is_manual').value == '1';
            document.getElementById('hari_input').style.display = manual ? 'none' : 'block';
            document.getElementById('tanggal_input').style.display = manual ? 'block' : 'none';
        }

        window.onload = toggleInputs;
    </script>
@endsection