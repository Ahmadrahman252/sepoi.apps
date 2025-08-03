<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UmkmController;

Route::get('/kategori', [UmkmController::class, 'kategori'])->name('users.kategori');
Route::get('/', [UserController::class, 'index'])->name('users.index');


Route::get('/umkm/{id}/detail', [UmkmController::class, 'detail'])->name('umkm.detail');

Route::get('/umkm/import', [UmkmController::class, 'showForm']);
Route::post('/umkm/import', [UmkmController::class, 'importExcel']);
Route::get('/api/umkm', [UmkmController::class, 'getUmkmData']);
