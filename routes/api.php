<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController; 
use App\Http\Controllers\AuthController; // <-- TAMBAHKAN BARIS INI!

// ... sisa kode di bawahnya biarkan saja sesuai yang kemarin
// Ini adalah rute login & register bawaan project kamu (biarkan saja)
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login']);

// DI SINI KODE CRUD BARANG YANG SUDAH LENGKAP:
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/items', [ItemController::class, 'index']);      // 1. Tampilkan Semua Barang
    Route::post('/items', [ItemController::class, 'store']);     // 2. Tambah Barang Baru
    Route::get('/items/{id}', [ItemController::class, 'show']);   // 3. Tampilkan Detail Satu Barang
    Route::put('/items/{id}', [ItemController::class, 'update']); // 4. Ubah/Update Data Barang
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->middleware('role:admin');
});