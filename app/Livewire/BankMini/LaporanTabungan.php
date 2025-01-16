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
        $sumkredit = DB::table('log_tabungan')->where('jenis', 'kd')->sum('nominal');
        $sumdebit = DB::table('log_tabungan')->where('jenis', 'db')->sum('nominal');
        $total = $sumkredit - $sumdebit;
        $count = DB::table('log_tabungan')->distinct()->pluck('id_siswa')->count();

       return view('livewire.bank-mini.laporan-tabungan', compact('sumkredit','sumdebit','total', 'count'));
    }
}
