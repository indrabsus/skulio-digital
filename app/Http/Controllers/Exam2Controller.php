<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\JawabanSiswa;
use App\Models\KategoriSoal;
use App\Models\KelasSumatif;
use App\Models\LogUjian2;
use App\Models\NilaiUjian;
use App\Models\Opsi;
use App\Models\Soal;
use App\Models\SoalUjian;
use App\Models\Sumatif;
use App\Models\TampungSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Exam2Controller extends Controller
{
    public function token($id){
        $data = Sumatif::leftJoin('soal_ujian','soal_ujian.id_soalujian','sumatif.id_soalujian')
            ->where('id_sumatif', $id)
        ->first();
        // dd($data);
        return view('ujian2.token', compact('data'));
    }

    public function masukUjian(Request $request){
        $tokenini = $request->ctoken;
        $rtoken = $request->token;
        $id_sumatif = $request->id_sumatif;

        if($rtoken == $tokenini){
            $test = Sumatif::where('id_sumatif',$id_sumatif)->first();
            // dd($test->waktu);
            $data = DB::table('data_siswa')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_kelas')
            ->where('data_siswa.id_user', Auth::user()->id)
            ->first();
            if(Session::get('start') == null){
                Session::put('start', time());
            }
            Session::put('id_sumatif', $id_sumatif);
            $end = Session::get('start') + $test->waktu * 60 *1000;
            $sisa = $end - time();
            $us = DataSiswa::where('id_user', Auth::user()->id)->first();
            // $cek = LogUjian2::where('id_sumatif', Session::get('id_sumatif'))
            // ->where('id_user', Auth::user()->id)
            // ->where('status','done')
            // ->count();

            return redirect()->route('test2');

        // if( $cek < 1){
        //     LogUjian2::create([
        //     'id_sumatif' => Session::get('id_sumatif'),
        //     'id_user' => $us->id_user,
        //     'status' => 'proses'
        // ]);
        //     return redirect()->route('test2');
        // } else {
        //     Session::flush();
        //     Auth::logout();
        //     return redirect()->route('loginpage')->with('sukses', 'Anda sudah menyelesaikan Test tersebut');
        // }

            // return redirect()->route('test');
        } else {
            Session::flush();
            Auth::logout();
            return redirect()->route('loginpage')->with('gagal', 'Kode Token Salah');
        }
    }
    public function test()
{
    $id_sumatif = Session::get('id_sumatif');

    // Ambil data dari tabel kelas_sumatif dan kategori_soal
    $test = Sumatif::where('sumatif.id_sumatif', $id_sumatif)
        ->first();

    // Ambil data dari kelas_sumatif, kategori_soal, dan soal
    $data = Sumatif::where('sumatif.id_sumatif', $id_sumatif)
    ->leftJoin('soal_ujian','soal_ujian.id_soalujian','sumatif.id_soalujian')
    ->leftJoin('tampung_soal','tampung_soal.id_soalujian','soal_ujian.id_soalujian')
    ->leftJoin('soal','soal.id_soal','tampung_soal.id_soal')
        ->get();

    // Acak soal
    $data = $data->shuffle();

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
    public function hitungNilai($id_sumatif, $id_user)
{
    // Ambil jawaban siswa berdasarkan id_sumatif dan id_user
    $nilaiUjian = NilaiUjian::leftJoin('sumatif', 'sumatif.id_sumatif', 'nilai_ujian.id_sumatif')
        ->where('nilai_ujian.id_sumatif', $id_sumatif)
        ->where('id_user_siswa', $id_user)
        ->first();

    // Jika tidak ada data jawaban siswa, kembalikan skor 0
    if (!$nilaiUjian) {
        return 0;
    }

    // Ambil jumlah soal pada ujian
    $jmlSoal = TampungSoal::where('id_soalujian', $nilaiUjian->id_soalujian)->count();

    // Parsing jawaban siswa dari format JSON
    $jawabanSiswa = json_decode($nilaiUjian->jawaban_siswa, true);

    // Jika gagal decode atau jawaban siswa kosong, kembalikan skor 0
    if (!is_array($jawabanSiswa) || empty($jawabanSiswa)) {
        return 0;
    }

    // Variabel untuk menyimpan total skor
    $totalSkor = 0;

    // Iterasi setiap jawaban siswa
    foreach ($jawabanSiswa as $id_soal => $id_opsi) {
        // Periksa apakah opsi yang dipilih siswa adalah jawaban benar
        $opsi = Opsi::where('id_soal', $id_soal)
            ->where('id_opsi', $id_opsi)
            ->where('benar', true)
            ->first();

        // Jika opsi ditemukan dan benar, tambahkan skor
        if ($opsi) {
            $totalSkor++;
        }
    }

    // Hitung skor akhir (dalam persentase)
    return $jmlSoal > 0 ? round(($totalSkor / $jmlSoal) * 100) : 0;
}



public function submitTest(Request $request)
{
    $id_sumatif = Session::get('id_sumatif');
    $id_user = Auth::user()->id;

    // Validasi jika user sudah menyelesaikan tes
    $hitung = NilaiUjian::where('id_sumatif', $id_sumatif)
        ->where('id_user_siswa', $id_user)
        ->count();

    if ($hitung > 0) {
        return redirect()->route('loginpage')->with('gagal', 'Anda sudah menyelesaikan tes!');
    }

    // Ambil semua jawaban
    $jawaban_siswa = [];
    foreach ($request->all() as $key => $value) {
        if (str_starts_with($key, 'opsi_')) {
            $id_soal = str_replace('opsi_', '', $key);
            $jawaban_siswa[$id_soal] = $value;
        }
    }

    // Simpan ke database
    NilaiUjian::create([
        'id_sumatif' => $id_sumatif,
        'id_user_siswa' => $id_user,
        'jawaban_siswa' => json_encode($jawaban_siswa), // Simpan dalam format JSON
    ]);

    return redirect()->route('loginpage')->with('sukses', 'Tes telah selesai!');
}

public function pratinjau($id_nilaiujian){
    $test = NilaiUjian::where('id_nilaiujian', $id_nilaiujian)
        ->leftJoin('data_siswa','data_siswa.id_user','nilai_ujian.id_user_siswa')
        ->leftJoin('sumatif','sumatif.id_sumatif','nilai_ujian.id_sumatif')
        ->first();

    // Ambil data dari kelas_sumatif, kategori_soal, dan soal
    $data = Sumatif::where('sumatif.id_sumatif', $test->id_sumatif)
    ->leftJoin('soal_ujian','soal_ujian.id_soalujian','sumatif.id_soalujian')
    ->leftJoin('tampung_soal','tampung_soal.id_soalujian','soal_ujian.id_soalujian')
    ->leftJoin('soal','soal.id_soal','tampung_soal.id_soal')
        ->get();

    return view('ujian2.pratinjau', compact('data', 'test'));

}

}
