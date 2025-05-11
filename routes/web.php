<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return redirect('login');
});

// Rute yang hanya bisa diakses sebelum login
Route::middleware(['guest'])->group(function () {
    // Menampilkan form login
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    // Proses login
    Route::post('/login', [AuthController::class, 'login']);
    // Menampilkan form register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    // Proses register
    Route::post('/register', [AuthController::class, 'register']);
});

// Rute yang hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    // Proses logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // halaman dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // route kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
    Route::get('/kelas/json_data', [KelasController::class, 'getData'])->name('kelas.json_data');
    Route::put('/kelas/edit/{siswa_id}', [KelasController::class, 'editData'])->name('kelas.edit');
    Route::delete('/kelas/hapus/{siswa_id}', [KelasController::class, 'deleteData'])->name('kelas.hapus');

    // route siswa
    Route::get('/siswa', [SiswaController::class, 'siswaPage'])->name('siswa');
    Route::get('/siswa/json_data', [SiswaController::class, 'getData'])->name('siswa.json_data');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});

