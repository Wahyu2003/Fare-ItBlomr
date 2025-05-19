@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Daftar Kelas</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">Tambah Kelas</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Kelas</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas as $kelasItem)
                    <tr>
                        <td>{{ $kelasItem->id_kelas }}</td>
                        <td>{{ $kelasItem->nama_kelas }}</td>
                        <td>
                            <a href="{{ route('kelas.edit', $kelasItem->id_kelas) }}" class="btn btn-sm btn-warning" style="padding: 6px 20px; margin-right : 10px; color:white;">Edit</a>
                            <form action="{{ route('kelas.destroy', $kelasItem->id_kelas) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
