<?php

namespace App\Http\Controllers;

use App\Exports\AbsenBulanan;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function absen($bln, $jbtn)
    {
        return Excel::download(new AbsenBulanan($bln, $jbtn), 'persentase-'.$jbtn.'-'.$bln.'.xlsx');
    }


}
