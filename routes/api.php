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
Route::get('/logspp/{username}', [App\Http\Controllers\Api\WhatsappController::class, 'cariSpp']);
Route::get('/logkehadiran/{username}', [App\Http\Controllers\Api\WhatsappController::class, 'kehadiran']);
Route::get('/lognilai/{username}', [App\Http\Controllers\Api\WhatsappController::class, 'logNilai']);


Route::get('/kegiatan', [App\Http\Controllers\Api\KegiatanController::class, 'viewKegiatan']);

Route::get('/datasiswa/{id}', [App\Http\Controllers\Api\User::class, 'dataSiswa']);
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/dataguru/{id}', [App\Http\Controllers\Api\User::class, 'dataGuru']);
    Route::get('/userdata', [App\Http\Controllers\Api\User::class, 'userData']);
    Route::get('/logout', [App\Http\Controllers\Api\User::class, 'logout']);
});


