<?php

namespace App\Http\Controllers;

use App\Models\LogTabungan;
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

    public function printTabunganBulanan($thn, $bln){
        $data = LogTabungan::leftJoin('data_siswa','data_siswa.id_siswa','log_tabungan.id_siswa')
        ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
        ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
        ->where('log_tabungan.updated_at', 'like','%'.$thn.'-'.$bln.'%')
        ->select('nama_lengkap','tingkat','singkatan','nama_kelas','jenis','nominal','log_tabungan.updated_at')
        ->get();
        $pdf = Pdf::setPaper('a4', 'landscape')->loadView('pdf.logtabunganbulanan', compact('data','bln','thn'));
     //return $pdf->download('test.pdf');
     return $pdf->stream($bln.'-'.$thn.'-tabungan-siswa.pdf');
    }
}

