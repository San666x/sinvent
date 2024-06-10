<?php

use App\Http\Controllers\Api\BarangApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('/barang/posts','Api\BarangApi@index');
Route::apiResource('barang', App\Http\Controllers\Api\BarangApi::class);