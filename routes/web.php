<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cigalert;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FingerPrint;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\UserController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\UbahPassword;
use App\Livewire\Kurikulum\TambahKartuSiswa;
use App\Livewire\Manajemen\TambahKartu;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//Detail PPDB
// Route::get('detailppdb',[PPDBController::class,'detailppdb'])->name('detailppdb');
// Route::get('loadppdb',[PPDBController::class,'loadppdb'])->name('loadppdb');

// Fingerprint
Route::get('user',[FingerPrint::class,'user'])->name('userfp');
Route::get('clear',[FingerPrint::class,'clear'])->name('clear');
Route::get('rawlogsc',[FingerPrint::class,'rawlogsc'])->name('rawlogsc');
Route::get('rawlog',[FingerPrint::class,'rawlog'])->name('rawlog');
Route::any('insertuser',[FingerPrint::class,'insertUser'])->name('insertuserfp');

//PPDB
Route::get('laporanppdb',[PPDBController::class,'laporan'])->name('laporan');


//Excel Controller
Route::get('exportabsen/{bln?}/{jbtn?}', [ExcelController::class, 'absen'])->name('absenxls');

//RFID Controller
Route::get('/rfid/{norfid}/{id_mesin}',[RFIDController::class,'rfidglobal'])->name('rfidglobal');
Route::get('/inputscan', [RFIDController::class, 'inputscan'])->name('inputscan');
Route::get('/topup', [RFIDController::class, 'topup'])->name('topup');
Route::get('/payment', [RFIDController::class, 'payment'])->name('payment');
Route::get('/reset', [RFIDController::class, 'reset'])->name('reset');

//Cigalert
Route::get('/tabelcigalert', function(){
    return view('load.tabelcigalert');
})->name('tabelcigalert');
Route::get('/cigalert/{nama_mesin}/{value}', [Cigalert::class, 'postSensor'])->name('postsensor');


Route::post('/topupproses', [RFIDController::class, 'topupProses'])->name('topupproses');
Route::post('/paymentproses', [RFIDController::class, 'paymentProses'])->name('paymentproses');
Route::post('/insertuser', [RFIDController::class, 'insertuser'])->name('insertuser');
Route::post('/insertsiswa', [RFIDController::class, 'insertsiswa'])->name('insertsiswa');
Route::post('/sesimesin', function(Request $request) {
        session(['kode_mesin' => $request->kode_mesin]);
        return redirect()->route('admin.datakaryawan');
})->name('sesimesin');



Route::get('printTabunganBulanan',[PdfController::class,'printTabunganBulanan'])->name('printTabunganBulanan');
Route::get('rekapharianppdb',[PdfController::class,'rekapharianppdb'])->name('rekapharianppdb');

//Login Page
Route::get('/',[AuthController::class,'loginpage'])->name('loginpage');
Route::get('/lupausername',[AuthController::class,'lupausername'])->name('lupausername');
Route::get('/register',[AuthController::class,'registerpage'])->name('registerpage');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/{id_log}/printLog', [PdfController::class, 'printLog'])->name('printLog');
Route::get('/{id_log}/ppdbLog', [PdfController::class, 'siswaPpdb'])->name('ppdbLog');

Route::get('ppdb',[PPDBController::class,'formppdb'])->name('formppdb');
Route::post('postppdb',[PPDBController::class,'postppdb'])->name('postppdb');
//Proses Login
Route::post('loginauth',[AuthController::class,'login'])->name('loginauth');
Route::post('regproses',[AuthController::class,'register'])->name('register');


Route::group(['middleware' => ['auth']], function(){

    Route::get('/tambahkartu', TambahKartu::class)->name('admin.tambahkartu');
    Route::get('/tambahkartusiswa', TambahKartuSiswa::class)->name('admin.tambahkartusiswa');

    Route::get('deletenilai/{id}',[NilaiController::class,'hapusNilai'])->name('hapusnilai');
    Route::any('/updatepassword',[AuthController::class,'updatePassword'])->name('updatepassword');
    Route::get('/ubahpass', UbahPassword::class)->name('ubahpassword');


    Route::get('/listtest',[ExamController::class,'listTest'])->name('listtest');
    Route::get('{id}/token/',[ExamController::class,'token'])->name('token');
    Route::any('cektoken', [ExamController::class,'masukUjian'])->name('cektoken');
    Route::get('done',[ExamController::class,'done'])->name('done');
    Route::get('cit',[ExamController::class,'logc'])->name('cit');

    Route::group(['middleware' => ['test']], function(){
        Route::get('siswa/test', [ExamController::class,'test'])->name('test');


    });


    Route::get('absen',[UserController::class,'absen'])->name('absen');
    Route::any('ayoabsen',[UserController::class,'ayoabsen'])->name('ayoabsen');
    Route::get('dashboard',Dashboard::class)->name('dashboard');
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
