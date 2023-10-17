<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Middleware\MasyarakatMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin/Petugas
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('pengaduans', PengaduanController::class);

        Route::resource('tanggapan', TanggapanController::class);

        Route::get('masyarakat', [AdminController::class, 'masyarakat']);
        Route::resource('petugas', 'PetugasController');

        Route::get('laporan', [AdminController::class, 'laporan']);
        Route::get('laporan/cetak', [AdminController::class, 'cetak']);
        Route::get('pengaduan/cetak/{id}', [AdminController::class, 'pdf']);
    });

// // Masyarakat
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', MasyarakatMiddleware::class])
    ->group(function () {
        Route::get('/', [MasyarakatController::class, 'index'])->name('masyarakat-dashboard');
        Route::resource('pengaduan', MasyarakatController::class);
        Route::get('pengaduan', [MasyarakatController::class, 'lihat']);
        Route::put('updatepengaduan/{id}', [MasyarakatController::class, 'update']);
    });

require __DIR__.'/auth.php';
