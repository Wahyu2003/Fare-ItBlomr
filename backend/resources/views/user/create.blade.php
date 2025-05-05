@extends('layouts.admin')

@section('content')
    <h2>Tambah Pengguna</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST" class="admin-form" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="nik">NIK/NIS</label>
            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan">
            @error('nik')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required onchange="toggleFields()">
                <option value="">Pilih Role</option>
                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
            </select>
            @error('role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div id="siswaFields">
            <label for="kelas">Kelas</label>
            {{-- <div class="d-flex"> --}}
                <select name="kelas" id="kelas" required>
                <option value="">Pilih Kelas</option>
                    @foreach($kelas as $kelasItem)
                        <option value="{{ $kelasItem->id_kelas }}" {{ old('kelas_id') == $kelasItem->id_kelas ? 'selected' : '' }}>{{ $kelasItem->nama_kelas }}</option>
                    @endforeach
                </select>
                <a href="{{ route('kelas.index') }}" class="btn btn-success mb-3 ms-2">Tambah Kelas</a>
                @error('kelas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            {{-- </div> --}}
            <div>
                <label for="nama_ortu">Nama Orang Tua/Wali</label>
                <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu') }}">
                @error('nama_ortu')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="no_hp_ortu">No HP Orang Tua/Wali</label>
                <input type="text" name="no_hp_ortu" id="no_hp_ortu" value="{{ old('no_hp_ortu') }}" pattern="[0-9]+" title="Hanya angka yang diperbolehkan" maxlength="13">
                @error('no_hp_ortu')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div>
            <label for="no_hp_siswa">No HP</label>
            <input type="text" name="no_hp_siswa" id="no_hp_siswa" value="{{ old('no_hp_siswa') }}" required pattern="[0-9]+" title="Hanya angka yang diperbolehkan" maxlength="13">
            @error('no_hp_siswa')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required style="text-transform: lowercase;" minlength="8">
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="foto">Foto</label>
            <div class="file-upload">
                <input type="file" name="foto" id="file-input" accept="image/*">
                <p>Unggah File (Minimal 1 Foto) atau Seret & Lepas Gambar</p>
                <div id="file-preview"></div>
            </div>
            @error('foto')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Tambah Pengguna</button>
    </form>

    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const siswaFields = document.getElementById('siswaFields');
            const kelas = document.getElementById('kelas');
            const namaOrtu = document.getElementById('nama_ortu');
            const noHpOrtu = document.getElementById('no_hp_ortu');

            if (role === 'guru') {
                siswaFields.style.display = 'none';
                kelas.removeAttribute('required');
                namaOrtu.removeAttribute('required');
                noHpOrtu.removeAttribute('required');
            } else {
                siswaFields.style.display = 'block';
                kelas.setAttribute('required', 'required');
                namaOrtu.setAttribute('required', 'required');
            }
        }

        // Panggil toggleFields saat halaman dimuat untuk menangani nilai default
        window.onload = toggleFields;
    </script>
@endsection
