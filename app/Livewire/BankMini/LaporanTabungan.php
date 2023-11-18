<?php

namespace App\Livewire\BankMini;

use App\Models\DataSiswa;
use Livewire\Component;
use App\Models\LaporanTabungan as TabelLaporan;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LaporanTabungan extends Component
{
    public $tahun_masuk, $id_angkatan;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $this->count = DB::table('log_tabungan')->distinct()->pluck('id_siswa')->count();

        $data  = TabelLaporan::orderBy('id_laporan','desc')->where('jumlah_nasabah', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.bank-mini.laporan-tabungan', compact('data'));
    }

    public $count;


}