<?php

namespace App\Livewire\Keuangan;

use App\Models\LogLuarSpp;
use App\Models\LogSpp;
use App\Models\SppPengaturan;
use Livewire\Component;

class Laporan extends Component
{
    public function render()
    {
        $set = SppPengaturan::where('id_spp_pengaturan', '1234awal')->first();
        $spp = LogSpp::sum('nominal');
        $masukluarspp = LogLuarSpp::where('status', 'm')->sum('nominal');
        $pengeluaran = LogLuarSpp::where('status', 'k')->sum('nominal');
        return view('livewire.keuangan.laporan', compact('set','spp','masukluarspp','pengeluaran'));
    }
}
