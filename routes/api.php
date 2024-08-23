<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [App\Http\Controllers\Api\User::class, 'login']);
Route::post('/daftarppdb', [App\Http\Controllers\Api\User::class, 'daftarPpdb']);


Route::get('/kegiatan', [App\Http\Controllers\Api\KegiatanController::class, 'viewKegiatan']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/userdata', [App\Http\Controllers\Api\User::class, 'userData']);
    Route::get('/logout', [App\Http\Controllers\Api\User::class, 'logout']);
});


