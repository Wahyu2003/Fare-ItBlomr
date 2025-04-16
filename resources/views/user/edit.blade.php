@extends('layouts.admin')

@section('content')
    <h2>Edit Siswa</h2>

    <form action="{{ route('user.update', $user->id_user) }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="nik">NIK</label>
            <input type="text" name="nik" id="nik" value="{{ $user->nik ?? '' }}" required>
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
            <label for="no_hp">No HP</label>
            <input type="text" name="no_hp" id="no_hp" value="{{ $user->no_hp ?? '' }}">
        </div>

        <div>
            <label for="id_ortu">Nama Ortu/Wali</label>
            <select name="id_ortu" id="id_ortu">
                <option value="">Pilih Ortu/Wali</option>
                @foreach (\App\Models\Ortu::all() as $ortu)
                    <option value="{{ $ortu->id_ortu }}" {{ $user->id_ortu == $ortu->id_ortu ? 'selected' : '' }}>{{ $ortu->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ $user->username }}" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="{{ $user->password }}" required>
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
                <button type="button">Kirim</button>
            </div>
        </div>

        <button type="submit">Edit Siswa</button>
    </form>
@endsection