<?php

namespace App\Exports;

use App\Models\Absen;
use App\Models\BosRealisasi;
use App\Models\DataUser;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Pengajuan implements FromView
{
    public $thn;
    public function __construct($thn)
    {
        $this->thn = $thn;
    }

    public function view(): View
    {
        return view('xls.pengajuan', [
        'data' => BosRealisasi::leftJoin('pengajuan','pengajuan.id_pengajuan','bos_realisasi.id_pengajuan')
        ->leftJoin('roles','roles.id_role','pengajuan.id_role')
        ->orderBy('bos_realisasi.id_pengajuan','desc')
        ->where('tahun_arkas', $this->thn)
        ->get()
        ]);
    }
}
