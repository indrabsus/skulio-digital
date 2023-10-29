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
    Route::get('admin.dashboard', Dashboard::class)->name('admin.dashboard');

    // Now, move the Menu::all() and route definition here
    $data = DB::table('menu')->get();
    foreach ($data as $item) {
        // Determine the middleware based on $item->parent
        $middleware = 'cekrole:' . $item->akses_role;

        // Define the route without grouping
        Route::middleware($middleware)->get($item->path, $item->class)->name($item->name);
    };
});
