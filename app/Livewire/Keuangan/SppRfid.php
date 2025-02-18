<?php

namespace App\Livewire\Keuangan;

use App\Models\DataSiswa;
use App\Models\MasterSpp;
use App\Models\Temp;
use Livewire\Component;

class SppRfid extends Component
{
    public function render()
    {
        $neww = Temp::where('id_mesin', env('KODE_MESIN'))->orderBy('created_at', 'desc')->first();
        // dd($neww);
        $saldo = 0;
        if($neww){
            $data = DataSiswa::leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->where('no_rfid', $neww->norfid)->first();
            $nom = MasterSpp::where('kelas', $data->tingkat)->first();
    }
            return view('livewire.keuangan.spp-rfid', compact('data','nom'));
    }
}
