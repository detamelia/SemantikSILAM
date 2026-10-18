<?php

use App\Http\Controllers\Api\MahasiswaApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Sistem A: Integrasi Sistem B & Semantic Web
|--------------------------------------------------------------------------
|
| Endpoint berikut disediakan untuk Sistem B memverifikasi mahasiswa
| berdasarkan NPM dan mengakses metadata semantik.
|
*/

// Endpoint Status API Sistem A
Route::get('/status', [MahasiswaApiController::class, 'status']);

// Endpoint Verifikasi Mahasiswa berdasarkan NPM untuk Sistem B
Route::get('/mahasiswa/{npm}', [MahasiswaApiController::class, 'getByNpm']);

// Endpoint Representasi RDF Turtle untuk Semantic Web
Route::get('/mahasiswa/{npm}/rdf', [MahasiswaApiController::class, 'getRdfTurtle']);
