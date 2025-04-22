@extends('layouts.admin')

@section('content')
    <h2>Edit Jadwal Belajar</h2>

    <form action="{{ route('jadwal_bel.update', $jadwalBel->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="hari">Hari</label>
            <input type="text" name="hari" id="hari" class="form-control" value="{{ $jadwalBel->hari }}" required>
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="time" name="jam" id="jam" class="form-control" value="{{ \Carbon\Carbon::parse($jadwalBel->jam)->format('H:i') }}" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $jadwalBel->keterangan }}" required>
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
    </form>
@endsection
