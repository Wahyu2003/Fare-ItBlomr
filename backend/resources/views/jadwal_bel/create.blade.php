@extends('layouts.admin')

@section('content')
    <h2>Tambah Jadwal Belajar</h2>

    <form action="{{ route('jadwal_bel.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="hari">Hari</label>
            <input type="text" name="hari" id="hari" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="time" name="jam" id="jam" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
