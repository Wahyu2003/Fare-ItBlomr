@extends('layouts.admin')

@section('content')
    <h2>Tambah Jadwal Pelajaran</h2>

    <form action="{{ route('presensi.store') }}" method="POST" class="admin-form">
        @csrf
        <div>
            <label for="id_kelas">Kelas</label>
            <select name="id_kelas" id="id_kelas" required>
                <option value="">Pilih Kelas</option>
                @foreach (\App\Models\Kelas::all() as $kelas)
                    <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="hari">Hari</label>
            <input type="date" name="hari" id="hari" required>
        </div>

        <div>
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" required>
        </div>

        <div>
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" required>
        </div>

        <button type="submit">Tambah Jadwal</button>
    </form>
@endsection