<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\KategoriSoal;
use App\Models\KelasSumatif;
use App\Models\LogUjian2;
use App\Models\NilaiUjian;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Exam2Controller extends Controller
{
    public function token($id){
        $data = KelasSumatif::leftJoin('kategori_soal','kategori_soal.id_kategori','kelas_sumatif.id_kategori')
            ->where('id_kelassumatif', $id)
        ->first();
        // dd($data);
        return view('ujian2.token', compact('data'));
    }

    public function masukUjian(Request $request){
        $tokenini = $request->ctoken;
        $rtoken = $request->token;
        $id_kelassumatif = $request->id_kelassumatif;

        if($rtoken == $tokenini){
            $test = DB::table('kelas_sumatif')->leftJoin('kategori_soal','kategori_soal.id_kategori','kelas_sumatif.id_kategori')
            ->where('id_kelassumatif',$id_kelassumatif)->first();
            // dd($test->waktu);
            $data = DB::table('data_siswa')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_kelas')
            ->where('data_siswa.id_user', Auth::user()->id)
            ->first();
            if(Session::get('start') == null){
                Session::put('start', time());
            }
            Session::put('id_kelassumatif', $id_kelassumatif);
            $end = Session::get('start') + $test->waktu * 60 *1000;
            $sisa = $end - time();
            $us = DataSiswa::where('id_user', Auth::user()->id)->first();
            $cek = LogUjian2::where('id_kelassumatif', Session::get('id_kelassumatif'))
            ->where('id_user', Auth::user()->id)
            ->where('status','done')
            ->count();

        if( $cek < 1){
            LogUjian2::create([
            'id_kelassumatif' => Session::get('id_kelassumatif'),
            'id_user' => $us->id_user,
            'status' => 'proses'
        ]);
            return redirect()->route('test2');
        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('loginpage')->with('sukses', 'Anda sudah menyelesaikan Test tersebut');
        }

            // return redirect()->route('test');
        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('loginpage')->with('gagal', 'Kode Token Salah');
        }
    }
    public function test()
{
    $idKelassumatif = Session::get('id_kelassumatif');

    // Ambil data dari tabel kelas_sumatif dan kategori_soal
    $test = DB::table('kelas_sumatif')
        ->leftJoin('kategori_soal', 'kategori_soal.id_kategori', '=', 'kelas_sumatif.id_kategori')
        ->where('kelas_sumatif.id_kelassumatif', $idKelassumatif)
        ->first();

    // Ambil data dari kelas_sumatif, kategori_soal, dan soal
    $data = KelasSumatif::leftJoin('kategori_soal', 'kategori_soal.id_kategori', '=', 'kelas_sumatif.id_kategori')
        ->leftJoin('soal', 'soal.id_kategori', '=', 'kategori_soal.id_kategori')
        ->where('kelas_sumatif.id_kelassumatif', $idKelassumatif)
        ->select('kelas_sumatif.*', 'kategori_soal.nama_kategori', 'soal.*') // Pilih kolom yang dibutuhkan
        ->get();

    // Acak soal
    $data = $data->shuffle();

    // Acak pilihan untuk setiap soal
    $data->transform(function ($soal) {
        $options = [
            'a' => $soal->pilihan_a,
            'b' => $soal->pilihan_b,
            'c' => $soal->pilihan_c,
            'd' => $soal->pilihan_d,
            'e' => $soal->pilihan_e,
        ];
        $shuffledOptions = collect($options)->shuffle();
        $soal->options = $shuffledOptions->pluck('value', 'key')->toArray();
        $soal->correct_answer = array_search($soal->jawaban, $soal->options);
        return $soal;
    });

    return view('ujian2.test', compact('test', 'data'));
}

    public function done(){
        LogUjian2::where('id_kelassumatif', Session::get('id_kelassumatif'))
        ->where('id_user', Auth::user()->id)
        ->update([
            'status' => 'done'
        ]);

        Auth::logout();
        Session::flush();
        return redirect()->route('loginpage')->with('sukses', 'Anda sudah menyelesaikan test!');
    }
    public function submitTest(Request $request)
{
    $jumlahBenar = 0;

    // Ambil semua nama input yang dikirimkan, kecuali _token
    $inputNames = array_keys($request->except('_token'));

    // Ekstrak ID soal dari nama input
    $soalIds = array_map(function($name) {
        return str_replace('pilihan_', '', $name);
    }, $inputNames);

    // Ambil data soal dari database berdasarkan ID yang diterima dari form
    $soals = Soal::whereIn('id_soal', $soalIds)->get();

    // Hitung jumlah soal
    $totalSoal = $soals->count();

    // Loop setiap soal dan cek apakah jawaban benar
    foreach ($soals as $soal) {
        $userAnswer = $request->input('pilihan_' . $soal->id_soal);

        // Cek apakah jawaban pengguna sama dengan jawaban yang benar
        if ($userAnswer === $soal->jawaban) {
            $jumlahBenar++;
        }
    }
    $nilaiAkhir = $totalSoal > 0 ? ($jumlahBenar / $totalSoal) * 100 : 0;
    $hitung = NilaiUjian::where('id_kelassumatif', Session::get('id_kelassumatif'))
    ->where('id_user_siswa', Auth::user()->id)->count();
    // Simpan hasil ujian
    if($hitung > 0){
        return redirect()->route('dashboard')->with('gagal', 'Terdeteksi test ganda!');
    } else {
        NilaiUjian::create([
            'id_kelassumatif' => Session::get('id_kelassumatif'),
            'id_user_siswa' => Auth::user()->id,
            'nilai_ujian' => $nilaiAkhir,
        ]);

        LogUjian2::where('id_kelassumatif', Session::get('id_kelassumatif'))
        ->where('id_user', Auth::user()->id)
        ->update([
            'status' => 'done'
        ]);

        Auth::logout();
        Session::flush();
        return redirect()->route('loginpage')->with('sukses', 'Anda sudah menyelesaikan test!');
    }

}

}
