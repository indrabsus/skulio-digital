<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\PdfController;
use App\Livewire\Admin\Dashboard;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;



Route::get('/listtest',[ExamController::class,'listTest'])->name('listtest');

//Login Page
Route::get('/',[AuthController::class,'loginpage'])->name('loginpage');
Route::get('/register',[AuthController::class,'registerpage'])->name('registerpage');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/{id_log}/printLog', [PdfController::class, 'printLog'])->name('printLog');

//Proses Login
Route::post('loginauth',[AuthController::class,'login'])->name('loginauth');
Route::post('regproses',[AuthController::class,'register'])->name('register');

Route::group(['middleware' => ['auth']], function(){
    Route::get('app',Dashboard::class)->name('dashboard');
    $set = new Controller;
    // $cek = $set->routeMenu();
    // Now, move the Menu::all() and route definition here
    if(isset($set)){
        $data = $set->routeMenu();
    foreach ($data as $item) {
        // Determine the middleware based on $item->parent
        $middleware = 'cekrole:' . $item->nama_role;
        $path = $item->nama_role.'/'.strtolower(str_replace(' ','', $item->nama_menu));
        $cls = 'App\Livewire\\'.$item->class;
        $rname = $item->nama_role.'.'.strtolower(str_replace(' ','', $item->nama_menu));

        // Define the route without grouping
        Route::middleware($middleware)->get($path, $cls)->name($rname);
    };
    }
});
