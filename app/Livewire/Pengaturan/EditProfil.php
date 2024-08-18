<?php

namespace App\Livewire\Pengaturan;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditProfil extends Component
{
    public function render()
    {
        if(Auth::user()->id_role == 6 || Auth::user()->id_role == 7){
            $data = User::leftJoin('data_user','data_user.id_user','=','users.id')
            ->where('users.id', Auth::user()->id)->first();
        } else {
            $data = User::leftJoin('data_siswa','data_siswa.id_user','=','users.id')
            ->leftJoin('kelas','kelas.id_kelas','data_siswa.id_kelas')
            ->leftJoin('jurusan','jurusan.id_jurusan','kelas.id_jurusan')
            ->where('users.id', Auth::user()->id)->first();
        }

        return view('livewire.pengaturan.edit-profil', compact('data'));
    }
}
