<?php

namespace App\Http\Controllers;

use App\Models\JurusanPpdb;
use App\Models\LogPpdb;
use App\Models\MasterPpdb;
use App\Models\SiswaBaru;
use App\Models\SiswaPpdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PPDBController extends Controller
{
    public function formppdb(){
        $jurusan = JurusanPpdb::leftJoin('master_ppdb','master_ppdb.id_ppdb','jurusan_ppdb.id_ppdb')
        ->where('tahun', date('Y'))
        ->get();
        return view('ppdb.formppdb',compact('jurusan'));
    }

    public function postppdb(Request $request)
{
    $request->validate([
        'nisn' => 'required|unique:siswa_ppdb|numeric',
        'nama_lengkap' => 'required',
        'jenkel' => 'required',
        'asal_sekolah' => 'required',
        'nohp' => 'required|numeric',
        'tanggal_lahir' => 'required|date',
        'agama' => 'required',
        'ayah' => 'required',
        'nik_siswa' => 'required|numeric',
        'ibu' => 'required',
        'tempat_lahir' => 'required',
        'jalan' => 'required',
        'rtrw' => 'required',
        'kelurahan' => 'required',
        'kecamatan' => 'required',
        'kota' => 'required',
        'minat_jurusan1' => 'required',
        'minat_jurusan2' => 'required',
    ]);

    // Format nomor HP
    $nohp = preg_replace('/[^0-9]/', '', $request->nohp);
    if (strpos($nohp, '08') === 0) {
        $nohp = '62' . substr($nohp, 1);
    }

    $siswa = [
        'nisn' => $request->nisn,
        'nama_lengkap' => $request->nama_lengkap,
        'nik_siswa' => $request->nik_siswa,
        'jenkel' => $request->jenkel,
        'asal_sekolah' => $request->asal_sekolah,
        'minat_jurusan1' => $request->minat_jurusan1,
        'minat_jurusan2' => $request->minat_jurusan2,
        'no_hp' => $nohp,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => "Jalan $request->jalan Rt/Rw. $request->rtrw, Kel/Desa. $request->kelurahan, Kec. $request->kecamatan, Kota/Kab. $request->kota",
        'agama' => $request->agama,
        'nama_ayah' => $request->ayah,
        'nama_ibu' => $request->ibu,
        'bayar_daftar' => 'n',
        'tahun' => date('Y'),
    ];

    $set = MasterPpdb::where('tahun', date('Y'))->first();
    $input = SiswaPpdb::create($siswa);

    // Format teks untuk Telegram
    $teks = 'Pemberitahuan, ada siswa baru mendaftar dengan nama ' . $request->nama_lengkap . ', dan asal sekolah dari ' . $request->asal_sekolah . ', no Whatsapp: https://wa.me/' . $nohp;
    Http::post('http://23.0.0.99:3000/notifuser', [
        'nomor' => $nohp,
        'pesan' => 'Terima Kasih sudah mendaftar di PPDB SMK Sangkuriang 1 Cimahi, untuk pembayaran silakan langsung datang ke Ruang PPDB SMK Sangkuriang 1 Cimahi. Terima Kasih',
    ]);
    $response = Http::get('https://api.telegram.org/bot' . $set->token_telegram . '/sendMessage', [
        'chat_id' => $set->chat_id,
        'text' => $teks,
    ]);

    return redirect()->route('formppdb')->with('status', 'Anda Sudah Berhasil Daftar, untuk pembayaran silakan langsung datang ke Ruang PPDB SMK Sangkuriang 1 Cimahi. Terima Kasih');
}

    public function detailppdb(){
        $sudahdaftar = SiswaPpdb::where('bayar_daftar','y')->count();
        $all = SiswaPpdb::count();
        $akuntansi = SiswaPpdb::where('minat_jurusan1','LIKE','%'.'Akuntansi'.'%')->where('bayar_daftar','n')->count();
        $mplb = SiswaPpdb::where('minat_jurusan1','LIKE','%'.'MPLB'.'%')->where('bayar_daftar','n')->count();
        $pplg = SiswaPpdb::where('minat_jurusan1','LIKE','%'.'PPLG'.'%')->where('bayar_daftar','n')->count();
        $bisnis = SiswaPpdb::where('minat_jurusan1','LIKE','%'.'Bisnis'.'%')->where('bayar_daftar','n')->count();


        //fix asli
        $ak = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'AKL'.'%')->count();
        $pm = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'BDP'.'%')->count();
        $rpl = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'PPLG'.'%')->count();
        $mp = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'MPLB'.'%')->count();


        $ak_a = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'Akuntansi Antrian'.'%')->count();
        $pm_a = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'Pemasaran Antrian'.'%')->count();
        $rpl_a = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'RPL Antrian'.'%')->count();
        $mp_a = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'Perkantoran Antrian'.'%')->count();
        return view('load.ppdb.detailppdb',compact('akuntansi','mplb','pplg','bisnis','sudahdaftar','all','ak','pm','rpl','mp','ak_a','pm_a','rpl_a','mp_a'));
    }
    public function loadppdb(){
        $sudahdaftar = LogPpdb::where('jenis','d')->count();
        $ak = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'AK'.'%')->count();
        $pm = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'PM'.'%')->count();
        $rpl = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'PPLG'.'%')->count();
        $mp = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
        ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
        ->where('nama_kelas','LIKE','%'.'MPLB'.'%')->count();
        return view('load.ppdb.loadppdb');
    }
    public function wameform(){
        return view('wame');
    }
    public function wapost(Request $request)
    {
        $nowa = $request->input('nowa');

        // Menghapus semua karakter yang bukan angka
        $nowa = preg_replace('/[^0-9]/', '', $nowa);

        // Menghapus awalan '0' jika ada
        if (substr($nowa, 0, 1) == '0') {
            $nowa = substr($nowa, 1);
        }

        $link = "https://wa.me/62" . $nowa;
        return redirect()->away($link);
    }
}
