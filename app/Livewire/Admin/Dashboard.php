<?php

namespace App\Livewire\Admin;

use App\Models\Jurusan;
use Livewire\Component;

class Dashboard extends Component
{
    public $nama_jurusan;
    public function render()
    {
        $data  = Jurusan::all();
        return view('livewire.admin.dashboard', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_jurusan' => 'required'
        ]);
        $data = Jurusan::create([
            'nama_jurusan' => $this->nama_jurusan
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->dispatch('closeModal');
    }
}
