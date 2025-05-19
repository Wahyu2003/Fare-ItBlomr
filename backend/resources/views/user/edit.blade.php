@extends('layouts.admin')

@section('content')
    <h2>Edit Pengguna</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user.update', $user->id_user) }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="nik">NIK/NIS</label>
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
            <label for="kelas_id">Kelas</label>
            <select name="kelas_id" id="kelas_id" required>
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $kelasItem)
                    <option value="{{ $kelasItem->id_kelas }}" {{ old('kelas_id', $user->kelas_id) == $kelasItem->id_kelas ? 'selected' : '' }}>
                        {{ $kelasItem->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('kelas_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <a href="{{ route('kelas.index') }}" class="btn btn-success mb-3 ms-2">Tambah Kelas</a>
        </div>

        <div>
            <label for="nama_ortu">Nama Orang Tua/Wali</label>
            <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu', $user->nama_ortu) }}">
            @error('nama_ortu')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="no_hp_ortu">No HP Orang Tua/Wali</label>
            <input type="text" name="no_hp_ortu" id="no_hp_ortu" value="{{ old('no_hp_ortu', $user->no_hp_ortu) }}" pattern="[0-9]+" title="Hanya angka yang diperbolehkan" maxlength="13">
            @error('no_hp_ortu')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="no_hp_siswa">No HP</label>
            <input type="text" name="no_hp_siswa" id="no_hp_siswa" value="{{ old('no_hp_siswa', $user->no_hp_siswa) }}" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan" maxlength="13">
            @error('no_hp_siswa')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required style="text-transform: lowercase;" minlength="8">
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
            <select name="role" id="role" required onchange="toggleFields()">
                <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
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
                        <img src="{{ asset('storage/' . $user->foto) }}" class="student-photo" alt="Foto Pengguna">
                    @endif
                </div>
            </div>
            @error('foto')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Update Pengguna</button>
    </form>

    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const siswaFields = document.querySelectorAll('#kelas_id, #nama_ortu, #no_hp_ortu');
            
            if (role === 'guru') {
                siswaFields.forEach(field => {
                    field.closest('div').style.display = 'none';
                    field.removeAttribute('required');
                });
            } else {
                siswaFields.forEach(field => {
                    field.closest('div').style.display = 'block';
                    if(field.id === 'kelas_id' || field.id === 'nama_ortu') {
                        field.setAttribute('required', 'required');
                    }
                });
            }
        }

        window.onload = toggleFields;
    </script>
@endsection