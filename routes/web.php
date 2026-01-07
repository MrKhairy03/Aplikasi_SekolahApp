<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return session()->has('user_id')
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/tambah', [KelasController::class, 'create'])->name('kelas.tambah');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/edit/{kelas}', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah', [SiswaController::class, 'create'])->name('siswa.tambah');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/edit/{siswa}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/batal', [SiswaController::class, 'cancelDraft'])->name('siswa.cancel');

    Route::get('/guru', [guruController::class, 'index'])->name('guru.index');
    Route::get('/guru/tambah', [guruController::class, 'create'])->name('guru.tambah');
    Route::post('/guru', [guruController::class, 'store'])->name('guru.store');
    Route::get('/guru/edit/{guru}', [guruController::class, 'edit'])->name('guru.edit');
    Route::put('/guru/{guru}', [guruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{guru}', [guruController::class, 'destroy'])->name('guru.destroy');
    Route::post('/guru/batal', [guruController::class, 'cancelDraft'])->name('guru.cancel');

    Route::get('/laporan/siswa-per-kelas', [LaporanController::class, 'siswaPerKelas'])->name('laporan.siswa');
    Route::get('/laporan/guru-per-kelas', [LaporanController::class, 'guruPerKelas'])->name('laporan.guru');
    Route::get('/laporan/kelas', [LaporanController::class, 'kelasPerSiswaGuru'])->name('laporan.kelas');
});


require __DIR__ . '/auth.php';
