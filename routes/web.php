<?php

use App\Http\Controllers\DetailPresensiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\JadwalBelController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Pengguna
Route::controller(UserController::class)->group(function() {
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/create', 'create')->name('user.create');
    Route::post('/user', 'store')->name('user.store');
    Route::get('/user/{user}', 'show')->name('user.show');
    Route::get('/user/{user}/edit', 'edit')->name('user.edit');
    Route::put('/user/{user}', 'update')->name('user.update');
    Route::delete('/user/{user}', 'destroy')->name('user.destroy');
});


// Kelas
Route::controller(KelasController::class)->group(function() {
    Route::get('/kelas', 'index')->name('kelas.index');
    Route::get('/kelas/create', 'create')->name('kelas.create');
    Route::post('/kelas', 'store')->name('kelas.store');
    Route::get('/kelas/{kelas}', 'show')->name('kelas.show');
    Route::get('/kelas/{kelas}/edit', 'edit')->name('kelas.edit');
    Route::put('/kelas/{kelas}', 'update')->name('kelas.update');
    Route::delete('/kelas/{kelas}', 'destroy')->name('kelas.destroy');
});

// Detail Presensi
Route::controller(DetailPresensiController::class)->group(function() {
    Route::get('/detailPresensi', 'index')->name('detailPresensi.index');
    Route::get('/detailPresensi/create', 'create')->name('detailPresensi.create');
    Route::post('/detailPresensi', 'store')->name('detailPresensi.store');
    Route::get('/detailPresensi/{detailPresensi}', 'show')->name('detailPresensi.show');
    Route::get('/detailPresensi/{detailPresensi}/edit', 'edit')->name('detailPresensi.edit');
    Route::put('/detailPresensi/{detailPresensi}', 'update')->name('detailPresensi.update');
    Route::delete('/detailPresensi/{detailPresensi}', 'destroy')->name('detailPresensi.destroy');
});

// Presensi
Route::controller(PresensiController::class)->group(function() {
    Route::get('/presensi', 'index')->name('presensi.index');
    Route::get('/presensi/create', 'create')->name('presensi.create');
    Route::post('/presensi', 'store')->name('presensi.store');
    Route::get('/presensi/{presensi}', 'show')->name('presensi.show');
    Route::get('/presensi/{presensi}/edit', 'edit')->name('presensi.edit');
    Route::put('/presensi/{presensi}', 'update')->name('presensi.update');
    Route::delete('/presensi/{presensi}', 'destroy')->name('presensi.destroy');
});

Route::get('/mataPelajaran/get', [MataPelajaranController::class, 'getMataPelajaran'])->name('mataPelajaran.get');
Route::post('/mataPelajaran', [MataPelajaranController::class, 'store'])->name('mataPelajaran.store');
Route::delete('/mataPelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('mataPelajaran.destroy');
// Rute baru untuk form biasa
Route::get('/mataPelajaran/add', [MataPelajaranController::class, 'create'])->name('mataPelajaran.add');
Route::post('/mataPelajaran/store-form', [MataPelajaranController::class, 'storeForm'])->name('mataPelajaran.storeForm');
Route::resource('detailPresensi', \App\Http\Controllers\DetailPresensiController::class);
Route::resource('user', \App\Http\Controllers\UserController::class);

Route::resource('jadwalPelajaran', JadwalPelajaranController::class);
Route::resource('jadwal_bel', JadwalBelController::class);
Route::put('/jadwal-bel/{jadwalBel}/toggle', [JadwalBelController::class, 'toggle'])->name('jadwal_bel.toggle');