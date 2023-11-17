<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\LogCheat;
use App\Models\LogUjian;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
    public function token($id){
        $data = Ujian::where('id_ujian', $id)
        ->first();

        return view('ujian.token', compact('data'));
    }
    public function masukUjian(Request $request){
        $tokenini = $request->ctoken;
        $rtoken = $request->token;
        $id_ujian = $request->id_ujian;

        if($rtoken == $tokenini){
            $test = DB::table('ujian')->where('id_ujian',$id_ujian)->first();
            $data = DB::table('data_siswa')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_kelas')
            ->where('data_siswa.id_user', Auth::user()->id)
            ->first();
            if(Session::get('start') == null){
                Session::put('start', time());
            }
            Session::put('id_ujian', $id_ujian);
            Session::put('nama_ujian', $test->nama_ujian);
            Session::put('nama_kelas',$data->nama_kelas);
            $end = Session::get('start') + $test->waktu * 60 *1000;
            $sisa = $end - time();
            $us = DataSiswa::where('id_user', Auth::user()->id)->first();
            $cek = LogUjian::where('id_ujian', Session::get('id_ujian'))
            ->where('id_siswa', $us->id_siswa)
            ->count();

        if( $cek < 1){
            return redirect()->route('test');
        } else {
        Session::flush();
            return redirect()->route('dashboard')->with('sukses', 'Anda sudah menyelesaikan Test tersebut');
        }

            // return redirect()->route('test');
        } else {
            return redirect()->route('dashboard')->with('gagal', 'Kode Token Salah');
        }
    }
    public function done(){
        $us = DataSiswa::where('id_user', Auth::user()->id)->first();
        LogUjian::create([
            'id_ujian' => Session::get('id_ujian'),
            'id_siswa' => $us->id_siswa,
            'nama' => $us->nama_lengkap,
            'nama_kelas' => Session::get('nama_kelas'),
            'nama_ujian' => Session::get('nama_ujian'),
            'status' => 'done'
        ]);

        Auth::logout();
        Session::flush();
        return redirect()->route('dashboard')->with('status', 'Anda berhasil logout');
    }
    public function test(){
        $id = Session::get('id_ujian');
        $test = DB::table('ujian')->where('id_ujian',$id)->first();
        $us = DataSiswa::where('id_user', Auth::user()->id)->first();
        if($test->id_ujian )
        LogUjian::create([
            'id_ujian' => Session::get('id_ujian'),
            'id_siswa' => $us->id_siswa,
            'nama' => $us->nama_lengkap,
            'nama_kelas' => Session::get('nama_kelas'),
            'nama_ujian' => Session::get('nama_ujian'),
            'status' => 'proses'
        ]);
        return view('ujian.test', compact('test'));
    }
    public function logc(){
        $us = DataSiswa::where('id_user', Auth::user()->id)->first();
        $cek = LogCheat::where('id_ujian', Session::get('id_ujian'))
                        ->where('id_siswa', $us->id_siswa)
                        ->count();
        if($cek < 1) {
            LogCheat::create([
                'id_ujian' => Session::get('id_ujian'),
                'id_siswa' => $us->id_siswa,
            ]);
            $nama = $us->nama_lengkap;
            $tokenTelegram = '6019753763:AAGy5F-9h3jAKgLM38AhaiIM5LZ3oyYfXFM';
            $grupId = -926083732;
            $kelas = Session::get('nama_kelas');
            $ujian = Session::get('nama_ujian');
            $text = $nama." dari kelas ".$kelas." dalam ujian ".$ujian;
            Http::get('https://api.telegram.org/bot'.$tokenTelegram.'/sendMessage?chat_id='.$grupId.'&text='.$text." terdeteksi melakukan kecurangan.");
        }
        return redirect()->route('test');
    }
}
