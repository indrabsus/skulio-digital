<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


//Login Page
Route::get('/',[AuthController::class,'loginpage'])->name('loginpage');
//Proses Login
Route::post('loginauth',[AuthController::class,'login'])->name('loginauth');


Route::group(['middleware' => ['auth']], function(){
    // Admin Dashboard
    Route::group(['middleware' => ['cekrole:admin']], function(){
        Route::get('admin',[AdminController::class,'home'])->name('admin.home');
    });
});
