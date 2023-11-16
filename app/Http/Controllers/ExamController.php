<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function listTest(){
        $siswa = DataSiswa::leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->where('data_siswa.id_user', Auth::user()->id)
        ->first();
        $data = Ujian::where('acc', 'y')
        ->where('id_kelas', $siswa->id_kelas)
        ->get();
        return view('siswa.list-test', compact('siswa','data'));
    }
}
