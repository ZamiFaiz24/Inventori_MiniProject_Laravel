<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BarangController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/barang', [BarangController::class, 'index']);
Route::post('/barang', [BarangController::class, 'store']);
Route::get('/barang/{id}', [BarangController::class, 'show']);
Route::put('/barang/{id}', [BarangController::class, 'update']);
Route::delete('/barang/{id}', [BarangController::class, 'destroy']);