@extends('layouts.admin')

@section('content')
    <h2>Tambah Absensi</h2>

    <form action="{{ route('detailPresensi.store') }}" method="POST" class="admin-form">
        @csrf
        <div>
            <label for="id_user">Siswa</label>
            <select name="id_user" id="id_user" required>
                <option value="">Pilih Siswa</option>
                @foreach (\App\Models\User::where('role', 'siswa')->get() as $user)
                    <option value="{{ $user->id_user }}">{{ $user->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_presensi">Jadwal</label>
            <select name="id_presensi" id="id_presensi" required>
                <option value="">Pilih Jadwal</option>
                @foreach (\App\Models\Presensi::all() as $jadwal)
                    <option value="{{ $jadwal->id_presensi }}">{{ $jadwal->hari }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="waktu_absen">Waktu Absen</label>
            <input type="datetime-local" name="waktu_absen" id="waktu_absen" required>
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="tepat waktu">Tepat Waktu</option>
                <option value="telat">Telat</option>
                <option value="alpha">Alpha</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
            </select>
        </div>

        <div>
            <label for="jenis_absen">Jenis Absen</label>
            <select name="jenis_absen" id="jenis_absen" required>
                <option value="belum keluar">Belum Keluar</option>
                <option value="pulang">Pulang</option>
                <option value="tidak hadir">Tidak Hadir</option>
            </select>
        </div>

        <button type="submit">Tambah Absensi</button>
    </form>
@endsection