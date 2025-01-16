<?php

namespace App\Livewire\Manajemen;

use App\Models\DataUser;
use Livewire\Component;

class TambahKartu extends Component
{
    public function render()
    {
        if(isset($_GET['id_user'])) {
            $data = DataUser::where('id_user', $_GET['id_user'])->first();
            return view('livewire.manajemen.tambah-kartu', compact('data'));
        } else {
            return view('livewire.manajemen.tambah-kartu');
        }
    }
}
