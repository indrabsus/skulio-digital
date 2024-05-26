<?php

namespace App\Http\Controllers;

use App\Models\JurusanPpdb;
use App\Models\LogPpdb;
use App\Models\MasterPpdb;
use App\Models\SiswaPpdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PPDBController extends Controller
{
    public function formppdb(){
        $jurusan = JurusanPpdb::all();
        return view('ppdb.formppdb',compact('jurusan'));
    }

    public function postppdb(Request $request){
        $request->validate([
            'nisn' => 'required|unique:siswa_ppdb|numeric',
            'nama_lengkap' => 'required',
            'jenkel' => 'required',
            'asal_sekolah' => 'required',
            'nohp' => 'required|numeric',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'ayah' => 'required',
            'nik_siswa' => 'required',
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

        $siswa = [
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'nik_siswa' => $request->nik_siswa,
            'jenkel' => $request->jenkel,
            'asal_sekolah' => $request->asal_sekolah,
            'minat_jurusan1' => $request->minat_jurusan1,
            'minat_jurusan2' => $request->minat_jurusan2,
            'no_hp' => $request->nohp,
            'tempat_lahir' => "$request->tempat_lahir",
            'tanggal_lahir' => "$request->tanggal_lahir",
            'alamat' => "Jalan $request->jalan Rt/Rw. $request->rtrw, Kel/Desa. $request->kelurahan, Kec. $request->kecamatan, Kota/Kab. $request->kota",
            'agama' => $request->agama,
            'nama_ayah' => $request->ayah,
            'nama_ibu' => $request->ibu,
            'bayar_daftar' => 'n'
        ];
        $set = MasterPpdb::where('tahun', date('Y'))->first();
        $input = SiswaPpdb::create($siswa);
        $teks = 'Pemberitahuan, ada siswa baru mendaftar dengan nama ' . $request->nama_lengkap . ', dan asal sekolah dari ' . $request->asal_sekolah . ', no Whatsapp : https://wa.me/62'. substr($request->nohp, 1);
        $response = Http::get('https://api.telegram.org/bot'.$set->token_telegram.'/sendMessage?chat_id='.$set->chat_id.',&text='.$teks);
        return redirect()->route('formppdb')->with('status', 'Anda Sudah Berhasil Daftar, untuk pembayaran silakan langsung datang ke Ruang PPDB SMK Sangkuriang 1 Cimahi. Terima Kasih');
    }
    public function laporan(){
        $daftar = MasterPpdb::where('tahun',date('Y'))->first();
        $pendaftar = SiswaPpdb::count();
        $hanyadaftar = LogPpdb::groupBy('id_siswa')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '=', $daftar->daftar)
        ->count();
        $mengundurkan = LogPpdb::select('id_siswa')
        ->distinct()
        ->where('jenis', '=', 'l')
        ->get()
        ->count();

        $sudahdaftar = LogPpdb::where('jenis','d')->count();
        $kurangsejuta = LogPpdb::groupBy('id_siswa')
        ->where('jenis','p')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '<', 1000000)
        ->count();
        $lebihsejuta = LogPpdb::groupBy('id_siswa')
        ->where('jenis','p')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '>=', 1000000)
        ->having('total_pembayaran', '<', $daftar->ppdb)
        ->count();
        $lunas = LogPpdb::groupBy('id_siswa')
        ->where('jenis','p')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '=', $daftar->ppdb)
        ->count();
        $uangdaftar = LogPpdb::where('jenis', 'd')->sum('nominal');
        $uangppdb = LogPpdb::where('jenis', 'p')->sum('nominal');
        $uangundur= LogPpdb::where('jenis', 'l')->sum('nominal');

        $set = MasterPpdb::where('tahun', date('Y'))->first();
        $teks = 'Laporan PPDB SMK Sangkuriang 1 Cimahi, Tanggal '.date('d M Y')."\n".
'Pendaftar Total sebanyak '.$pendaftar.' orang,'."\n".
'Pendaftar yang sudah melakukan pembayaran sebanyak '.$sudahdaftar.' orang,'."\n".
'Pendaftar yang belum melakukan pembayaran sebanyak '.($pendaftar - $sudahdaftar).' orang,'."\n".
'Pendaftar yang sudah Lunas sebanyak '.$lunas.' orang,'."\n".
'Pendaftar yang sudah bayar lebih dari 1 Juta sebanyak '.$lebihsejuta.' orang,'."\n".
'Pendaftar yang sudah bayar kurang dari 1 Juta sebanyak '.$kurangsejuta.' anggota';

        Http::get('https://api.telegram.org/bot'.$set->token_telegram.'/sendMessage?chat_id='.$set->chat_id.',&text='.$teks);
        return redirect()->route('loginpage');
    }
}
