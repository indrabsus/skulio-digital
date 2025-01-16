<?php

namespace App\Livewire\Ppdb;

use Livewire\Component;
use App\Models\MasterPpdb as TabelPpdb;
use Livewire\WithPagination;

class MasterPpdb extends Component
{
    public $id_ppdb, $daftar, $ppdb, $token_telegram, $chat_id, $tahun;
    use WithPagination;
    
    public $cari = '';
    public $result = 10;
    public function render()
    {
        $data  = TabelPpdb::orderBy('id_ppdb','desc')->where('daftar', 'like','%'.$this->cari.'%')->paginate($this->result);
        return view('livewire.ppdb.master-ppdb', compact('data'));
    }
    public function insert(){
        $this->validate([
            'daftar' => 'required',
            'ppdb' => 'required',
            'token_telegram' => 'required',
            'chat_id' => 'required',
            'tahun' => 'required'
        ]);
        $data = TabelPpdb::create([
            'daftar' => $this->daftar,
            'ppdb' => $this->ppdb,
            'token_telegram' => $this->token_telegram,
            'chat_id' => $this->chat_id,
            'tahun' => $this->tahun,
        ]) ;
        session()->flash('sukses','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function clearForm(){
        $this->daftar = '';
        $this->ppdb  = '';
        $this->token_telegram  = '';
        $this->chat_id  = '';
        $this->tahun = '';
    }
    public function edit($id){
        $data = TabelPpdb::where('id_ppdb', $id)->first();
        $this->daftar = $data -> daftar;
        $this->ppdb  =  $data -> ppdb;
        $this->token_telegram  =  $data -> token_telegram;
        $this->chat_id  =  $data -> chat_id;
        $this->tahun =  $data -> tahun;
        $this->id_ppdb = $data->id_ppdb;
    }
    public function update(){
        $this->validate([
            'daftar' => 'required',
            'ppdb' => 'required',
            'token_telegram' => 'required',
            'chat_id' => 'required',
            'tahun' => 'required'
        ]);
        $data = TabelPpdb::where('id_ppdb', $this->id_ppdb)->update([
            'daftar' => $this->daftar,
            'ppdb' => $this->ppdb,
            'token_telegram' => $this->token_telegram,
            'chat_id' => $this->chat_id,
            'tahun' => $this->tahun,
        ]);
        session()->flash('sukses','Data berhasil diedit');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
    public function c_delete($id){
        $this->id_ppdb = $id;
    }
    public function delete(){
        TabelPpdb::where('id_ppdb',$this->id_ppdb)->delete();
        session()->flash('sukses','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatch('closeModal');
    }
}

