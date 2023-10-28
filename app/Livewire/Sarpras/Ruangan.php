<?php

namespace App\Livewire\Sarpras;

use Livewire\Component;
use App\Models\Ruangan as TabelRuangan;
use Livewire\WithPagination;
class Ruangan extends Component
{
    public $nama_ruangan ,$id_ruangan ;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelRuangan::where('nama_ruangan', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.sarpras.ruangan', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_ruangan' => 'required'
        ]);
        $data = TabelRuangan::create([
            'nama_ruangan' => $this->nama_ruangan,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_ruangan = '';
    }
    public function edit($id){
        $data = TabelRuangan::where('id_ruangan', $id)->first();
        $this->nama_ruangan = $data->nama_ruangan; 
        $this->id_ruangan = $data->id_ruangan;
    }
    public function update(){
        $this->validate([
            'nama_ruangan' => 'required'
        ]);
        $data = TabelRuangan::where('id_ruangan', $this->id_ruangan)->update([
            'nama_ruangan' => $this->nama_ruangan
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_ruangan = $id;
    }
    public function delete(){
        TabelRuangan::where('id_ruangan',$this->id_ruangan)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
