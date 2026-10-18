<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem A: Sistem Informasi Data Mahasiswa
|--------------------------------------------------------------------------
*/

// Dashboard Utama
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// CRUD Data Mahasiswa
Route::resource('mahasiswa', MahasiswaController::class);

// Halaman Dokumentasi API & Semantik Web
Route::get('/dokumentasi', function () {
    return view('docs.api');
})->name('docs.api');
