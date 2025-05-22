<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JadwalBelController;
use App\Http\Controllers\DetailPresensiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', RoleMiddleware::class . ':siswa'])->group(function () {
    Route::get('/rekapan-absen-siswa', [DetailPresensiController::class, 'rekapanAbsenSiswa'])->name('rekapanAbsenSiswa.index');
    // routes/web.php
    Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'indexsiswa'])->name('siswa.jadwal');
});
// Rute untuk User (Siswa, Guru, dan Admin)
Route::middleware(['auth', RoleMiddleware::class . ':admin,guru'])->group(function () {
    // Rute untuk User (Siswa, Guru, dan Admin)
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
    Route::post('/detailPresensi/update-multiple-status', [DetailPresensiController::class, 'updateMultipleStatus'])->name('detailPresensi.updateMultipleStatus');
    Route::post('detailPresensi/kirim', [DetailPresensiController::class, 'sendToPython'])->name('detailPresensi.send');
    Route::delete('/detailPresensi/{detailPresensi}', [DetailPresensiController::class, 'destroy'])->name('detailPresensi.destroy');

    // Route untuk Jadwal Bell
    Route::resource('jadwal_bel', JadwalBelController::class);
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
    Route::resource('mataPelajaran', MataPelajaranController::class);

    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);
});
Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('login');
    });

    // Rute untuk dashboard admin dan siswa, menggunakan middleware auth
    Route::middleware(['auth', RoleMiddleware::class . ':admin,guru'])->group(function () {
        Route::get('/get-firebase-data', [DashboardAdminController::class, 'getFirebaseData']);
        Route::get('/update-dashboard-admin', [DashboardAdminController::class, 'updateDashboardAdmin']);
    });
    Route::middleware(['auth', RoleMiddleware::class . ':admin'])->get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::middleware(['auth', RoleMiddleware::class . ':guru'])->get('/dashboard_guru', [DashboardAdminController::class, 'index'])->name('guru.dashboard');
    Route::middleware(['auth', RoleMiddleware::class . ':siswa'])->get('/dashboard_siswa', [DetailPresensiController::class, 'rekapanAbsenSiswa'])->name('siswa.dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
