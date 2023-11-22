<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\KelasPpdb as TabelKelasPpdb;
use Livewire\WithPagination;

class KelasPpdb extends Component
{
    public $id_kelas, $nama_kelas, $max;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  =  TabelKelasPpdb::orderBy('id_kelas','desc')->where('nama_kelas', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.ppdb.kelas-ppdb', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_kelas' => 'required',
            'max' => 'required',
        ]);
        $data =  TabelKelasPpdb::create([
            'nama_kelas' => $this->nama_kelas,
            'max' => $this->max,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_kelas = '';
        $this->max  = '';
    }
    public function edit($id){
        $data = TabelKelasPpdb::where('id_kelas', $id)->first();
        $this->nama_kelas = $data -> nama_kelas;
        $this->max =  $data -> max;
        $this->id_kelas =  $data -> id_kelas;
    }
    public function update(){
        $this->validate([
            'nama_kelas' => 'required',
            'max' => 'required',
        ]);
        $data =  TabelKelasPpdb::where('id_kelas', $this->id_kelas)->update([
            'nama_kelas' => $this->nama_kelas,
            'max' => $this->max,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_kelas= $id;
    }
    public function delete(){
        TabelKelasPpdb::where('id_kelas',$this->id_kelas)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}



