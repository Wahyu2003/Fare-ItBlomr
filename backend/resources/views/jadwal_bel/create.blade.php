@extends('layouts.admin')

@section('content')
    <h2>Tambah Jadwal Bel</h2>

    <form action="{{ route('jadwal_bel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="is_manual">Jenis Jadwal</label>
            <select name="is_manual" id="is_manual" class="form-control" onchange="toggleInputs()">
                <option value="0">Otomatis (berdasarkan hari)</option>
                <option value="1">Manual (berdasarkan tanggal)</option>
            </select>
        </div>

        <div class="form-group" id="hari_input">
            <label for="hari">Hari</label>
            <select name="hari" class="form-control">
                <option value="">-- Pilih Hari --</option>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                    <option value="{{ $h }}">{{ $h }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="tanggal_input" style="display:none;">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control">
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="time" name="jam" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="file_suara">File Suara</label>
            <input type="text" name="file_suara" class="form-control" placeholder="Masukkan nama file suara" required>
        </div>

        <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="aktif" value="1" checked>
            <label class="form-check-label">Aktif</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>

    <script>
        function toggleInputs() {
            const manual = document.getElementById('is_manual').value == '1';
            document.getElementById('hari_input').style.display = manual ? 'none' : 'block';
            document.getElementById('tanggal_input').style.display = manual ? 'block' : 'none';
        }
    </script>
@endsection