@extends('layouts.admin')

@section('content')
    <h2>Edit Siswa</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user.update', $user->id_user) }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="nik">NIS</label>
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
            <label for="kelas">Kelas</label>
            @php
                $kelasParts = explode(' - ', $user->kelas ?? '');
                $kelasValue = $kelasParts[0] ?? '';
                $multimediaValue = $kelasParts[1] ?? '';
            @endphp
            <select name="kelas" id="kelas" required>
                <option value="">Pilih Kelas</option>
                <option value="10" {{ old('kelas', $kelasValue) == '10' ? 'selected' : '' }}>10</option>
                <option value="11" {{ old('kelas', $kelasValue) == '11' ? 'selected' : '' }}>11</option>
                <option value="12" {{ old('kelas', $kelasValue) == '12' ? 'selected' : '' }}>12</option>
            </select>
            @error('kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="multimedia">Multimedia</label>
            <select name="multimedia" id="multimedia" required>
                <option value="">Pilih Multimedia</option>
                <option value="Multimedia 1" {{ old('multimedia', $multimediaValue) == 'Multimedia 1' ? 'selected' : '' }}>Multimedia 1</option>
                <option value="Multimedia 2" {{ old('multimedia', $multimediaValue) == 'Multimedia 2' ? 'selected' : '' }}>Multimedia 2</option>
            </select>
            @error('multimedia')
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
            <label for="nama_ortu">Nama Orang Tua/Wali</label>
            <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu', $user->nama_ortu) }}" required>
            @error('nama_ortu')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="no_hp_ortu">No HP Orang Tua/Wali</label>
            <input type="text" name="no_hp_ortu" id="no_hp_ortu" value="{{ old('no_hp_ortu', $user->no_hp_ortu) }}" pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
            @error('no_hp_ortu')
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
                <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
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
                        <img src="{{ asset('storage/' . $user->foto) }}" class="student-photo" alt="Foto Siswa">
                    @endif
                </div>
            </div>
            @error('foto')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Edit Siswa</button>
    </form>
@endsection