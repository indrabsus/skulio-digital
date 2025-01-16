<?php

namespace App\Livewire\Ppdb;

use App\Models\LogPpdb;
use App\Models\MasterPpdb;
use App\Models\SiswaPpdb;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Laporan extends Component
{
    public $thn_ppdb;

    public function mount(){
        $this->thn_ppdb = date('Y');
    }
    public function render()
    {
        $daftar = MasterPpdb::where('tahun', $this->thn_ppdb)->first();
        $pendaftar = SiswaPpdb::where('tahun', $this->thn_ppdb)->count();
        $hanyadaftar = LogPpdb::where('jenis', 'd')
        ->where('log_ppdb.created_at', 'like', '%'.$this->thn_ppdb.'%')
    ->whereNotIn('id_siswa', function($query) {
        $query->select('id_siswa')
              ->from('log_ppdb')
              ->where('jenis', 'p');
    })
    ->distinct()
    ->count('id_siswa');

        $mengundurkan = SiswaPpdb::where('bayar_daftar', '=', 'l')
        ->where('tahun', $this->thn_ppdb)
        ->count();
        $noaction = SiswaPpdb::where('bayar_daftar', '=', 'n')
        ->where('tahun', $this->thn_ppdb)
        ->count();
        $sudahdaftar = SiswaPpdb::where('bayar_daftar','y')
        ->where('tahun', $this->thn_ppdb)
        ->count();
        $kurangsejuta = LogPpdb::groupBy('id_siswa')
        ->where('jenis','p')
        ->where('log_ppdb.created_at', 'like', '%'.$this->thn_ppdb.'%')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '<', 1000000)
        ->count();
        $lebihsejuta = LogPpdb::groupBy('id_siswa')
        ->where('jenis','p')
        ->where('log_ppdb.created_at', 'like', '%'.$this->thn_ppdb.'%')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '>=', 1000000)
        ->having('total_pembayaran', '<', $daftar->ppdb)
        ->count();
        $lunas = LogPpdb::groupBy('id_siswa')
        ->where('jenis','p')
        ->where('log_ppdb.created_at', 'like', '%'.$this->thn_ppdb.'%')
        ->select('id_siswa', DB::raw('SUM(nominal) as total_pembayaran'))
        ->having('total_pembayaran', '=', $daftar->ppdb)
        ->count();
        $uangdaftar = LogPpdb::where('jenis', 'd')
        ->where('log_ppdb.created_at', 'like', '%'.$this->thn_ppdb.'%')
        ->sum('nominal');
        $uangppdb = LogPpdb::where('jenis', 'p')
        ->where('log_ppdb.created_at', 'like', '%'.$this->thn_ppdb.'%')
        ->sum('nominal');
        $uangundur= LogPpdb::where('jenis', 'l')
        ->where('log_ppdb.created_at', 'like', '%'.$this->thn_ppdb.'%')
        ->sum('nominal');
        return view('livewire.ppdb.laporan',compact('pendaftar','sudahdaftar','kurangsejuta','lebihsejuta','lunas','hanyadaftar','mengundurkan','uangdaftar','uangppdb','uangundur','noaction'));
    }
}
