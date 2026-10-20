<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Pangkalan Data Mahasiswa
|--------------------------------------------------------------------------
*/

// Dashboard Utama
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Manajemen Data Mahasiswa (CRUD)
Route::resource('mahasiswa', MahasiswaController::class);

// Direktori Program Studi
Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi.index');

// Analisis & Statistik Pangkalan Data
Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');

// Panduan & Bantuan Sistem
Route::get('/panduan', function () {
    return view('panduan');
})->name('panduan');

// Dokumentasi Endpoint API & Metadata (untuk developer internal / verifikasi teknis)
Route::get('/dokumentasi', function () {
    return view('docs.api');
})->name('docs.api');
