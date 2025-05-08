<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JadwalBelController;
use App\Http\Controllers\DetailPresensiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\AuthController;

// Rute untuk User (Siswa, Guru, dan Admin)
Route::middleware(['auth'])->group(function(){
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // Rute untuk Detail Presensi
    Route::get('/detailPresensi', [DetailPresensiController::class, 'index'])->name('detailPresensi.index');
    Route::get('/detailPresensi/create', [DetailPresensiController::class, 'create'])->name('detailPresensi.create');
    Route::post('/detailPresensi', [DetailPresensiController::class, 'store'])->name('detailPresensi.store');
    Route::get('/detailPresensi/{detailPresensi}', [DetailPresensiController::class, 'show'])->name('detailPresensi.show');
    Route::get('/detailPresensi/{detailPresensi}/edit', [DetailPresensiController::class, 'edit'])->name('detailPresensi.edit');
    Route::put('/detailPresensi/{detailPresensi}', [DetailPresensiController::class, 'update'])->name('detailPresensi.update');
    Route::post('detailPresensi/kirim',[DetailPresensiController::class,'sendToPython'])->name('detailPresensi.send');
    Route::delete('/detailPresensi/{detailPresensi}', [DetailPresensiController::class, 'destroy'])->name('detailPresensi.destroy');

    // Route untuk Jadwal Bell
    Route::resource('jadwal_bel',JadwalBelController::class);
    Route::put('/jadwal_bel/{jadwalBel}/toggle', [JadwalBelController::class, 'toggle'])->name('jadwal_bel.toggle');

    // Rute untuk Jadwal Pelajaran
    Route::get('/jadwalPelajaran', [JadwalPelajaranController::class, 'index'])->name('jadwalPelajaran.index');
    Route::get('/jadwalPelajaran/create', [JadwalPelajaranController::class, 'create'])->name('jadwalPelajaran.create');
    Route::post('/jadwalPelajaran', [JadwalPelajaranController::class, 'store'])->name('jadwalPelajaran.store');
    Route::get('/jadwalPelajaran/{jadwalPelajaran}', [JadwalPelajaranController::class, 'show'])->name('jadwalPelajaran.show');
    Route::get('/jadwalPelajaran/{jadwalPelajaran}/edit', [JadwalPelajaranController::class, 'edit'])->name('jadwalPelajaran.edit');
    Route::put('/jadwalPelajaran/{jadwalPelajaran}', [JadwalPelajaranController::class, 'update'])->name('jadwalPelajaran.update');
    Route::delete('/jadwalPelajaran/{jadwalPelajaran}', [JadwalPelajaranController::class, 'destroy'])->name('jadwalPelajaran.destroy');

    // Rute untuk Mata Pelajaran
    Route::get('/mataPelajaran/add', [MataPelajaranController::class, 'create'])->name('mataPelajaran.add');
    Route::post('/mataPelajaran/store-form', [MataPelajaranController::class, 'storeForm'])->name('mataPelajaran.storeForm');

    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);
});

Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth'])->get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

    Route::middleware(['auth'])->get('/siswa/dashboard', function () {
        return view('dashboard_siswa');
    })->name('siswa.dashboard');
});
