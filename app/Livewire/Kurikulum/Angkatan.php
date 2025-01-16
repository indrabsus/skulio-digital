<?php

namespace App\Livewire\Kurikulum;

use Livewire\Component;
use App\Models\Angkatan as TabelAngkatan;
use Livewire\WithPagination;

class Angkatan extends Component
{
    public $tahun_masuk, $id_angkatan;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelAngkatan::orderBy('id_angkatan','desc')->where('tahun_masuk', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.kurikulum.angkatan', compact('data'));
    }
    public function insert(){
        $this->validate([
            'tahun_masuk' => 'required'
        ]);
        $data = TabelAngkatan::create([
            'tahun_masuk' => $this->tahun_masuk,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->tahun_masuk = '';
    }
    public function edit($id){
        $data = TabelAngkatan::where('id_angkatan', $id)->first();
        $this->tahun_masuk = $data->tahun_masuk; 
        $this->id_angkatan = $data->id_angkatan;
    }
    public function update(){
        $this->validate([
            'tahun_masuk' => 'required'
        ]);
        $data = TabelAngkatan::where('id_angkatan', $this->id_angkatan)->update([
            'tahun_masuk' => $this->tahun_masuk
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_angkatan = $id;
    }
    public function delete(){
        TabelAngkatan::where('id_angkatan',$this->id_angkatan)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
