@extends('layouts.admin')

@section('content')
    <h2>Tambah Siswa</h2>

    <form action="{{ route('user.store') }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="nik">NIS</label>
            <input type="text" name="nik" id="nik" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
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
            <label for="no_hp_siswa">No HP</label>
            <input type="text" name="no_hp_siswa" id="no_hp_siswa" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
        </div>

        <!-- Input untuk Nama Orang Tua/Wali -->
        <div>
            <label for="nama_ortu">Nama Orang Tua/Wali</label>
            <input type="text" name="nama_ortu" id="nama_ortu" required>
        </div>
        <div>
            <label for="no_hp_ortu">No HP Orang Tua/Wali</label>
            <input type="text" name="no_hp_ortu" id="no_hp_ortu" pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
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
                <!-- Admin bisa juga ditambahkan jika ingin memberi akses ke role admin -->
                <!--<option value="admin">Admin</option>-->
            </select>
        </div>

        <div>
            <label for="foto">Foto</label>
            <div class="file-upload">
                <input type="file" name="foto" id="file-input" accept="image/*">
                <p>Unggah File (Minimal 1 Foto) atau Seret & Lepas Gambar</p>
                <div id="file-preview"></div>
            </div>
        </div>

        <button type="submit">Tambah Siswa</button>
    </form>
@endsection
