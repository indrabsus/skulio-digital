<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;




//Login Page
Route::get('/',[AuthController::class,'loginpage'])->name('loginpage');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

//Proses Login
Route::post('loginauth',[AuthController::class,'login'])->name('loginauth');

Route::group(['middleware' => ['auth']], function(){
    $set = new Controller;
    // Now, move the Menu::all() and route definition here
    $data = $set->routeMenu();
    foreach ($data as $item) {
        // Determine the middleware based on $item->parent
        $middleware = 'cekrole:' . $item->nama_role;
        $path = $item->nama_role.'/'.strtolower(str_replace(' ','', $item->nama_menu));
        $cls = 'App\Livewire\\'.str_replace(' ','', ucwords($item->parent_menu)).'\\'.str_replace(' ','', $item->nama_menu);
        $rname = $item->nama_role.'.'.strtolower(str_replace(' ','', $item->nama_menu));

        // Define the route without grouping
        Route::middleware($middleware)->get($path, $cls)->name($rname);
    };
});
