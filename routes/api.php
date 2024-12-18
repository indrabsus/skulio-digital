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


Route::get('/sumatif/{id_kelas}', [App\Http\Controllers\Api\ExamController::class, 'sumatif']);
Route::get('/sumatif/cekujian/{id_sumatif}/{id_user}', [App\Http\Controllers\Api\ExamController::class, 'cekUjian']);
Route::get('/sumatif/test/{id_sumatif}', [App\Http\Controllers\Api\ExamController::class, 'testSumatif']);
Route::get('/sumatif/tampungsoal/{id_soalujian}', [App\Http\Controllers\Api\ExamController::class, 'tampungSoal']);
Route::get('/sumatif/opsisoal/{id_soal}', [App\Http\Controllers\Api\ExamController::class, 'opsiSoal']);
Route::post('/sumatif/jawabsoal', [App\Http\Controllers\Api\ExamController::class, 'jawabSoal']);
Route::get('/sumatif/jawabsoal/{id_sumatif}/{id_user_siswa}', [App\Http\Controllers\Api\ExamController::class, 'getJawaban']);
Route::get('/datasiswa/{id}', [App\Http\Controllers\Api\User::class, 'dataSiswa']);
Route::get('/sumatif/selesaitest/{id_sumatif}/{id_user_siswa}', [App\Http\Controllers\Api\ExamController::class, 'selesaiTest']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/dataguru', [App\Http\Controllers\Api\User::class, 'allGuru']);
    Route::get('/dataguru/{id}', [App\Http\Controllers\Api\User::class, 'dataGuru']);
    Route::get('/datasiswa', [App\Http\Controllers\Api\User::class, 'allSiswa']);
    Route::get('/userdata', [App\Http\Controllers\Api\User::class, 'userData']);
    Route::get('/logout', [App\Http\Controllers\Api\User::class, 'logout']);
});


