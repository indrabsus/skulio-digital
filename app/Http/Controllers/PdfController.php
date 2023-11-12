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
    return $pdf->stream($data->no_invoice.'-'.str_replace(' ','',strtolower($data->nama_lengkap)).'.pdf');
    }
}
