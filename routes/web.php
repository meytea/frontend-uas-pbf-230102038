<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('Dashboard.index');

Route::resource('Buku', BukuController::class);
Route::get('/Buku/{id}/edit', [BukuController::class, 'edit'])->name('Buku.edit');

// Route::resource('Peminjaman', PeminjamanController::class);
// Route::get('/Peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('Peminjaman.edit');

