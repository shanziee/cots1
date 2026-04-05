<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/', [MahasiswaController::class, 'index']);

Route::get('/data', [MahasiswaController::class, 'getData']);
Route::post('/store', [MahasiswaController::class, 'store']);
Route::get('/edit/{id}', [MahasiswaController::class, 'edit']);
Route::put('/update/{id}', [MahasiswaController::class, 'update']);
Route::delete('/delete/{id}', [MahasiswaController::class, 'destroy']);
