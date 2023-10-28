<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Kurikulum\Angkatan;
use App\Livewire\Kurikulum\Jurusan;
use App\Livewire\Kurikulum\Kelas;

use App\Livewire\Kurikulum\mapel;
use App\Livewire\Sarpras\Ruangan;
use Illuminate\Support\Facades\Route;


//Login Page
Route::get('/',[AuthController::class,'loginpage'])->name('loginpage');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
//Proses Login
Route::post('loginauth',[AuthController::class,'login'])->name('loginauth');


Route::group(['middleware' => ['auth']], function(){
    // Admin Dashboard
    Route::group(['middleware' => ['cekrole:admin']], function(){
        Route::get('admin/dashboard',Dashboard::class)->name('admin.dashboard');
        Route::get('admin/jurusan',Jurusan::class)->name('admin.jurusan');
        Route::get('admin/angkatan',Angkatan::class)->name('admin.angkatan');
        Route::get('admin/kelas',Kelas::class)->name('admin.kelas');
        Route::get('admin/mapel',mapel::class)->name('admin.mapel');
        Route::get('admin/ruangan',Ruangan::class)->name('admin.ruangan');
    });
});
