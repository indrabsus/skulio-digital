<?php

namespace App\Exports;

use App\Models\Absen;
use App\Models\BosRealisasi;
use App\Models\DataUser;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Pengajuan implements FromView
{
    public $thn, $sts;
    public function __construct($thn, $sts)
    {
        $this->thn = $thn;
        $this->sts = $sts;
    }

    public function view(): View
    {
        return view('xls.pengajuan', [
        'data' => BosRealisasi::leftJoin('pengajuan','pengajuan.id_pengajuan','bos_realisasi.id_pengajuan')
        ->leftJoin('roles','roles.id_role','pengajuan.id_role')
        ->orderBy('bos_realisasi.id_pengajuan','desc')
        ->where('tahun_arkas', $this->thn)
        ->where('status', $this->sts)
        ->get()
        ]);
    }
}
