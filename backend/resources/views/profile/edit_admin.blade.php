@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 text-primary">
                        <i class="fas fa-user-cog me-2"></i>Edit Profil Admin
                    </h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3 text-secondary">
                                    <i class="fas fa-id-card me-2"></i>Informasi Pribadi
                                </h5>
                                
                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" name="nama" id="nama" 
                                            class="form-control @error('nama') is-invalid @enderror" 
                                            value="{{ old('nama', $user->nama) }}" required>
                                    </div>
                                    @error('nama')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Profile Photo -->
                            <div class="col-md-6">
                                <h5 class="mb-3 text-secondary">
                                    <i class="fas fa-camera me-2"></i>Foto Profil
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        @if($user->foto)
                                            <img src="{{ asset('storage/profile_images/' . $user->foto) }}" 
                                                alt="Foto Profil" class="rounded-circle" 
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                                style="width: 100px; height: 100px;">
                                                <i class="fas fa-user text-secondary" style="font-size: 2.5rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <label for="foto" class="form-label">Unggah Foto Baru</label>
                                        <input type="file" name="foto" id="foto" 
                                            class="form-control @error('foto') is-invalid @enderror">
                                        @error('foto')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3 text-secondary">
                                    <i class="fas fa-lock me-2"></i>Informasi Akun
                                </h5>
                                
                                <div class="row">
                                    <!-- Username -->
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                                            <input type="text" name="username" id="username" 
                                                class="form-control @error('username') is-invalid @enderror" 
                                                value="{{ old('username', $user->username) }}" required>
                                        </div>
                                        @error('username')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Password Baru -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            <input type="password" name="password" id="password" 
                                                class="form-control @error('password') is-invalid @enderror" 
                                                autocomplete="new-password">
                                            <!-- <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button> -->
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Password Baru -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                                class="form-control" autocomplete="new-password">
                                            <!-- <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
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