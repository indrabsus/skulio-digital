<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\PdfController;
use App\Livewire\Admin\Dashboard;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;



Route::get('/listtest',[ExamController::class,'listTest'])->name('listtest');
Route::get('{id}/token/',[ExamController::class,'token'])->name('token');
Route::any('cektoken', [ExamController::class,'masukUjian'])->name('cektoken');
Route::get('done',[ExamController::class,'done'])->name('done');
Route::get('cit',[ExamController::class,'logc'])->name('cit');


Route::get('printTabunganBulanan',[PdfController::class,'printTabunganBulanan'])->name('printTabunganBulanan');

//Login Page
Route::get('/',[AuthController::class,'loginpage'])->name('loginpage');
Route::get('/register',[AuthController::class,'registerpage'])->name('registerpage');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/{id_log}/printLog', [PdfController::class, 'printLog'])->name('printLog');

//Proses Login
Route::post('loginauth',[AuthController::class,'login'])->name('loginauth');
Route::post('regproses',[AuthController::class,'register'])->name('register');

Route::group(['middleware' => ['auth']], function(){

    Route::group(['middleware' => ['test']], function(){
        Route::get('siswa/test', [ExamController::class,'test'])->name('test');
    });


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
