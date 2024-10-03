<?php

namespace App\Http\Controllers;

use App\Exports\AbsenBulanan;
use App\Exports\Pengajuan;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function absen($bln, $jbtn)
    {
        return Excel::download(new AbsenBulanan($bln, $jbtn), 'persentase-'.$jbtn.'-'.$bln.'.xlsx');
    }
    public function pengajuan($thn, $sts, $prsn)
    {
        return Excel::download(new Pengajuan($thn, $sts, $prsn), 'pengajuan-'.$thn.'.xlsx');
    }

    public function importSiswa(Request $request)
{
    $id_kelas = $request->input('id_kelas');

    Excel::import(new SiswaImport($id_kelas), $request->file('file'));

    return redirect()->back()->with('sukses', 'Data berhasil diimport!');
}


}
