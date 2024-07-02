<?php

namespace App\Livewire\Ppdb;

use App\Models\LogPpdb;
use App\Models\MasterPpdb;
use App\Models\SiswaPpdb;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Laporan extends Component
{
    public function render()
    {
        $daftar = MasterPpdb::where('tahun',date('Y'))->first();
        $pendaftar = SiswaPpdb::count();
        $hanyadaftar = LogPpdb::groupBy('id_siswa')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '=', $daftar->daftar)
        ->count();
        $mengundurkan = SiswaPpdb::where('bayar_daftar', '=', 'l')
        ->count();
        $noaction = SiswaPpdb::where('bayar_daftar', '=', 'n');
        $sudahdaftar = SiswaPpdb::where('bayar_daftar','y')->count();
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
        return view('livewire.ppdb.laporan',compact('pendaftar','sudahdaftar','kurangsejuta','lebihsejuta','lunas','hanyadaftar','mengundurkan','uangdaftar','uangppdb','uangundur','noaction'));
    }
}
