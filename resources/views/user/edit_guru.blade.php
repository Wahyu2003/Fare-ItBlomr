@extends('layouts.admin')

@section('content')
    <h2>Edit Guru</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user.update', $user->id_user) }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="nik">NIK</label>
            <input type="text" name="nik" id="nik" value="{{ old('nik', $user->nik) }}" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
            @error('nik')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="no_hp_siswa">No HP</label>
            <input type="text" name="no_hp_siswa" id="no_hp_siswa" value="{{ old('no_hp_siswa', $user->no_hp_siswa) }}" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
            @error('no_hp_siswa')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah password">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
            </select>
            @error('role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="foto">Foto</label>
            <div class="file-upload">
                <input type="file" name="foto" id="file-input" accept="image/*">
                <p>Unggah File (Minimal 1 Foto) atau Seret & Lepas Gambar</p>
                <div id="file-preview">
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" class="student-photo" alt="Foto Guru">
                    @endif
                </div>
            </div>
            @error('foto')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Edit Guru</button>
    </form>
@endsection