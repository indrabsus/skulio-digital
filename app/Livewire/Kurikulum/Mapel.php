<?php

namespace App\Livewire\Kurikulum;

use Livewire\Component;
use App\Models\MataPelajaran as TabelMapel;
use Livewire\WithPagination;

class mapel extends Component
{
    public $nama_pelajaran ,$id_mapel ;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelMapel::orderBy('id_mapel','desc')->where('nama_pelajaran', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.kurikulum.mapel', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_pelajaran' => 'required'
        ]);
        $data = TabelMapel::create([
            'nama_pelajaran' => $this->nama_pelajaran,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_pelajaran = '';
    }
    public function edit($id){
        $data = TabelMapel::where('id_mapel', $id)->first();
        $this->nama_pelajaran = $data->nama_pelajaran; 
        $this->id_mapel = $data->id_mapel;
    }
    public function update(){
        $this->validate([
            'nama_pelajaran' => 'required'
        ]);
        $data = TabelMapel::where('id_mapel', $this->id_mapel)->update([
            'nama_pelajaran' => $this->nama_pelajaran
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_mapel = $id;
    }
    public function delete(){
        TabelMapel::where('id_mapel',$this->id_mapel)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}