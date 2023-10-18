<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;


//Login Page
Route::get('/',[AuthController::class,'loginpage'])->name('loginpage');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
//Proses Login
Route::post('loginauth',[AuthController::class,'login'])->name('loginauth');


Route::group(['middleware' => ['auth']], function(){
    // Admin Dashboard
    Route::group(['middleware' => ['cekrole:admin']], function(){
        Route::get('admin',Dashboard::class)->name('admin.dashboard');
    });
});
