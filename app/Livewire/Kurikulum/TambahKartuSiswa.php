<?php

namespace App\Livewire\Kurikulum;

use App\Models\DataSiswa;
use Livewire\Component;

class TambahKartuSiswa extends Component
{
    public function render()
    {
        if(isset($_GET['id_user'])) {
            $data = DataSiswa::where('id_user', $_GET['id_user'])->first();
            return view('livewire.kurikulum.tambah-kartu-siswa', compact('data'));
        } else {
            return view('livewire.kurikulum.tambah-kartu-siswa');
        }
    }
}
