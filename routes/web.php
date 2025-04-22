<?php

use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\MataPelajaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('jadwalPelajaran', JadwalPelajaranController::class);

Route::get('/mataPelajaran/get', [MataPelajaranController::class, 'getMataPelajaran'])->name('mataPelajaran.get');
Route::post('/mataPelajaran', [MataPelajaranController::class, 'store'])->name('mataPelajaran.store');
Route::delete('/mataPelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('mataPelajaran.destroy');
// Rute baru untuk form biasa
Route::get('/mataPelajaran/add', [MataPelajaranController::class, 'create'])->name('mataPelajaran.add');
Route::post('/mataPelajaran/store-form', [MataPelajaranController::class, 'storeForm'])->name('mataPelajaran.storeForm');
Route::resource('detailPresensi', \App\Http\Controllers\DetailPresensiController::class);
Route::resource('user', \App\Http\Controllers\UserController::class);