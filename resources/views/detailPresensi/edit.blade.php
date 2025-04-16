@extends('layouts.admin')

@section('content')
    <h2>Edit Absensi</h2>

    <form action="{{ route('detailPresensi.update', $detailPresensi->id_detail_presensi) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        <div>
            <label for="id_user">Siswa</label>
            <select name="id_user" id="id_user" required>
                <option value="">Pilih Siswa</option>
                @foreach (\App\Models\User::where('role', 'siswa')->get() as $user)
                    <option value="{{ $user->id_user }}" {{ $detailPresensi->id_user == $user->id_user ? 'selected' : '' }}>{{ $user->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_presensi">Jadwal</label>
            <select name="id_presensi" id="id_presensi" required>
                <option value="">Pilih Jadwal</option>
                @foreach (\App\Models\Presensi::all() as $jadwal)
                    <option value="{{ $jadwal->id_presensi }}" {{ $detailPresensi->id_presensi == $jadwal->id_presensi ? 'selected' : '' }}>{{ $jadwal->hari }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="waktu_absen">Waktu Absen</label>
            <input type="datetime-local" name="waktu_absen" id="waktu_absen" value="{{ $detailPresensi->waktu_presensi }}" required>
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="tepat waktu" {{ $detailPresensi->kehadiran == 'tepat waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                <option value="telat" {{ $detailPresensi->kehadiran == 'telat' ? 'selected' : '' }}>Telat</option>
                <option value="alpha" {{ $detailPresensi->kehadiran == 'alpha' ? 'selected' : '' }}>Alpha</option>
                <option value="izin" {{ $detailPresensi->kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ $detailPresensi->kehadiran == 'sakit' ? 'selected' : '' }}>Sakit</option>
            </select>
        </div>

        <div>
            <label for="jenis_absen">Jenis Absen</label>
            <select name="jenis_absen" id="jenis_absen" required>
                <option value="belum keluar" {{ $detailPresensi->jenis_absen == 'belum keluar' ? 'selected' : '' }}>Belum Keluar</option>
                <option value="pulang" {{ $detailPresensi->jenis_absen == 'pulang' ? 'selected' : '' }}>Pulang</option>
                <option value="tidak hadir" {{ $detailPresensi->jenis_absen == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
            </select>
        </div>

        <button type="submit">Edit Absensi</button>
    </form>
@endsection