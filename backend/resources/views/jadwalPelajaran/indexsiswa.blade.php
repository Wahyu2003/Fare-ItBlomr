@extends('layouts.siswa') <!-- Sesuaikan dengan layout yang digunakan -->

@section('contents')
<div class="container">
    <h1>Jadwal Pelajaran</h1>

    @if($jadwalPelajaran->isEmpty())
        <p>Tidak ada jadwal pelajaran yang ditemukan.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Mata Pelajaran</th>
                    <th>Ruangan</th>
                    <th>Guru</th> <!-- Kolom Guru -->
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalPelajaran as $jp)
                    <tr>
                        <td>{{ $jp->hari }}</td>
                        <td>{{ $jp->jam_mulai }}</td>
                        <td>{{ $jp->jam_selesai }}</td>
                        <td>{{ $jp->mataPelajaran->nama_mata_pelajaran ?? 'Tidak Ada' }}</td>
                        <td>{{ $jp->ruangan ?? 'Tidak Ada' }}</td>
                        <td>{{ $jp->guru->nama ?? 'Tidak Ada' }}</td> <!-- Menampilkan nama guru -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
