<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\LogPpdb as TabelLogPpdb;
use App\Models\SiswaPpdb;
use Livewire\WithPagination;

class LogPpdb extends Component
{
    public $id_log, $id_siswa, $nominal , $jenis;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $siswa_ppdb = SiswaPpdb::all();
        $data  = TabelLogPpdb ::leftJoin('siswa_ppdb','siswa_ppdb.id_siswa','log_ppdb.id_siswa')->orderBy('id_log','desc')->where('nama_lengkap', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.ppdb.log-ppdb', compact('data','siswa_ppdb'));
    }
    public function insert(){
        $this->validate([
            'nominal' => 'required',
            'id_siswa' => 'required',
            'jenis' => 'required',
        ]);
        $data = TabelLogPpdb::create([
            'nominal' => $this->nominal,
            'id_siswa' => $this->id_siswa,
            'jenis' => $this->jenis,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->nominal = '';
        $this->id_siswa = '';
        $this->jenis = '';
    }
    public function edit($id){
        $data = TabelLogPpdb::where('id_log', $id)->first();
        $this->nominal = $data -> nominal;
        $this->id_siswa  =  $data -> id_siswa;
        $this->jenis  =  $data -> jenis;
        $this->id_log =  $data -> id_log;
    }
    public function update(){
        $this->validate([
            'nominal' => 'required',
            'id_siswa' => 'required',
            'jenis' => 'required',
        ]);
        $data = TabelLogPpdb::where('id_log', $this->id_log)->update([
            'nominal' => $this->nominal,
            'id_siswa' => $this->id_siswa,
            'jenis' => $this->jenis,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_log= $id;
    }
    public function delete(){
        TabelLogPpdb::where('id_log',$this->id_log)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}


