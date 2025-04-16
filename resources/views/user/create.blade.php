@extends('layouts.admin')

@section('content')
    <h2>Tambah Siswa</h2>

    <form action="{{ route('user.store') }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="nik">NIK</label>
            <input type="text" name="nik" id="nik" required>
        </div>

        <div>
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" required>
        </div>

        <div>
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas">
        </div>

        <div>
            <label for="no_hp">No HP</label>
            <input type="text" name="no_hp" id="no_hp">
        </div>

        <div>
            <label for="id_ortu">Nama Ortu/Wali</label>
            <select name="id_ortu" id="id_ortu">
                <option value="">Pilih Ortu/Wali</option>
                @foreach (\App\Models\Ortu::all() as $ortu)
                    <option value="{{ $ortu->id_ortu }}">{{ $ortu->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="siswa">Siswa</option>
            </select>
        </div>

        <div>
            <label for="foto">Foto</label>
            <div class="file-upload">
                <input type="file" name="foto" id="file-input" accept="image/*">
                <p>Unggah File (Minimal 1 Foto) atau Seret & Lepas Gambar</p>
                <div id="file-preview"></div>
                <button type="button">Kirim</button>
            </div>
        </div>

        <button type="submit">Tambah Siswa</button>
    </form>
@endsection