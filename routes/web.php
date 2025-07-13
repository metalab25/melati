<?php

use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanKunjunganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\StafController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WebsiteController::class, 'index'])->name('website');
Route::post('/buku-tamu', [BukuTamuController::class, 'store'])->name('buku-tamu.store');
Route::get('/reaction/{token}', [ReactionController::class, 'show'])->name('reaction.show');
Route::post('/reaction/{token}', [BukuTamuController::class, 'submitReaction'])->name('reaction.submit');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-tamu', [BukuTamuController::class, 'index'])->name('data-tamu.index');
    Route::get('/data-tamu/create', [BukuTamuController::class, 'create'])->name('data-tamu.create');
    Route::delete('/data-tamu/{buku_tamu}', [BukuTamuController::class, 'destroy'])->name('data-tamu.delete');
    Route::post('/data-tamu', [BukuTamuController::class, 'storeAdmin'])->name('data-tamu.storeAdmin');
    Route::post('/data-tamu/update-status/{id}', [BukuTamuController::class, 'updateStatus'])->name('buku-tamu.update-status');
    Route::get('/data-tamu/cetak', [BukuTamuController::class, 'cetak'])->name('buku-tamu.cetak');
    Route::get('/laporan-kunjungan', [LaporanKunjunganController::class, 'index'])->name('laporan.index');
    Route::get('/laporan-kunjungan/cetak', [LaporanKunjunganController::class, 'cetak'])->name('laporan-kunjungan.cetak');
    Route::resource('/staf', StafController::class);
});

require __DIR__ . '/auth.php';
