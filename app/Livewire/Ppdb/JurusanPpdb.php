<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\JurusanPpdb as TabelJurusanPpdb;
use App\Models\MasterPpdb;
use Livewire\WithPagination;

class JurusanPpdb extends Component
{
    public $id_jurusan, $nama_jurusan, $id_ppdb;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $master_ppdb = MasterPpdb::all();
        $data  = TabelJurusanPpdb ::leftJoin('master_ppdb','master_ppdb.id_ppdb','jurusan_ppdb.id_ppdb')->orderBy('id_jurusan','desc')->where('nama_jurusan', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.ppdb.jurusan-ppdb', compact('data','master_ppdb'));
    }
    public function insert(){
        $this->validate([
            'nama_jurusan' => 'required',
            'id_ppdb' => 'required',
        ]);
        $data = TabelJurusanPpdb::create([
            'nama_jurusan' => $this->nama_jurusan,
            'id_ppdb' => $this->id_ppdb,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nama_jurusan = '';
        $this->id_ppdb  = '';
    }
    public function edit($id){
        $data = TabelJurusanPpdb::where('id_jurusan', $id)->first();
        $this->nama_jurusan = $data -> nama_jurusan;
        $this->id_ppdb  =  $data -> id_ppdb;
        $this->id_jurusan =  $data -> id_jurusan;
    }
    public function update(){
        $this->validate([
            'nama_jurusan' => 'required',
            'id_ppdb' => 'required',
        ]);
        $data = TabelJurusanPpdb::where('id_jurusan', $this->id_jurusan)->update([
            'nama_jurusan' => $this->nama_jurusan,
            'id_ppdb' => $this->id_ppdb,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_jurusan= $id;
    }
    public function delete(){
        TabelJurusanPpdb::where('id_jurusan',$this->id_jurusan)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}


