<?php

namespace App\Livewire\Kurikulum;

use Livewire\Component;
use App\Models\Jurusan as TabelJurusan;
use Livewire\WithPagination;

class Jurusan extends Component
{
    public $nama_jurusan, $singkatan, $id_jurusan;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelJurusan::orderBy('id_jurusan','desc')->where('nama_jurusan', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.kurikulum.jurusan', compact('data'));
    }
    public function insert(){
        $this->validate([
            'nama_jurusan' => 'required',
            'singkatan' => 'required'
        ]);
        $data = TabelJurusan::create([
            'nama_jurusan' => $this->nama_jurusan,
            'singkatan' => $this->singkatan
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_jurusan = '';
        $this->singkatan = '';
    }
    public function edit($id){
        $data = TabelJurusan::where('id_jurusan', $id)->first();
        $this->nama_jurusan = $data->nama_jurusan; 
        $this->singkatan = $data->singkatan;
        $this->id_jurusan = $data->id_jurusan;
    }
    public function update(){
        $this->validate([
            'nama_jurusan' => 'required',
            'singkatan' => 'required'
        ]);
        $data = TabelJurusan::where('id_jurusan', $this->id_jurusan)->update([
            'nama_jurusan' => $this->nama_jurusan,
            'singkatan' => $this->singkatan
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_jurusan = $id;
    }
    public function delete(){
        TabelJurusan::where('id_jurusan',$this->id_jurusan)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}
