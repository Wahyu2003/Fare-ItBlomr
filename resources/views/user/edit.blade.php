@extends('layouts.admin')

@section('content')
    <h2>Edit Siswa</h2>

    <form action="{{ route('user.update', $user->id_user) }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="nik">NIS</label>
            <input type="text" name="nik" id="nik" value="{{ $user->nik }}" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
        </div>

        <div>
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ $user->nama }}" required>
        </div>

        <div>
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" value="{{ $user->kelas ?? '' }}">
        </div>

        <div>
            <label for="no_hp_siswa">No HP</label>
            <input type="text" name="no_hp_siswa" id="no_hp_siswa" value="{{ $user->no_hp_siswa ?? '' }}" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
        </div>

        <div>
            <label for="nama_ortu">Nama Orang Tua/Wali</label>
            <input type="text" name="nama_ortu" id="nama_ortu" value="{{ $user->nama_ortu }}" required>
        </div>

        <div>
            <label for="no_hp_ortu">No HP Orang Tua/Wali</label>
            <input type="text" name="no_hp_ortu" id="no_hp_ortu" value="{{ $user->no_hp_ortu }}" pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ $user->username }}" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah password">
        </div>

        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>

        <div>
            <label for="foto">Foto</label>
            <div class="file-upload">
                <input type="file" name="foto" id="file-input" accept="image/*">
                <p>Unggah File (Minimal 1 Foto) atau Seret & Lepas Gambar</p>
                <div id="file-preview">
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" class="student-photo" alt="Foto Siswa">
                    @endif
                </div>
            </div>
        </div>

        <button type="submit">Edit Siswa</button>
    </form>
@endsection
