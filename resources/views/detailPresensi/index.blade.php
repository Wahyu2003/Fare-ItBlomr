@extends('layouts.admin')

@section('content')
    <h2>Absensi Siswa</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('detailPresensi.create') }}" class="btn btn-primary">Tambah Absensi</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Waktu</th>
                <th>Bukti Hadir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailPresensi as $presensi)
                <tr>
                    <td>{{ $presensi->user->nik ?? 'Tidak Ada' }}</td>
                    <td>{{ $presensi->user->nama ?? 'Tidak Ada' }}</td>
                    <td>{{ $presensi->presensi->kelas->nama_kelas ?? 'Tidak Ada' }}</td>
                    <td>{{ $presensi->kehadiran }}</td>
                    <td>{{ $presensi->waktu_presensi }}</td>
                    <td>Tidak Ada</td> <!-- Placeholder untuk Bukti Hadir -->
                    <td>
                        <a href="{{ route('detailPresensi.edit', $presensi->id_detail_presensi) }}" class="btn btn-sm btn-warning" style="padding: 5px 16px; margin:10px 0">Edit</a>
                        <form action="{{ route('detailPresensi.destroy', $presensi->id_detail_presensi) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection