<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\JawabanSiswa;
use App\Models\KategoriSoal;
use App\Models\KelasSumatif;
use App\Models\LogUjian2;
use App\Models\NilaiUjian;
use App\Models\Soal;
use App\Models\Sumatif;
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
            $cek = LogUjian2::where('id_sumatif', Session::get('id_sumatif'))
            ->where('id_user', Auth::user()->id)
            ->where('status','done')
            ->count();

        if( $cek < 1){
            LogUjian2::create([
            'id_sumatif' => Session::get('id_sumatif'),
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
    public function hitungNilai($id_sumatif, $id_user)
{
    // Ambil jawaban siswa berdasarkan id_sumatif dan id_user
    $nilaiUjian = NilaiUjian::where('id_sumatif', $id_sumatif)
                            ->where('id_user_siswa', $id_user)
                            ->first();

    // Jika tidak ada data jawaban siswa, kembalikan skor 0
    if (!$nilaiUjian) {
        return 0;
    }

    // Pecah jawaban siswa yang disimpan sebagai string (misalnya: '1:pilihan_a, 2:pilihan_b') menjadi array
    $jawabanSiswa = explode(', ', $nilaiUjian->jawaban_siswa);

    // Variabel untuk menyimpan total skor
    $totalSkor = 0;

    // Loop setiap jawaban siswa
    foreach ($jawabanSiswa as $jawaban) {
        // Pisahkan id_soal dan jawaban siswa, misalnya '1:pilihan_a' -> ['1', 'pilihan_a']
        list($id_soal, $pilihan_siswa) = explode(':', $jawaban);

        // Ambil jawaban benar dari tabel soal berdasarkan id_soal
        $soal = Soal::find($id_soal);

        // Cek apakah jawaban siswa sama dengan jawaban benar
        if ($soal && $pilihan_siswa == $soal->jawaban) {
            // Jika sama, tambahkan 1 ke skor
            $totalSkor++;
        }
    }
    if($soal->count() == 0){
        return 0;
    } else {
        return ($totalSkor/$soal->count())*100;
    }
    // Kembalikan skor total

}

    public function submitTest(Request $request)
{
    $id_sumatif = Session::get('id_sumatif');
    $id_user = Auth::user()->id;
    $all_answers = [];

        // Loop setiap input jawaban
        foreach ($request->all() as $key => $value) {
            // Cek apakah key merupakan pilihan soal (misalnya 'pilihan_1', 'pilihan_2', dst.)
            if (strpos($key, 'pilihan_') === 0) {
                // Dapatkan id_soal dari key 'pilihan_1' -> id_soal = 1
                $id_soal = str_replace('pilihan_', '', $key);

                // Format jawaban: misalnya "id_soal: pilihan"
                $all_answers[] = $id_soal . ':' . $value;
            }
        }

        // Gabungkan semua jawaban menjadi satu string atau JSON
        $all_answers_string = implode(', ', $all_answers);

        $hitung = NilaiUjian::where('id_sumatif', $id_sumatif)
        ->where('id_user_siswa', $id_user)
        ->count();
        // Simpan ke dalam satu baris di database
        if($hitung > 0){
            return redirect()->route('loginpage')->with('gagal', 'Anda sudah menyelesaikan test!');
        } else {
            NilaiUjian::create([
                'id_sumatif' => $id_sumatif,
                'id_user_siswa'    => $id_user,
                'jawaban_siswa'    => $all_answers_string, // Simpan semua jawaban ke kolom pilihan
            ]);
            dd($this->hitungNilai($id_sumatif, $id_user));
            // Redirect atau tampilkan pesan sukses
            return redirect()->route('loginpage')->with('sukses', 'Anda sudah menyelesaikan test!');
        }


    // $jumlahBenar = 0;

    // // Validasi jawaban yang dikirimkan oleh user
    // $request->validate([
    //     'pilihan_*' => 'required|in:a,b,c,d,e', // Sesuaikan dengan pilihan jawaban yang tersedia
    // ]);

    // // Cegah pengiriman ganda menggunakan session token
    // if (Session::has('form_token_used')) {
    //     return redirect()->route('dashboard')->with('gagal', 'Form ini sudah pernah dikirim.');
    // }
    // // Simpan token agar tidak bisa dikirim ulang
    // Session::put('form_token_used', true);

    // // Ambil semua nama input yang dikirimkan, kecuali _token
    // $inputNames = array_keys($request->except('_token'));

    // // Ekstrak ID soal dari nama input
    // $soalIds = array_map(function($name) {
    //     return str_replace('pilihan_', '', $name);
    // }, $inputNames);

    // // Ambil data soal dari database berdasarkan ID yang diterima dari form
    // $soals = Soal::whereIn('id_soal', $soalIds)->get();

    // // Hitung jumlah soal yang valid dari database
    // $validSoalCount = $soals->count();

    // // Loop setiap soal dan cek apakah jawaban benar
    // foreach ($soals as $soal) {
    //     $userAnswer = $request->input('pilihan_' . $soal->id_soal);

    //     // Cek apakah jawaban pengguna sama dengan jawaban yang benar
    //     if ($userAnswer === $soal->jawaban) {
    //         $jumlahBenar++;
    //     }
    // }

    // // Hitung nilai akhir, pastikan nilai tidak lebih dari 100
    // $nilaiAkhir = $validSoalCount > 0 ? ($jumlahBenar / $validSoalCount) * 100 : 0;
    // if ($nilaiAkhir > 100) {
    //     $nilaiAkhir = 100;
    // }

    // // Cek apakah sudah ada nilai ujian sebelumnya untuk user dan ujian ini
    // $hitung = NilaiUjian::where('id_sumatif', Session::get('id_sumatif'))
    //             ->where('id_user_siswa', Auth::user()->id)
    //             ->count();

    // // Gunakan DB Transaction untuk menjaga integritas data
    // DB::beginTransaction();

    // try {
    //     // Simpan hasil ujian hanya jika belum ada nilai sebelumnya
    //     if ($hitung > 0) {
    //         return redirect()->route('dashboard')->with('gagal', 'Terdeteksi test ganda!');
    //     } else {
    //         // Simpan nilai ujian ke database
    //         NilaiUjian::create([
    //             'id_sumatif' => Session::get('id_sumatif'),
    //             'id_user_siswa' => Auth::user()->id,
    //             'nilai_ujian' => $nilaiAkhir,
    //         ]);

    //         // Update status ujian di LogUjian2 menjadi 'done'
    //         LogUjian2::where('id_sumatif', Session::get('id_sumatif'))
    //             ->where('id_user', Auth::user()->id)
    //             ->update([
    //                 'status' => 'done'
    //             ]);

    //         // Commit transaction jika semuanya sukses
    //         DB::commit();
    //     }

    //     // Logout user setelah selesai ujian
    //     Auth::logout();
    //     Session::flush();

    //     return redirect()->route('loginpage')->with('sukses', 'Anda sudah menyelesaikan test!');
    // } catch (\Exception $e) {
    //     // Rollback jika ada error
    //     DB::rollBack();

    //     return redirect()->route('dashboard')->with('gagal', 'Terjadi kesalahan, silakan coba lagi.');
    // }
}

}
