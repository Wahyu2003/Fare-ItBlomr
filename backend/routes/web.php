<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JadwalBelController;
use App\Http\Controllers\DetailPresensiController;
use App\Http\Controllers\KelasController;

// Dashboard (jika ada)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
// Rute untuk User (Siswa, Guru, dan Admin)
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

// Rute khusus untuk Guru
// Route::get('/users/create_guru', [UserController::class, 'create_guru'])->name('user.create_guru');
// Route::get('/user/{user}/edit-guru', [UserController::class, 'edit'])->name('user.editGuru');


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

// Rute untuk Mata Pelajaran (tanpa AJAX, menggunakan form biasa)
Route::get('/mataPelajaran/add', [MataPelajaranController::class, 'create'])->name('mataPelajaran.add');
Route::post('/mataPelajaran/store-form', [MataPelajaranController::class, 'storeForm'])->name('mataPelajaran.storeForm');

Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas'
]);

// Rute lain yang mungkin ada (dari output route:list sebelumnya)
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/up', function () {
    return response('OK', 200);
});

// Rute untuk storage (untuk mengakses file seperti foto)
Route::get('/storage/{path}', function ($path) {
    return response()->file(storage_path('app/public/' . $path));
})->where('path', '.*')->name('storage.local');

// Jika ada middleware auth, kamu bisa tambahkan di sini
// Route::middleware(['auth'])->group(function () {
//     // Rute yang memerlukan autentikasi
// });
