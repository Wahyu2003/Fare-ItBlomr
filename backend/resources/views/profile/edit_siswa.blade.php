@extends('layouts.siswa')

@section('contents')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 text-primary">
                        <i class="fas fa-user-cog me-2"></i>Edit Profil Siswa
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="text-secondary mb-3 fw-semibold">
                                        <i class="fas fa-user-graduate me-2"></i>Informasi Pribadi
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                            <input type="text" name="nama" id="nama" 
                                                class="form-control @error('nama') is-invalid @enderror" 
                                                value="{{ old('nama', $user->nama) }}" required>
                                        </div>
                                        @error('nama')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_hp_siswa" class="form-label">Nomor HP Siswa</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-mobile-alt text-muted"></i></span>
                                            <input type="tel" name="no_hp_siswa" id="no_hp_siswa" 
                                                class="form-control @error('no_hp_siswa') is-invalid @enderror" 
                                                value="{{ old('no_hp_siswa', $user->no_hp_siswa) }}"
                                                placeholder="0812-3456-7890">
                                        </div>
                                        @error('no_hp_siswa')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Parent Information -->
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="text-secondary mb-3 fw-semibold">
                                        <i class="fas fa-users me-2"></i>Informasi Orang Tua
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <label for="nama_ortu" class="form-label">Nama Orang Tua</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-user-friends text-muted"></i></span>
                                            <input type="text" name="nama_ortu" id="nama_ortu" 
                                                class="form-control @error('nama_ortu') is-invalid @enderror" 
                                                value="{{ old('nama_ortu', $user->nama_ortu) }}"
                                                placeholder="Nama lengkap orang tua">
                                        </div>
                                        @error('nama_ortu')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_hp_ortu" class="form-label">Nomor HP Orang Tua</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                                            <input type="tel" name="no_hp_ortu" id="no_hp_ortu" 
                                                class="form-control @error('no_hp_ortu') is-invalid @enderror" 
                                                value="{{ old('no_hp_ortu', $user->no_hp_ortu) }}"
                                                placeholder="0812-3456-7890">
                                        </div>
                                        @error('no_hp_ortu')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Photo -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <h5 class="text-secondary mb-3 fw-semibold">
                                        <i class="fas fa-id-card me-2"></i>Foto Profil
                                    </h5>
                                    
                                    <div class="d-flex flex-column flex-md-row align-items-center">
                                        <div class="mb-3 mb-md-0 me-md-4 text-center">
                                            @if($user->foto)
                                                <img src="{{ asset('storage/' . $user->foto) }}" 
                                                    alt="Foto Profil" 
                                                    style="width: 120px; height: 120px; object-fit: cover; border-radius : 10px;">
                                            @else
                                                <div class="rounded-circle border bg-light d-flex align-items-center justify-content-center mx-auto" 
                                                    style="width: 120px; height: 120px;">
                                                    <i class="fas fa-user text-secondary" style="font-size: 3rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-grow-1 w-100">
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Unggah Foto Baru</label>
                                                <input type="file" name="foto" id="foto" 
                                                    class="form-control @error('foto') is-invalid @enderror"
                                                    accept="image/jpeg, image/png">
                                                @error('foto')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            
                                            <div class="alert alert-light p-2 mb-0">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Format: JPG/PNG (Maks. 2MB). Ukuran ideal 300x300 piksel.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <h5 class="text-secondary mb-3 fw-semibold">
                                        <i class="fas fa-lock me-2"></i>Informasi Akun
                                    </h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="fas fa-at text-muted"></i></span>
                                                    <input type="text" name="username" id="username" 
                                                        class="form-control @error('username') is-invalid @enderror" 
                                                        value="{{ old('username', $user->username) }}" required>
                                                </div>
                                                @error('username')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password Baru</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                                                    <input type="password" name="password" id="password" 
                                                        class="form-control @error('password') is-invalid @enderror" 
                                                        autocomplete="new-password"
                                                        placeholder="Kosongkan jika tidak ingin mengubah">
                                                    <!-- <button class="btn btn-light toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button> -->
                                                </div>
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                                        class="form-control" 
                                                        autocomplete="new-password"
                                                        placeholder="Konfirmasi password baru">
                                                    <!-- <button class="btn btn-light toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Toggle password visibility - Versi yang diperbaiki
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                // Cari input password terkait
                const inputGroup = this.closest('.input-group');
                const input = inputGroup.querySelector('input[type="password"], input[type="text"]');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    });
</script>
@endsection
@endsection