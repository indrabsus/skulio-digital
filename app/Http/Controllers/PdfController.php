<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\KelasPpdb;
use App\Models\LogPpdb;
use App\Models\LogTabungan;
use App\Models\Setingan;
use App\Models\SiswaBaru;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function printLog($id){
    $data = LogTabungan::leftJoin('data_siswa','data_siswa.id_siswa','log_tabungan.id_siswa')
    ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
    ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
    ->where('id_log_tabungan', $id)->first();
    $pdf = Pdf::loadView('pdf.logtabungan', compact('data'));
     //return $pdf->download('test.pdf');
     return $pdf->stream($data->no_invoice.'-'.str_replace(' ','',strtolower($data->nama_lengkap)).'.pdf');
    }

    public function printTabunganBulanan(Request $request){
        $bln = $request->bln;
        $thn = $request->thn;

        $data = LogTabungan::leftJoin('data_siswa','data_siswa.id_siswa','log_tabungan.id_siswa')
        ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('log_tabungan.updated_at', 'like','%'.$request->thn.'-'.$request->bln.'%')
        ->select('nama_lengkap','tingkat','singkatan','nama_kelas','jenis','nominal','log_tabungan.updated_at')
        ->get();
        $pdf = Pdf::setPaper('a4', 'landscape')->loadView('pdf.logtabunganbulanan', compact('data','bln','thn'));
     //return $pdf->download('test.pdf');
     return $pdf->stream($request->bln.'-'.$request->thn.'-tabungan-siswa.pdf');
    }

    public function siswaPpdb($id){
        $set = Setingan::where('id_setingan', 1)->first();
        $data = LogPpdb::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','log_ppdb.id_siswa')->where('id_log',$id)
        ->select('nama_lengkap','asal_sekolah','nominal','jenis','log_ppdb.created_at','no_invoice','siswa_ppdb.id_siswa')
        ->first();
        $pdf = Pdf::loadView('pdf.logsiswappdb', compact('data','set'));
         //return $pdf->download('test.pdf');
         return $pdf->stream($data->no_invoice.'-'.str_replace(' ','',strtolower($data->nama_lengkap)).'.pdf');
        }

        public function rekapharianppdb(Request $request){
            $date = $request->date;

            $data = LogPpdb::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','log_ppdb.id_siswa')
            ->where('log_ppdb.created_at', 'like','%'.$request->date.'%')
            ->select('nama_lengkap','asal_sekolah','log_ppdb.created_at','jenis','nominal','no_invoice')
            ->get();
            $daftar = LogPpdb::where('log_ppdb.created_at', 'like','%'.$request->date.'%')->where('jenis','d')->sum('nominal');
            $ppdb = LogPpdb::where('log_ppdb.created_at', 'like','%'.$request->date.'%')->where('jenis','p')->sum('nominal');
            $pdf = Pdf::setPaper('a4', 'portrait')->loadView('pdf.rekapharianppdb', compact('data','date','daftar','ppdb'));
         //return $pdf->download('test.pdf');
         return $pdf->stream($request->date.'-ppdb-harian.pdf');
        }

        public function kelasppdb(Request $request){
            $data = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
            ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')

            ->where('siswa_baru.id_kelas', $request->id_kelas)
            ->get();
            $kelas = KelasPpdb::
            leftJoin('jurusan_ppdb','jurusan_ppdb.id_jurusan','kelas_ppdb.id_jurusan')
            ->where('id_kelas', $request->id_kelas)->first();
            $jumlahlaki = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
            ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
            ->where('siswa_baru.id_kelas', $request->id_kelas)
            ->where('siswa_ppdb.jenkel', 'l')->count();
            $jumlahperempuan = SiswaBaru::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','siswa_baru.id_siswa')
            ->leftJoin('kelas_ppdb','kelas_ppdb.id_kelas','siswa_baru.id_kelas')
            ->where('siswa_baru.id_kelas', $request->id_kelas)
            ->where('siswa_ppdb.jenkel', 'p')->count();
            $pdf = Pdf::setPaper('a4', 'portrait')->loadView('pdf.siswakelasppdb', compact('data','kelas','jumlahlaki','jumlahperempuan'));
         //return $pdf->download('test.pdf');
         return $pdf->stream($kelas->nama_kelas.'.pdf');
        }
        public function kelasprint(Request $request){
            $data = DataSiswa::leftJoin('users','users.id','data_siswa.id_user')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->where('data_siswa.id_kelas', $request->id_kelas)
            ->orderBy('nama_lengkap','asc')
            ->get();
            $kelas = Kelas::leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->where('id_kelas', $request->id_kelas)->first();
            $full = $kelas->tingkat.' '.$kelas->nama_jurusan.' '.$kelas->nama_kelas;

            $pdf = Pdf::setPaper('a4', 'portrait')->loadView('pdf.kelas', compact('data','full'));

         return $pdf->stream($full.'.pdf');
        }
}

