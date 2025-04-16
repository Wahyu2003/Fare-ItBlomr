@extends('layouts.admin')

@section('content')
    <h2>Edit Jadwal Pelajaran</h2>

    <form action="{{ route('presensi.update', $presensi->id_presensi) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        <div>
            <label for="id_kelas">Kelas</label>
            <select name="id_kelas" id="id_kelas" required>
                <option value="">Pilih Kelas</option>
                @foreach (\App\Models\Kelas::all() as $kelas)
                    <option value="{{ $kelas->id_kelas }}" {{ $presensi->id_kelas == $kelas->id_kelas ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="hari">Hari</label>
            <input type="date" name="hari" id="hari" value="{{ $presensi->hari }}" required>
        </div>

        <div>
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ $presensi->jam_mulai }}" required>
        </div>

        <div>
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" value="{{ $presensi->jam_selesai }}" required>
        </div>

        <button type="submit">Edit Jadwal</button>
    </form>
@endsection